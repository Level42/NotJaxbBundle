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
 * @XmlObject(name="produits")
 */
class Produits
{
    /**
     * @XmlList(name="produit", type="Level42\NotJaxbBundle\Tests\Entity\Produit")
     */
    private $produits;

    /**
     * 
     * @return 
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * 
     * @param $produits
     */
    public function setProduits($produits)
    {
        $this->produits = $produits;
    }
}