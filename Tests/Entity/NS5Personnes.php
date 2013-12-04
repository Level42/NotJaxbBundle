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
 * @XmlObject(name="personnes", ns="http://test/namespace#")
 */
class NS5Personnes
{
    /**
     * @XmlRaw(name="personne", ns="http://test/namespace#")
     */
    private $personne;

    /**
     * @XmlRaw(name="amis", ns="http://test/namespace#")
     */
    private $friends;

    /**
     * @param mixed $friends
     */
    public function setFriends($friends)
    {
        $this->friends = $friends;
    }

    /**
     * @return mixed
     */
    public function getFriends()
    {
        return $this->friends;
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
