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
 * XmlElement maps a entity property to an XML node
 * 
 * @Annotation
 */
class XmlElement extends Annotation
{
    /**
     * Element name
     * @var string
     */
	public $name;
	
	/**
	 * Element type name 
	 * @var string
	 */
	public $type;
}
