<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Tests\Entity;

use Level42\NotJaxbBundle\Annotation\XmlObject;
use Level42\NotJaxbBundle\Annotation\XmlValue;
use Level42\NotJaxbBundle\Annotation\XmlAttribute;
use Level42\NotJaxbBundle\Annotation\XmlElement;
use Level42\NotJaxbBundle\Annotation\XmlList;

/**
 * @XmlObject(ns="http://test/namespace1#", name="personne", prefix="test1")
 */
class NS2Personne
{
    /**
     * @XmlAttribute
     */
    private $id;

    /**
     * @XmlAttribute
     */
    private $enabled;

    /**
     * @XmlElement
     */
    private $nom;

    /**
     * @XmlElement
     */
    private $service;

    /**
     * @XmlElement(name="adresse", type="Level42\NotJaxbBundle\Tests\Entity\NS2Adresse", ns="http://test/namespace2#", prefix="test2")
     */
    private $adressePrincipale;

    /**
     * @XmlList(name="adresse", wrapper="adresses", type="Level42\NotJaxbBundle\Tests\Entity\NS2Adresse", ns="http://test/namespace2#", prefix="test2")
     */
    private $adresses;

    /**
     * 
     * @return 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @return 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * 
     * @param $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * 
     * @return 
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * 
     * @param $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * 
     * @return 
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * 
     * @param $adresses
     */
    public function setAdresses($adresses)
    {
        $this->adresses = $adresses;
    }

    /**
     * 
     * @return 
     */
    public function isEnabled()
    {
        return (bool) $this->enabled;
    }

    /**
     * 
     * @param $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    public function getAdressePrincipale()
    {
        return $this->adressePrincipale;
    }

    public function setAdressePrincipale($adressePrincipale)
    {
        $this->adressePrincipale = $adressePrincipale;
    }

}
