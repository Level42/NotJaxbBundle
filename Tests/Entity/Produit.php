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
 * @XmlObject(name="produit")
 */
class Produit
{
    /**
     * @XmlAttribute
     */
    private $sku;

    /**
     * @XmlElement
     */
    private $libelle;

    /**
     * @XmlList(name="produit", wrapper="produits_lies", type="Level42\NotJaxbBundle\Tests\Entity\Produit")
     */
    private $produitsLies;

    /**
     * 
     * @return 
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * 
     * @param $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * 
     * @return 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * 
     * @param $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    /**
     * 
     * @return 
     */
    public function getProduitsLies()
    {
        return $this->produitsLies;
    }

    /**
     * 
     * @param $produitsLies
     */
    public function setProduitsLies($produitsLies)
    {
        $this->produitsLies = $produitsLies;
    }
}
