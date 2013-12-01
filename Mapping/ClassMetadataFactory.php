<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Mapping;

use Doctrine\Common\Cache\AbstractCache;
use Doctrine\Common\Cache\ArrayCache;

use Level42\NotJaxbBundle\Mapping\ClassMetadata;
use Level42\NotJaxbBundle\Annotation\AnnotationLoader;

/**
 * The ClassMetadataFactory is used to create ClassMetadata objects that contain all the
 * metadata mapping informations of a class which describes how a class should be mapped
 * to an XML document.
 */
class ClassMetadataFactory
{
    /**
     * The loader for loading the class metadata.
     * 
     * @var LoaderInterface Loader
     */
    protected $loader;

    /**
     * The cache for caching class metadata.
     * 
     * @var AbstractCache Cache used to store metadatas
     */
    protected $cache;

    /**
     * Already loaded classes.
     *
     * @var array List of loaded classes
     */
    protected $loadedClasses = array();

    /**
     * Required dependencies.
     *
     * @param LoaderInterface $loader List of loaded classes
     * @param AbstractCache   $cache  Cache used to store metadatas
     */
    public function __construct(AnnotationLoader $loader,
            AbstractCache $cache = null)
    {
        $this->loader = $loader;
        $this->cache = $cache;

        if ($cache == null) {
            // Set a default array cache tool
            $this->cache = new ArrayCache();
        }
    }

    /**
     * Returns the class metadata associated to the given class name.
     *
     * @param string $class Classname
     * 
     * @return array Loaded classes
     */
    public function getClassMetadata($class)
    {
        $class = ltrim($class, '\\');

        if (!isset($this->loadedClasses[$class])) {

            $cache = $this->getCache();

            if ($cache !== null && $cache->contains($class)) {
                $this->loadedClasses[$class] = $cache->fetch($class);
            } else {
                $metadata = $this->createClassMetaData($class);
                $this->getLoader()->loadClassMetadata($metadata);

                $this->loadedClasses[$class] = $metadata;

                if ($cache !== null) {
                    $cache->save($class, $metadata);
                }
            }
        }

        return $this->loadedClasses[$class];
    }

    /**
     * Create the ClassMetadata for a class name.
     * 
     * @param string $class Class to analyse
     * 
     * @return ClassMetadata Class metadata
     */
    public function createClassMetadata($class)
    {
        return new ClassMetadata($class);
    }

    /**
     * Return loader for loading the class metadata.
     * 
     * @return LoaderInterface The loader for loading the class metadata.
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * Set loader for loading the class metadata.
     * 
     * @param LoaderInterface $loader The loader for loading the class metadata.
     */
    public function setLoader($loader)
    {
        $this->loader = $loader;
    }

    /**
     * Return Cache used to store metadatas.
     * 
     * @return AbstractCache Cache used to store metadatas
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * Set Cache used to store metadatas.
     * 
     * @param AbstractCache $cache Cache used to store metadatas
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Return List of loaded classes.
     * 
     * @return array List of loaded classes
     */
    public function getLoadedClasses()
    {
        return $this->loadedClasses;
    }

    /**
     * Set list of loaded classes.
     * 
     * @param array $loadedClasses List of loaded classes
     */
    public function setLoadedClasses($loadedClasses)
    {
        $this->loadedClasses = $loadedClasses;
    }
}
