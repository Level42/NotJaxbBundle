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

use Level42\NotJaxbBundle\Exceptions\MaxDepthException;

use Doctrine\Common\Annotations\Reader;

use Level42\NotJaxbBundle\Annotation\XmlAttribute;
use Level42\NotJaxbBundle\Annotation\XmlElement;
use Level42\NotJaxbBundle\Annotation\XmlList;
use Level42\NotJaxbBundle\Annotation\XmlObject;
use Level42\NotJaxbBundle\Annotation\XmlValue;
use Level42\NotJaxbBundle\Mapping\ClassMetadata;

/**
 * AnnotationLoader loads all of the annotations from an entity class and sets
 * them to a ClassMetadata object.
 */
class AnnotationLoader
{

    /**
     * Annotation reader.
     * 
     * @var AnnotationReader
     */
    protected $reader;

    /**
     * Build the AnnotationLoader with an AnnotationReader.
     *
     * @param AnnotationReader $reader   Annotation reader to use
     * @param integer          $maxDepth Maximum depth analyze
     */
    public function __construct(Reader $reader, $maxDepth)
    {
        $this->reader = $reader;
        $this->maxDepth = $maxDepth;
    }

    /**
     * Parse all of the annotations for a given ClassMetadata object.
     *
     * @param ClassMetadata $metadata Metadatas description of class
     * @param integer       $depth    Maximum depth to analyze
     * 
     * @return ClassMetadata Metadatas description of class
     */
    public function loadClassMetadata(ClassMetadata $metadata, $depth = null)
    {
        $depth = ($depth == null ? $this->maxDepth : $depth);
        $reflClass = $metadata->getReflectionClass();

        if ($depth > 0) {
            $depth--;
            try {
                foreach ($this->reader->getClassAnnotations($reflClass) as $annotation) {
                    if ($annotation instanceof XmlObject) {
                        // If class have name
                        if ($annotation->name != null) {
                            $metadata->setName($annotation->name);
                        }

                        // If class have namespace
                        if ($annotation->ns != null) {
                            $metadata->setNamespace($annotation->ns);
                        }

                        // If class have namespace prefix
                        if ($annotation->prefix != null) {
                            $metadata->setPrefix($annotation->prefix);
                        }

                        $this->loadClassAttributes($metadata);
                        $this->loadClassElements($metadata, $depth);
                        $this->loadClassLists($metadata, $depth);
                        $this->loadClassValue($metadata);
                        $this->loadClassRaw($metadata);
                    }
                }
            } catch (MaxDepthException $ex) {
                echo $ex->getMessage();
            }
        }

        return $metadata;
    }

    /**
     * Load all of the @XmlAttribute annotations.
     * 
     * @param ClassMetadata $metadata Metadatas description of class
     * 
     * @return ClassMetadata Metadatas description of class
     */
    protected function loadClassAttributes(ClassMetadata $metadata)
    {
        $reflClass = $metadata->getReflectionClass();

        foreach ($reflClass->getProperties() as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof XmlAttribute) {
                    $attributeName = !is_null($annotation->name) ? $annotation
                                    ->name : $property->getName();
                    $nodeName = $annotation->node;
                    $metadata->addAttribute($attributeName,
                        $property->getName(), $nodeName,
                        $annotation->ns, $annotation->prefix);
                }
            }
        }

        return $metadata;
    }

    /**
     * Load all of the @XmlElement annotations.
     * 
     * @param ClassMetadata $metadata Metadatas description of class
     * @param integer       $depth    Current depth
     * 
     * @return ClassMetadata Metadatas description of class
     */
    protected function loadClassElements(ClassMetadata $metadata, $depth)
    {
        $reflClass = $metadata->getReflectionClass();

        if ($depth > 0) {
            foreach ($reflClass->getProperties() as $property) {

                foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                    if ($annotation instanceof XmlElement) {
                        $nodeName = !is_null($annotation->name) ? $annotation
                                        ->name : $property->getName();
                        if (is_null($annotation->type)) {
                            $metadata->addElement($nodeName,
                                $property->getName(),
                                $annotation->ns,
                                $annotation->prefix);
                        } else {
                            $embeddedMetadata = new ClassMetadata(
                                $annotation->type);
                            $this->loadClassMetadata($embeddedMetadata, $depth);
                            $metadata->addEmbed($nodeName,
                                $property->getName(),
                                $embeddedMetadata);
                        }
                    }
                }
            }
        }

        return $metadata;
    }

    /**
     * Load all of the @XmlList annotations.
     * 
     * @param ClassMetadata $metadata Metadatas description of class
     * @param integer       $depth    Current depth
     * 
     * @return ClassMetadata Metadatas description of class
     */
    protected function loadClassLists(ClassMetadata $metadata, $depth)
    {
        $reflClass = $metadata->getReflectionClass();

        if ($depth > 0) {
            foreach ($reflClass->getProperties() as $property) {

                foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                    if ($annotation instanceof XmlList) {
                        $nodeName = !is_null($annotation->name)
                            ? $annotation->name : $property->getName();

                        if (!is_null($annotation->type)) {
                            $embeddedMetadata = new ClassMetadata(
                                $annotation->type);
                            $this->loadClassMetadata($embeddedMetadata, $depth);
                        } else {
                            $embeddedMetadata = null;
                        }

                        $metadata->addList($property->getName(),
                            $nodeName,
                            $annotation->wrapper,
                            $embeddedMetadata, $annotation->ns,
                            $annotation->prefix);
                    }
                }
            }
        }

        return $metadata;
    }

    /**
     * Load all of the @XmlValue annotations.
     * 
     * @param ClassMetadata $metadata Metadatas description of class
     * 
     * @return ClassMetadata Metadatas description of class
     */
    protected function loadClassValue(ClassMetadata $metadata)
    {
        $reflClass = $metadata->getReflectionClass();

        foreach ($reflClass->getProperties() as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof XmlValue) {
                    $metadata->setValue($property->getName());
                }
            }
        }

        return $metadata;
    }

    /**
     * Load all of the @XmlRaw annotations
     *
     * @param ClassMetadata $metadata Metadatas description of class
     *
     * @return ClassMetadata Metadatas description of class
     */
    protected function loadClassRaw(ClassMetadata $metadata)
    {
        $reflClass = $metadata->getReflectionClass();

        foreach ($reflClass->getProperties() as $property) {
            foreach ($this->reader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof XmlRaw) {
                    $nodeName = !is_null($annotation->name)
                        ? $annotation->name : $property->getName();
                    $metadata->addRaw($nodeName,
                        $property->getName(),
                        $annotation->ns, null);
                }
            }
        }

        return $metadata;
    }
}
