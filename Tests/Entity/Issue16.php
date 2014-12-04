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

use Level42\NotJaxbBundle\Annotation as Marshall;

/**
 * @Marshall\XmlObject(name="email")
 *
 * @author Yann Eugoné <yann.eugone@gmail.com>
 */
class Issue16
{
    /**
     * @Marshall\XmlValue
     */
    protected $value;

    /**
     * @Marshall\XmlElement
     */
    protected $subject;

    /**
     * @Marshall\XmlElement
     */
    protected $address;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = trim($value);
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }
}
