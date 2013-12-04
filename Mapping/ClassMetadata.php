<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Mapping;

/**
 * A ClassMetadata instance holds all of the XML mapping information for an entity.
 */
class ClassMetadata
{
    /**
     * Class.
     * 
     * @var ReflectionClass
     */
    protected $reflClass;

    /**
     * The name of xml node.
     *
     * @var string
     */
    protected $name;

    /**
     * The class name.
     *
     * @var string
     */
    protected $className;

    /**
     * The class namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * The class namespace prefix.
     *
     * @var string
     */
    protected $prefix;

    /**
     * Array of xml attributes.
     * 
     * @var array
     */
    protected $attributes = array();

    /**
     * Array of child xml elements.
     * 
     * @var array
     */
    protected $elements = array();

    /**
     * Array of embedded ClassMetadata objects.
     * 
     * @var array
     */
    protected $embeds = array();

    /**
     * Array of xml lists.
     * 
     * @var array
     */
    protected $lists = array();

    /**
     * The value node info.
     * 
     * @var string
     */
    protected $value;

    /**
     * Array of xml raws
     *
     * @var array
     */
    protected $raws = array();

    /**
     * Constructs a metadata for the given class.
     *
     * @param string $className Classname to load
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Returns the fully qualified name of the class.
     *
     * @return string The fully qualified class name
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * Returns a ReflectionClass instance for this class.
     *
     * @return ReflectionClass instance for this class.
     */
    public function getReflectionClass()
    {
        if (!$this->reflClass) {
            $this->reflClass = new \ReflectionClass($this->getClassName());
        }

        return $this->reflClass;
    }

    /**
     * Add info for an XML attribute.
     * 
     * @param string $name      Name of attribute
     * @param string $property  Property linked to attribute
     * @param string $nodeName  XML node name for attribute
     * @param string $namespace Namespace of attribute
     * @param string $prefix    Namespace prefix of attribute
     */
    public function addAttribute($name, $property, $nodeName, $namespace = null,
            $prefix = null)
    {
        $this->attributes[$name] = array($property, $nodeName, $namespace,
                $prefix);
    }

    /**
     * Get all of the attributes.
     * 
     * @return array List of attributes
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Add info for an XML element.
     * 
     * @param string $name      Name of element
     * @param string $property  Property of element
     * @param string $namespace Namespace of element
     * @param string $prefix    Namespace prefix of element
     */
    public function addElement($name, $property, $namespace = null, $prefix = null)
    {
        $this->elements[$name] = array($property, $namespace, $prefix);
    }

    /**
     * Get all of the XML elements.
     * 
     * @return array List of elements
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Add info for an XML embed element.
     * 
     * @param string $name      Name of element
     * @param string $property  Property of element
     * @param string $namespace Namespace of element
     * @param string $prefix    Namespace prefix of element
     */
    public function addEmbed($name, $property, $namespace = null, $prefix = null)
    {
        $this->embeds[$name] = array($property, $namespace, $prefix);
    }

    /**
     * Get all of the embedded ClassMetadata(s).
     * 
     * @return array List of embed elements
     */
    public function getEmbeds()
    {
        return $this->embeds;
    }

    /**
     * Add info for an XML list.
     * 
     * @param string        $property    Property name
     * @param string        $nodeName    XML node name
     * @param string        $wrapperNode XML wrapper name
     * @param ClassMetadata $metadata    Metadatas of class type
     * @param string        $namespace   Namespace of element
     * @param string        $prefix      Namespace prefix of element
     */
    public function addList($property, $nodeName, $wrapperNode = null,
            ClassMetadata $metadata = null, $namespace = null, $prefix = null)
    {
        $this->lists[$nodeName] = array($property, $wrapperNode, $metadata,
                $namespace, $nodeName, $prefix);
    }

    /**
     * Get all of the XML lists.
     * 
     * @return array List of list
     */
    public function getLists()
    {
        return $this->lists;
    }

    /**
     * Set the node name which holds the value.
     * 
     * @param string $value Value of XML node
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the value node name.
     * 
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Add info for an XML element
     *
     * @param string $name
     * @param string $property
     */
    public function addRaw($name, $property, $ns = null, $prefix = null)
    {
        $this->raws[$name] = array($property, $ns, $prefix);
    }

    /**
     * Get all of the XML elements
     *
     * @return array
     */
    public function getRaws()
    {
        return $this->raws;
    }

    /**
     * Get class namespace.
     * 
     * @return string Namespace
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set class namespace.
     * 
     * @param string $namespace Namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Return class name.
     * 
     * @return string Class name
     */
    public function getName()
    {
        if ($this->name == null) {
            $parts = explode("\\", $this->className);
            $this->name = $parts[count($parts) - 1];
        }

        return $this->name;
    }

    /**
     * Set class name.
     * 
     * @param string $name Class name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Return namespace prefix.
     * 
     * @return string Namespace prefix
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set namespace prefix.
     *
     * @param string $prefix Namespace prefix
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }
}
