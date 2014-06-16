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
 * Class TestWrapper
 *
 * @Serialize\XmlObject(ns="http://www.foo-bar.com/")
 *
 * @author Eugoné Yann <yeugone@sqli.com>
 */
class TestWrapper
{
    /**
     * @Serialize\XmlElement
     */
    private $bar;

    /**
     * @Serialize\XmlElement(type="Level42\NotJaxbBundle\Tests\Entity\Issue14\TestObject", ns="")
     */
    private $object;

    /**
     * @Serialize\XmlList(name="object", wrapper="collection", type="Level42\NotJaxbBundle\Tests\Entity\Issue14\TestObject", ns="")
     */
    private $collection;

    /**
     * @Serialize\XmlRaw(name="raw", ns="")
     */
    private $raw;

    /**
     * Set the "bar" property
     *
     * @param mixed $bar
     *
     * @return TestWrapper
     */
    public function setBar($bar)
    {
        $this->bar = $bar;

        return $this;
    }

    /**
     * Get the "bar" property
     *
     * @return mixed
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * Set the "collection" property
     *
     * @param TestObject[] $collection
     *
     * @return TestWrapper
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Get the "collection" property
     *
     * @return TestObject[]
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Set the "object" property
     *
     * @param TestObject $object
     *
     * @return TestWrapper
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get the "object" property
     *
     * @return TestObject
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * Set the "raw" property
     *
     * @param mixed $raw
     *
     * @return TestWrapper
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;

        return $this;
    }

    /**
     * Get the "raw" property
     *
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }
}