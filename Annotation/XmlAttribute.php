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
 * XmlAttribute maps a entity property to an XML attribute
 * 
 * @Annotation
 */
class XmlAttribute extends Annotation
{
    /**
     * Attribute name
     * @var string
     */
	public $name;
	
	/**
	 * Attribute node name
	 * @var string
	 */
	public $node;
	
	/**
	 * Attribute namespace
	 * @var string
	 */
	public $ns;
	
	/**
	 * Attribute namespace prefix
	 * @var string
	 */
	public $prefix;
}
