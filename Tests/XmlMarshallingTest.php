<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Tests\Services\Impl;

use Level42\NotJaxbBundle\Tests\Entity\Personne;

use Level42\NotJaxbBundle\Tests\TestCase;
use Level42\NotJaxbBundle\Manager\XmlMarshalling;
use Level42\NotJaxbBundle\Manager\Manager;
use Level42\NotJaxbBundle\Mapping\ClassMetadataFactory;
use Level42\NotJaxbBundle\Tests\Entity\Personnes;
use Level42\NotJaxbBundle\Tests\Entity\Produits;

class XmlMarshallingTest extends TestCase
{
    /**
     * Service
     * @var XmlMarshalling
     */
    private $service = null;
    
    /**
     * Service
     * @var Manager
     */
    private $serviceUnmarshaling = null;

    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();        
        $this->service = $this->container->get('notjaxb.xml_marshalling');
        $this->serviceUnmarshaling = $this->container->get('notjaxb.xml_unmarshalling');
    }
        
    /**
     * Test a simple marshalling
     */
    public function testMarshallingSimple()
    {
        $expected = file_get_contents(__DIR__.'/Resources/xml_expected_simple.xml');
        $expected = str_replace("\r", "", $expected);
        
        $personnes = new Personnes();
        
            $personne = new Personne();
            $personne->setId(1);
            $personne->setNom("PERINEL");
            $personne->setService("Ingénieurie");
            
        $personnes->setPersonnes(array($personne));
        
        $result = $this->service->marshall($personnes);
        
        $this->assertEquals($expected, $result);    
    }
        
    /**
     * Test a simple marshalling
     */
    public function testMarshallingAfterMarshallingSimple()
    {
        $expected = file_get_contents(__DIR__.'/Resources/xml_sample_simple.xml');
        $expected = str_replace("\r", "", $expected);
        
        $personnes = $this->serviceUnmarshaling->unmarshall($expected, 'Level42\NotJaxbBundle\Tests\Entity\Personnes');
        $result = $this->service->marshall($personnes);
        
        $this->assertEquals($expected, $result);
    }
        
    /**
     * Test a simple marshalling
     */
    public function testMarshallingAfterMarshallingRecursive()
    {
        $expected = file_get_contents(__DIR__.'/Resources/xml_sample_recursive.xml');
        $expected = str_replace("\r", "", $expected);
        
        $produits = $this->serviceUnmarshaling->unmarshall($expected, 'Level42\NotJaxbBundle\Tests\Entity\Produits');
        $result = $this->service->marshall($produits);
        
        $this->assertEquals($expected, $result);
    }
        
    /**
     * Test a simple marshalling
     */
    public function _testMarshallingAfterMarshallingWithNamespace()
    {
        $expected = file_get_contents(__DIR__.'/Resources/xml_sample_withns.xml');
        $expected = str_replace("\r", "", $expected);
        
        $produits = $this->serviceUnmarshaling->unmarshall($expected, 'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes');
        $result = $this->service->marshall($produits);
        
        $this->assertEquals($expected, $result);
    }
        
    /**
     * Test a simple marshalling
     */
    public function _testMarshallingAfterMarshallingWithMultipleNamespaces()
    {
        $expected = file_get_contents(__DIR__.'/Resources/xml_sample_withmultins.xml');
        $expected = str_replace("\r", "", $expected);
        
        $produits = $this->serviceUnmarshaling->unmarshall($expected, 'Level42\NotJaxbBundle\Tests\Entity\NS2Personnes');
        $result = $this->service->marshall($produits);
        
        $this->assertEquals($expected, $result);
    }
}
