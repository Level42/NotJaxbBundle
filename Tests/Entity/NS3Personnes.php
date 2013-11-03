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
 * @XmlObject(ns="http://test/namespace#", name="personnes", prefix="test")
 */
class NS3Personnes
{
    /**
     * @XmlList(name="personne", type="Level42\NotJaxbBundle\Tests\Entity\NS3Personne", ns="http://test/namespace#", prefix="test")
     */
    private $personnes;

    /**
     * 
     * @return 
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }

    /**
     * 
     * @param $personnes
     */
    public function setPersonnes($personnes)
    {
        $this->personnes = $personnes;
    }
}
