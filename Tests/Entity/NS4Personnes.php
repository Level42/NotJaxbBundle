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
use Level42\NotJaxbBundle\Annotation\XmlRow;

/**
 * @XmlObject(ns="http://test/namespace#", name="personnes", prefix="test")
 */
class NS4Personnes
{
    /**
     * @XmlRow(name="personne", ns="http://test/namespace#")
     */
    private $personne;

    /**
     * 
     * @return 
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * 
     * @param $personne
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }
}
