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
 * @XmlObject(name="root")
 */
class Fix2Root
{
    /**
     * @XmlElement(name="embed", type="\Level42\NotJaxbBundle\Tests\Entity\Fix2Embed")
     * @var \Level42\NotJaxbBundle\Tests\Entity\Fix2Embed
     */
    private $embed;

    /**
     * @return Fix2Embed
     */
    public function getEmbed()
    {
        return $this->embed;
    }

    /**
     * @param \Level42\NotJaxbBundle\Tests\Entity\Fix2Embed $embed
     */
    public function setEmbed(\Level42\NotJaxbBundle\Tests\Entity\Fix2Embed $embed)
    {
        $this->embed = $embed;
    }

}
