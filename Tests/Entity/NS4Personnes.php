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
use Level42\NotJaxbBundle\Annotation\XmlRaw;

/**
 * @XmlObject(name="personnes")
 */
class NS4Personnes
{
    /**
     * @XmlRaw(name="personne")
     */
    private $personne;

    /**
     * @XmlRaw()
     */
    private $amis;

    /**
     * @param mixed $amis
     */
    public function setAmis($amis)
    {
        $this->amis = $amis;
    }

    /**
     * @return mixed
     */
    public function getAmis()
    {
        return $this->amis;
    }

    /**
     * @param mixed $personne
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;
    }

    /**
     * @return mixed
     */
    public function getPersonne()
    {
        return $this->personne;
    }

}
