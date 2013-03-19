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

<TODO>