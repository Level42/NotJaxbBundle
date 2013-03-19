NotJaxbBundle (fr)
=========

Ce bundle permet d'hydrater des objets PHP à partir d'un fichier XML en utilisant des annotations. Un peu comme JaxB...
A l'origine il s'agit de l'outil https://raw.github.com/lampjunkie/xml-hitch intégré dans un bundle et avec quelques fonctionnalités supplémentaires (namespace, recursivité des objets)

1) Installation
----------------------------------
A l'ancienne, télécharger le contenu du Bundle dans : `src/Level42/NotJaxbBundle`

ou plus moderne, l'ajouter à votre fichier composer.json

    "require": {
        ...
        "Level42/notjaxb-bundle": "1.0"
        ...
    },

Si vous n'avez pas encore composer, téléchargez le et suivez la procédure d'installation sur
[http://getcomposer.org/](http://getcomposer.org/ "http://getcomposer.org/").

2) Utilisation
-------------------------------
### 2.1) Annotations
#### @XmlObject
Cette annotation est à ajouter sur toutes les classes qui doivent être liées à un noeud XML.
Options :
- ns : namespace de l'élément dans le XML

XML

        <personne>
          <.../>
        </personne>
        
PHP

        /**
         * @XmlObject([ns="http://..."])
         */
        class Personne
        {
        }
        
#### @XmlElement
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un noeud enfant XML. Ils peuvent correspondrent à des sous objets ou des valeurs.
Options :
- name : Nom du noeud dans le XML (si différent du nom de l'attribut)
- type : Type d'objet (chemin complet de la classe)

XML

        <personne>
          <adresse></adresse>
        </personne>
        
PHP

        /**
         * @XmlElement([name="adresse",] [type="Namespace\Adresse"])
         */
        private $adresse;

#### @XmlList
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un ensemble de noeuds enfant XML.

XML

        <personne>
          <adresse id="1"></adresse>
          <adresse id="2"></adresse>
        </personne>
        
PHP

        /**
         * @XmlList([name="adresse",] [wrapper="adresses",] [type="Namespace\Adresse"])
         */
        private $adresses;


#### @XmlAttribute
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un attribut XML.
Options :
- name : Nom de l'attribut dans le XML (si différent du nom de l'attribut de la classe)

XML

        <personne id="1">
          < .../>
        </personne>
        
PHP

        /**
         * @XmlAttribute([name="id"])
         */
        private $identifiant;

#### @XmlValue
Cette annoation est utilisée pour les attributs à la valeur d'un noeud XML.

XML

        <personne id="1">
          <poste lang="fr">Ingénieur</poste>
        </personne>
        
PHP

        /**
         * @XmlValue
         */
        private $poste;
        

### 2.2) Exemples
Voir https://github.com/Level42/NotJaxbBundle/tree/master/Tests/Entity

### 2.3) Roadmap
1. Prise en charge des namespaces XML multiples
2. Serialisation vers XML
3. Ajout d'un serialiseur/deserialiseur Json

### 2.4) Changelog
#### Version 1.0
Date : 2013-03-19
Première version stable



NotJaxbBundle (en)
=========

A Symfony 2 bundle to bind XML to PHP objects using annotations

1) Installation
----------------------------------
Download bundle in src/Level42/TddBundle

or add in your composer.json file

    "require": {
        ...
        "Level42/notjaxb-bundle": "1.0"
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
- ns : XML Element namespace

XML

        <product>
          <.../>
        </product>
        
PHP

        /**
         * @XmlObject([ns="http://..."])
         */
        class Product
        {
        }
        
#### @XmlElement
This annotation will map a class property to a node within the XML document. An element can be either a simple value node or a child node which maps to a child object.
Options :
- name : Node name if different in XML
- type : Object type (fullclass path)

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

XML

        <product>
          <attribute code="sku"></attribute>
          <attribute code="short_description"></attribute>
        </product>
        
PHP

        /**
         * @XmlList([name="attribute",] [wrapper="attributes",] [type="Namespace\Attribute"])
         */
        private $attributes;


#### @XmlAttribute
This annotation will map a class property to an attribute within an XML node.
Options :
- name : Attribute name in XML (if different of class attribute name)

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
        

### 2.2) Examples
See https://github.com/Level42/NotJaxbBundle/tree/master/Tests/Entity

### 2.3) Roadmap
1. Coverage of the multiple namespaces XML
2. Serialization to XML from object
3. Add Json serializer/unserializer

### 2.4) Changelog
#### Version 1.0
Date : 2013-03-19
First stable version
