[< Return](https://github.com/Level42/NotJaxbBundle/blob/master/README.md "< Return")


1) Installation
----------------------------------
Download bundle in src/Level42/TddBundle

or add in your composer.json file

    "require": {
        ...
        "level42/notjaxb-bundle": "1.3"
        ...
    },

If you don't have Composer yet, download it following the instructions on 
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Overview
-------------------------------
### 2.1) Annotations
#### @XmlObject
Any class that needs to be mapped to an XML document will need this annotation defined on the class level.
Options :
- name : XML node name
- ns : XML Element namespace

XML

        <product>
          <.../>
        </product>
        
PHP

        /**
         * @XmlObject([ns="http://...",] [name="product"])
         */
        class Product
        {
        }
        
#### @XmlElement
This annotation will map a class property to a node within the XML document. An element can be either a simple value node or a child node which maps to a child object.
Options :
- name : Node name if different in XML
- type : Object type (fullclass path)
- ns : Element namespace

XML

        <product>
          <attribute></attribute>
        </product>
        
PHP

        /**
         * @XmlElement([name="attribute",] [type="Namespace\Attribute"])
         */
        private $attribute;

#### @XmlList
This annotation allows you to map collections of XML nodes to arrays of objects.
Options :
- name : Node name if different in XML
- type : Object type (fullclass path)
- wrapper : Paren object name
- ns : Element namespace

XML

        <product>
          <attribute code="sku"></attribute>
          <attribute code="short_description"></attribute>
        </product>
        
PHP

        /**
         * @XmlList([name="attribute",] [wrapper="attributes",] [type="Namespace\Attribute"], [ns="http://..."])
         */
        private $attributes;


#### @XmlAttribute
This annotation will map a class property to an attribute within an XML node.
Options :
- name : Attribute name in XML (if different of class attribute name)
- ns : Attribute namespace

XML

        <product id="1">
          < .../>
        </product>
        
PHP

        /**
         * @XmlAttribute([name="id"])
         */
        private $uniqueId;

#### @XmlValue
This annotation will map the value of an XML node to a class property when the node is mapped to a class.

XML

        <product id="1">
          <description lang="fr">Description du produit en français</description>
        </product>
        
PHP

        /**
         * @XmlValue
         */
        private $description;

#### @XmlRaw
This annotation allows you to get a XML node as string.
Options :
- name : Attribute name in XML (if different of class attribute name)
- ns : Attribute namespace

XML

        <personne>
          < .../>
        </personne>

PHP

        /**
         * @XmlRaw (name="personne", [ns="http://..."])
         */
        private $personne;

#### Use
- To serialize an object to XML, use "notjaxb.xml_unmarshalling" service.
- To unserialize XML XML to object, use "notjaxb.xml_marshalling" service.

### 2.2) Examples
See https://github.com/Level42/NotJaxbBundle/tree/master/Tests/Entity

### 2.3) Roadmap
1. Namespace support in XML serialization
2. Add XSD Entity generator
3. Add Json serializer/unserializer

### 2.4) Changelog
#### Version 1.4
Date : 2013-11-11
Fix marshalling bug
PSR-0 problem out of Symfony2
#### Version 1.3
Date : 2013-05-28
Fix namespace support on XmlElements
#### Version 1.2
Date : 2013-04-06
Add XML serialization (without namespaces)
#### Version 1.1
Date : 2013-03-29
Add multiple namespace support
#### Version 1.0
Date : 2013-03-19
First stable version