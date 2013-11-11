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
class XmlMarshalling
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
     * Xml document
     * @var \DomDocument
     */
    protected $xml;

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
     * Marshall an object into an XML string
     * 
     * @param mixed $object Object 
     * 
     * @return string $xmlString
     */
    public function marshall($object)
    {
        $rootClass = get_class($object);
        $metadata = $this->classMetadataFactory->getClassMetadata($rootClass);

        $this->xml = new \DOMDocument('1.0', 'UTF-8');
        $this->xml->preserveWhiteSpace = false;
        $this->xml->formatOutput = true;

        $this->parseObject($object, $metadata);

        return trim($this->xml->saveXML());
    }

    /**
     * Parse an object from a SimpleXml node
     * 
     * @param mixed $object
     * @param ClassMetadata $metadata
     * 
     * @return \DOMElement
     */
    protected function parseObject($object, ClassMetadata $metadata)
    {
        // Create element
        $prefix = null;
        if ($metadata->getPrefix() != null) {
            $prefix = ':' . $metadata->getPrefix();
        }
        $xmlElement = $this->xml
                ->createElementNS($metadata->getNamespace(),
                        $prefix . $metadata->getName());

        $this->parseAttributes($object, $metadata, $xmlElement);
        $this->parseElements($object, $metadata, $xmlElement);
        $this->parseEmbeds($object, $metadata, $xmlElement);
        $this->parseLists($object, $metadata, $xmlElement);
        $this->parseValue($object, $metadata, $xmlElement);

        $this->xml->appendChild($xmlElement);

        return $xmlElement;
    }

    /**
     * Parse all of the xml attributes from a SimpleXml node
     * and set them to the given object
     * 
     * @param stdClass $obj
     * @param ClassMetadata $metadata
     * @param \DOMElement $xml
     * 
     * @return \DOMElement
     */
    protected function parseAttributes($obj, ClassMetadata $metadata,
            \DOMElement $xml)
    {
        foreach ($metadata->getAttributes() as $name => $info) {
            $property = $info[0];
            $nodeName = $info[1];
            $namespace = $info[2];
            $prefix = $info[3];

            $value = $this->getValueFromProperty($obj, $property);

            if ($value != null) {
                $name = !is_null($nodeName) ? $nodeName : $name;
                if ($prefix != null) {
                    $prefix .= ':';
                }
                $xml->setAttributeNS($namespace, $prefix . $name, $value);
            }
        }

        return $xml;
    }

    /**
     * Parse simple elements from a SimpleXml node
     * and set them to the given object
     * 
     * @param stdClass $obj
     * @param ClassMetadata $metadata
     * @param DOMElement $xml
     */
    protected function parseElements($obj, ClassMetadata $metadata,
            \DOMElement $xml)
    {
        foreach ($metadata->getElements() as $name => $properties) {
            $property = $properties[0];

            $value = $this->getValueFromProperty($obj, $property);

            if ($value != null) {
                $xmlElement = $this->xml->createElement($name, $value);
                $xml->appendChild($xmlElement);
            }
        }
    }

    /**
     * Parse embedded objects from a php object 
     * and set them to the XML Element
     * 
     * @param stdClass $obj
     * @param ClassMetadata $metadata
     * @param DOMElement $xml
     */
    protected function parseEmbeds($obj, ClassMetadata $metadata,
            \DOMElement $xml)
    {
        foreach ($metadata->getEmbeds() as $name => $properties) {
            
            $property = $properties[0];
            $embedMetadatas = $properties[1];
            $prefix = $properties[2];

            $embedObj = $this->getValueFromProperty($obj, $property);
                        
            if ($embedObj != null) {
                $xmlElement = $this->parseObject($embedObj, $embedMetadatas);
                $xml->appendChild($xmlElement);
            }
        }
    }

    /**
     * Parse arrays from a SimpleXml node
     * and set them to the given object
     * 
     * @param stdClass $obj
     * @param ClassMetadata $metadata
     * @param \DOMElement $xml
     */
    protected function parseLists($obj, ClassMetadata $metadata,
            \DOMElement $xml)
    {
        foreach ($metadata->getLists() as $nodeName => $info) {
            $property = $info[0];
            $wrapperNode = $info[1];
            $listMetadata = $info[2];
            $namespace = $info[3];
            $name = $info[4];

            $values = $this->getValueFromProperty($obj, $property);

            if ($values != null && count($values) > 0) {
                $xmlList = array();
                foreach ($values as $value) {
                    $xmlItem = $this->parseObject($value, $listMetadata);
                    $xmlList[] = $xmlItem;
                }

                if (!is_null($wrapperNode)) {
                    $xmlWrapper = $this->xml->createElement($wrapperNode);
                    foreach ($xmlList as $xmlItem) {
                        $xmlWrapper->appendChild($xmlItem);
                    }
                    $xml->appendChild($xmlWrapper);
                } else {
                    foreach ($xmlList as $xmlItem) {
                        $xml->appendChild($xmlItem);
                    }
                }
            }

        }
    }

    /**
     * Parse the value from a SimpleXml node
     * 
     * @param SimpleXmlElement $xml
     * @param ClassMetadata $metadata
     * @param stdClass $obj
     */
    protected function parseValue($obj, ClassMetadata $metadata,
            \DOMElement $xml)
    {
        if (!is_null($metadata->getValue())) {
            $value = $this->getValueFromProperty($obj, $metadata->getValue());
            $xml->nodeValue = $value;
        }
    }

    /**
     * Set the ClassMetadataFactory
     * 
     * @param ClassMetadataFactory $classMetadataFactory
     */
    public function setClassMetadataFactory(
            ClassMetadataFactory $classMetadataFactory)
    {
        $this->classMetadataFactory = $classMetadataFactory;
    }

    /**
     * Pre-build the ClassMetadata for all the registered root classes
     */
    public function buildClassMetadatas()
    {
        foreach ($this->rootClasses as $class) {
            $this->classMetadataFactory->getClassMetadata($class);
        }
    }

    /**
     * Return value from object property
     * 
     * @param mixed $obj
     * @param string $property
     * 
     * @return mixed
     */
    protected function getValueFromProperty($obj, $property)
    {

        $getAccessor = 'get' . ucfirst($property);
        $isAccessor = 'is' . ucfirst($property);
        $hasAccessor = 'has' . ucfirst($property);

        if (method_exists($obj, $getAccessor)) {
            return $obj->$getAccessor();
        } elseif (method_exists($obj, $isAccessor)) {
            return $obj->$isAccessor();
        } elseif (method_exists($obj, $hasAccessor)) {
            return $obj->$hasAccessor();
        }
        return null;
    }
}
