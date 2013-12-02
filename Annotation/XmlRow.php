<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * XmlRow maps a entity property to an XML node value.
 * 
 * @Annotation
 */
class XmlRow extends Annotation
{
    /**
     * Attribute name
     * @var string
     */
    public $name;

    /**
     * Attribute namespace
     * @var string
     */
    public $ns;
}
