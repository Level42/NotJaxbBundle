<?php
/**
 * This file is part of the {{package}} package
 *
 * (c) Sqli <http://www.sqli.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Tests\Entity\Issue14;

use Level42\NotJaxbBundle\Annotation as Serialize;

/**
 * Class TestObject
 *
 * @Serialize\XmlObject
 *
 * @author    Eugoné Yann <yeugone@sqli.com>
 */
class TestObject
{
    /**
     * @Serialize\XmlAttribute
     */
    private $id;

    /**
     * @Serialize\XmlElement
     */
    private $title;

    /**
     * @Serialize\XmlElement(ns="http://www.foo-bar.com/")
     */
    private $description;

    /**
     * Set the "description" property
     *
     * @param mixed $description
     *
     * @return TestObject
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the "description" property
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the "id" property
     *
     * @param mixed $id
     *
     * @return TestObject
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the "id" property
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the "title" property
     *
     * @param mixed $title
     *
     * @return TestObject
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the "title" property
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }
}