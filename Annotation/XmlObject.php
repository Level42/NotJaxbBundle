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
 * XmlObject maps a class to XML by letting NotJaxb know that the annotated
 * class should be parsed for additional annotations
 * 
 * @Annotation
 */
class XmlObject extends Annotation
{
    /**
     * Object namespace
     * @var string
     */
	public $ns;
}
