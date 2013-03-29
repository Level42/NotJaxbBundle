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
 * XmlList maps a property to a collection of XML nodes
 * 
 * @Annotation
 */
class XmlList extends Annotation
{
    /**
     * List name
     * @var string
     */
	public $name;
	
	/**
	 * Type of listed objects
	 * @var string
	 */
	public $type;
	
	/**
	 * Wrapper name
	 * @var string
	 */
	public $wrapper;
	
	/**
	 * Wrapper namespace
	 * @var string
	 */
	public $ns;
}
