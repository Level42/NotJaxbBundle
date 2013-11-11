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
use Level42\NotJaxbBundle\Annotation\XmlElement;

/**
 * @XmlObject(name="embed")
 */
class Fix2Embed
{
    /**
     * @XmlElement(name="nom")
     * @var string
     */
    private $name;

    /**
     * @XmlElement
     * @var string
     */
    private $service;

    /**
     * @return the string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return the string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param string $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

}
