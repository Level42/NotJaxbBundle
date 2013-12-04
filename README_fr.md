[< Retour](https://github.com/Level42/NotJaxbBundle/blob/master/README.md "< Retour")


1) Installation
----------------------------------
A l'ancienne, télécharger le contenu du Bundle dans : `src/Level42/NotJaxbBundle`

ou plus moderne, l'ajouter à votre fichier composer.json

    "require": {
        ...
        "level42/notjaxb-bundle": "1.3"
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
- name : Nom du noeud XML lors de la serialisation
- ns : Namespace de l'objet dans le XML

XML

        <personne>
          <.../>
        </personne>
        
PHP

        /**
         * @XmlObject([ns="http://...",] [name="personne"])
         */
        class Personne
        {
        }
        
#### @XmlElement
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un noeud enfant XML. Ils peuvent correspondrent à des sous objets ou des valeurs.
Options :
- name : Nom du noeud dans le XML (si différent du nom de l'attribut)
- type : Type d'objet (chemin complet de la classe)
- ns : Namespace de l'objet dans le XML

XML

        <personne>
          <adresse></adresse>
        </personne>
        
PHP

        /**
         * @XmlElement([name="adresse",] [type="Namespace\Adresse",] [ns="http://..."])
         */
        private $adresse;

#### @XmlList
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un ensemble de noeuds enfant XML.
Options :
- name : Nom du noeud dans le XML (si différent du nom de l'attribut)
- type : Type d'objet (chemin complet de la classe)
- wrapper : Noeud contenant l'itération
- ns : Namespace de l'objet dans le XML

XML

        <personne>
          <adresse id="1"></adresse>
          <adresse id="2"></adresse>
        </personne>
        
PHP

        /**
         * @XmlList([name="adresse",] [wrapper="adresses",] [type="Namespace\Adresse",] [ns="http://..."])
         */
        private $adresses;


#### @XmlAttribute
Cette annotation est utilisée sur les attributs d'une classe qui sont liés à un attribut XML.
Options :
- name : Nom de l'attribut dans le XML (si différent du nom de l'attribut de la classe)
- ns : Namespace de l'objet dans le XML

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
Cette annotation est utilisée pour les attributs à la valeur d'un noeud XML.

XML

        <personne id="1">
          <poste lang="fr">Ingénieur</poste>
        </personne>
        
PHP

        /**
         * @XmlValue
         */
        private $poste;

#### @XmlRaw
Cette annotation est utilisée pour obtenir le contenu d'un noeud XML sous forme de chaine de caractères.
Options :
- name : Nom de l'attribut dans le XML (si différent du nom de l'attribut de la classe)
- ns : Namespace de l'objet dans le XML

XML

        <personne>
          < .../>
        </personne>

PHP

        /**
         * @XmlRaw (name="personne", [ns="http://..."])
         */
        private $personne;

#### Utilisation
- Pour serialiser un objet en XML, utiliser le service "notjaxb.xml_unmarshalling".
- Pour déserialiser un XML en objet, utiliser le service "notjaxb.xml_marshalling".

### 2.2) Exemples
Voir https://github.com/Level42/NotJaxbBundle/tree/master/Tests/Entity

### 2.3) Roadmap
1. Gestion des namespaces dans la serialisation XML
2. Génération des entités à partir d'un XSD
3. Ajout d'un serialiseur/deserialiseur Json

### 2.4) Changelog
#### Version 1.4
Date : 2013-11-11
Correction d'un bug lors du marshalling
Problème PSR-0
#### Version 1.3
Date : 2013-05-28
Correction de la gestion des namespace sur les XmlElements
#### Version 1.2
Date : 2013-04-06
Ajout de la serialisation XML (sans namespaces)
#### Version 1.1
Date : 2013-03-29
Ajout du support pour les multiples namespaces
#### Version 1.0
Date : 2013-03-19
Première version stable