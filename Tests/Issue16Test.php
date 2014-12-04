<?php

namespace Level42\NotJaxbBundle\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use Level42\NotJaxbBundle\Annotation\AnnotationLoader;
use Level42\NotJaxbBundle\Manager\XmlMarshalling;
use Level42\NotJaxbBundle\Manager\XmlUnmarshalling;
use Level42\NotJaxbBundle\Mapping\ClassMetadataFactory;
use Level42\NotJaxbBundle\Tests\Entity\Issue16;

/**
 * Class Issue16Test
 *
 * @author Yann Eugoné <yeugone@prestaconcept.net>
 */
class Issue16Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlMarshalling
     */
    private $marshaller;

    /**
     * @var XmlUnmarshalling
     */
    private $unmarshaller;

    /**
     * Test class constructor (set service instance)
     */
    public function __construct()
    {
        parent::__construct();

        $factory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader(), 60));

        $this->marshaller = new XmlMarshalling($factory);
        $this->unmarshaller = new XmlUnmarshalling($factory);
    }

    public function testMarshalling()
    {
        $expectedXml = file_get_contents(__DIR__ . '/Resources/issue16-1.xml');
        $this->assertEquals($expectedXml, $this->marshaller->marshall($this->getObject1()));

        $expectedXml = file_get_contents(__DIR__ . '/Resources/issue16-2.xml');
        $this->assertEquals($expectedXml, $this->marshaller->marshall($this->getObject2()));
    }

    public function testUnmarshalling()
    {
        $xml = file_get_contents(__DIR__ . '/Resources/issue16-1.xml');
        $this->assertEquals($this->getObject1(), $this->unmarshaller->unmarshall($xml, 'Level42\\NotJaxbBundle\\Tests\\Entity\\Issue16'));

        $xml = file_get_contents(__DIR__ . '/Resources/issue16-2.xml');
        $this->assertEquals($this->getObject2(), $this->unmarshaller->unmarshall($xml, 'Level42\\NotJaxbBundle\\Tests\\Entity\\Issue16'));
    }

    protected function getObject1()
    {
        $object = new Issue16();
        $object->setValue('testemail@test.com');

        return $object;
    }

    protected function getObject2()
    {
        $object = new Issue16();
        $object->setSubject('Test mail');
        $object->setAddress('test@gmail.com,rest@gmail.com');

        return $object;
    }
}
