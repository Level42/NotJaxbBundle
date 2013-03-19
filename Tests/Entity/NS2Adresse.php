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
 * @XmlObject(ns="http://test/namespace2#")
 */
class NS2Adresse
{
    /**
     * @XmlAttribute
     */
    private $id;
    
    /**
     * @XmlElement
     */
    private $numero;
    
    /**
     * @XmlElement
     */
    private $rue;
    
    /**
     * @XmlElement(name="cp")
     */
    private $codePostal;

    /**
     * @XmlElement
     */
    private $ville;

    /**
     * @XmlList(name="complement", type="Level42\NotJaxbBundle\Tests\Entity\NS2Complement")
     */
    private $complements;
    

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
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * 
     * @param $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * 
     * @return 
     */
    public function getRue()
    {
        return $this->rue;
    }

    /**
     * 
     * @param $rue
     */
    public function setRue($rue)
    {
        $this->rue = $rue;
    }

    /**
     * 
     * @return 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * 
     * @param $codePostal
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
    }

    /**
     * 
     * @return 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * 
     * @param $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * 
     * @return 
     */
    public function getComplements()
    {
        return $this->complements;
    }

    /**
     * 
     * @param $complements
     */
    public function setComplements($complements)
    {
        $this->complements = $complements;
    }
}