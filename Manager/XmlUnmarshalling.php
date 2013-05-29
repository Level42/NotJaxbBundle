<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Manager;

use Monolog\Logger;

use Level42\NotJaxbBundle\Mapping\ClassMetadata;
use Level42\NotJaxbBundle\Mapping\ClassMetaDataFactory;
use Doctrine\Common\Cache\Cache;
use \SimpleXmlElement;

/**
 * Manager manages all operations
 */
class XmlUnmarshalling
{
    /**
     * The ClassMetadata factory
     *
     * @var ClassMetadataFactory
     */
    protected $classMetadataFactory;

    /**
     * Array to store root class names
     *
     * @var array
     */
    protected $rootClasses = array();

    /**
     * Manager constructor with required dependecy injection
     *
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function __construct(ClassMetadataFactory $classMetadataFactory)
    {
        $this->setClassMetadataFactory($classMetadataFactory);
    }

    /**
     * Register a root class name for pre-caching
     *
     * @param string $class
     */
    public function registerRootClass($class)
    {
        $this->rootClasses[] = $class;
        return $this;
    }

    /**
     * Unmarshall an XML string into an object graph
     *
     * @param string $xmlString
     * @param string $rootClass
     */
    public function unmarshall($xmlString, $rootClass)
    {
        $metadata = $this->classMetadataFactory->getClassMetadata($rootClass);
        $xml = new SimpleXMLElement($xmlString, null, null,
            $metadata->getNamespace());

        return $this->parseObject($xml, $metadata);
    }

    /**
     * Parse an object from a SimpleXml node
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     */
    protected function parseObject(\SimpleXmlElement $xml, ClassMetadata $metadata)
    {
        if ($xml->getName() != null)
        {
            $class = $metadata->getClassName();
            $obj = new $class();

            $this->parseAttributes($xml, $metadata, $obj);
            $this->parseElements($xml, $metadata, $obj);
            $this->parseEmbeds($xml, $metadata, $obj);
            $this->parseLists($xml, $metadata, $obj);
            $this->parseValue($xml, $metadata, $obj);

            return $obj;
        } else {
            return null;
        }
    }

    /**
     * Parse all of the xml attributes from a SimpleXml node
     * and set them to the given object
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     *
     * @todo : Ajouter des logs !!
     * @todo : Implémenter l'accès aux attributs public plutot que des set/get si possible
     */
    protected function parseAttributes(\SimpleXmlElement $xml, ClassMetadata $metadata, $obj)
    {
        foreach ($metadata->getAttributes() as $name => $info)
        {
            $property = $info[0];
            $nodeName = $info[1];
            $namespace = $info[2];

            if (!is_null($nodeName))
            {
                $node = $xml->$nodeName;
            } else {
                $node = $xml;
            }

            $attr = $node->attributes($namespace);
            $value = (string) $attr[$name];

            if ($value != null)
            {
                $setter = 'set' . ucfirst($property);
                $obj->$setter($value);
            }
        }
    }

    /**
     * Parse simple elements from a SimpleXml node
     * and set them to the given object
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     */
    protected function parseElements(\SimpleXmlElement $xml, ClassMetadata $metadata, $obj)
    {
        foreach ($metadata->getElements() as $name => $properties)
        {
            $property = $properties[0];
            $namespace = $properties[1];

            if ($namespace == null)
            {
                $value = (string) $xml->$name;
            }
            else
            {
                $elements = $xml->children($namespace);
                $value = (string) $elements->$name;
            }

            $setter = 'set' . ucfirst($property);
            $obj->$setter($value);
        }
    }

    /**
     * Parse embedded objects from a SimpleXml node
     * and set them to the given object
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     */
    protected function parseEmbeds(\SimpleXmlElement $xml, ClassMetadata $metadata, $obj)
    {
        foreach ($metadata->getEmbeds() as $nodeName => $info)
        {
            $property = $info[0];
            $tempMetaData = $info[1];

            $tempXml = $xml->$nodeName;
            if ($tempXml != null)
            {
                $tempObj = $this->parseObject($tempXml, $tempMetaData);
                if ($tempObj != null)
                {
                    $setter = 'set' . ucfirst($property);
                    $obj->$setter($tempObj);
                }
            }
        }
    }

    /**
     * Parse arrays from a SimpleXml node
     * and set them to the given object
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     */
    protected function parseLists(\SimpleXmlElement $xml, ClassMetadata $metadata, $obj)
    {
        foreach ($metadata->getLists() as $nodeName => $info)
        {
            $property = $info[0];
            $wrapperNode = $info[1];
            $listMetadata = $info[2];
            $namespace = $info[3];

            $tempList = array();

            if (!is_null($wrapperNode))
            {
                $xmlChild = $xml->children($namespace);

                echo $wrapperNode;
                \Zend_Debug::dump($xmlChild->asXML());

                if (isset($xmlChild->$wrapperNode))
                {
                    foreach ($xmlChild->$wrapperNode->$nodeName as $item)
                    {
                        if ($item == null) {
                            continue;
                        } elseif (!is_null($listMetadata))
                        {
                            $tempObj = $this->parseObject($item, $listMetadata);
                            $tempList[] = $tempObj;
                        } else {
                            $tempList[] = (string) $item;
                        }
                    }
                }

            } else {
                $xmlChild = $xml->children($namespace);
                foreach ($xmlChild->$nodeName as $item)
                {
                    if (!is_null($listMetadata))
                    {
                        $tempObj = $this->parseObject($item, $listMetadata);
                        $tempList[] = $tempObj;
                    }
                }
            }

            $setter = 'set' . ucfirst($property);
            $obj->$setter($tempList);
        }
    }

    /**
     * Parse the value from a SimpleXml node
     *
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     */
    protected function parseValue(\SimpleXmlElement $xml, ClassMetadata $metadata, $obj)
    {
        if (!is_null($metadata->getValue()))
        {
            $setter = 'set' . ucfirst($metadata->getValue());
            $value = (string) $xml;
            $obj->$setter($value);
        }
    }

    /**
     * Set the ClassMetadataFactory
     *
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function setClassMetadataFactory(ClassMetadataFactory $classMetadataFactory)
    {
        $this->classMetadataFactory = $classMetadataFactory;
    }

    /**
     * Pre-build the ClassMetadata for all the registered root classes
     */
    public function buildClassMetadatas()
    {
        foreach ($this->rootClasses as $class)
        {
            $this->classMetadataFactory->getClassMetadata($class);
        }
    }
}