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

use Level42\NotJaxbBundle\Tests\TestCase;
use Level42\NotJaxbBundle\Manager\Manager;
use Level42\NotJaxbBundle\Mapping\ClassMetadataFactory;
use Level42\NotJaxbBundle\Tests\Entity\Personnes;
use Level42\NotJaxbBundle\Tests\Entity\Produits;

/**
 * Test class for XmlUnmarshalling service
 */
class XmlUnmarshallingTest extends TestCase
{
    /**
     * Service
     * @var Manager
     */
    private $service = null;

    /**
     * Test class constructor (set service instance)
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = $this->container->get('notjaxb.xml_unmarshalling');
    }

    /**
     * Test a simple unmarshalling
     */
    public function testUnmarshallingSimple()
    {
        $xml = file_get_contents(__DIR__ . '/Resources/xml_sample_simple.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\Personnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\Personnes',
                    $result);

        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(4, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals('1', $personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertEquals('4', $personnes[3]->getId());
        $this->assertEquals('Personnel', $personnes[3]->getService());
        $this->assertEquals('Dupont', $personnes[3]->getNom());

        $this->assertCount(3, $personnes[3]->getAdresses());

        $adresses = $personnes[3]->getAdresses();

        $this->assertEquals('1', $adresses[0]->getId());
        $this->assertEquals('12', $adresses[0]->getNumero());
        $this->assertEquals('des docks', $adresses[0]->getRue());
        $this->assertEquals('69000', $adresses[0]->getCodePostal());
        $this->assertEquals('LYON', $adresses[0]->getVille());

        $this->assertEquals('2', $adresses[1]->getId());
        $this->assertEquals('22', $adresses[1]->getNumero());
        $this->assertEquals('place de la république', $adresses[1]->getRue());
        $this->assertEquals('01000', $adresses[1]->getCodePostal());
        $this->assertEquals('BOURG EN BRESSE', $adresses[1]->getVille());

        $this->assertEquals('3', $adresses[2]->getId());
        $this->assertEquals('32', $adresses[2]->getNumero());
        $this->assertEquals('place de la libération', $adresses[2]->getRue());
        $this->assertEquals('75000', $adresses[2]->getCodePostal());
        $this->assertEquals('PARIS', $adresses[2]->getVille());

        $this->assertCount(3, $adresses[2]->getComplements());

        $complements = $adresses[2]->getComplements();

        $this->assertEquals('Complément 1', $complements[0]->getValeur());
        $this->assertEquals('Complément 2', $complements[1]->getValeur());
        $this->assertEquals('Complément 3', $complements[2]->getValeur());
    }

    /**
     * Test a recursive metadata analyze
     */
    public function testMetadataRecursive()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_recursive.xml');

        $metaFactory = $this->container->get('notjaxb.metadata.factory');

        /* @var $metaFactory ClassMetadataFactory */

        $meta = $metaFactory
                ->getClassMetadata(
                    'Level42\NotJaxbBundle\Tests\Entity\Personnes');
        $this->assertNotNull($meta, 'Metadata failed for Personnes class');

        $meta = $metaFactory
                ->getClassMetadata(
                    'Level42\NotJaxbBundle\Tests\Entity\Produits');
        $this->assertNotNull($meta, 'Metadata failed for Produits class');
    }

    /**
     * Test a recursive unmarshalling
     */
    public function testUnmarshallingRecursive()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_recursive.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\Produits');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\Produits', $result);

        $this->assertNotNull($result->getProduits());
        $this->assertCount(1, $result->getProduits());

        $produits = $result->getProduits();

        $this->assertEquals('123456', $produits[0]->getSku());
        $this->assertEquals('Produit 123456', $produits[0]->getLibelle());

        $this->assertCount(2, $produits[0]->getProduitsLies());

        $produitsLies = $produits[0]->getProduitsLies();

        $this->assertEquals('789123', $produitsLies[0]->getSku());
        $this
                ->assertEquals('Produit lié 789123',
                    $produitsLies[0]->getLibelle());

        $this->assertEquals('456123', $produitsLies[1]->getSku());
        $this
                ->assertEquals('Produit lié 456123',
                    $produitsLies[1]->getLibelle());

        $produitsLies = $produitsLies[1]->getProduitsLies();

        $this->assertEquals('789123', $produitsLies[0]->getSku());
        $this
                ->assertEquals('Produit lié 789123',
                    $produitsLies[0]->getLibelle());

        $this->assertEquals('123456', $produitsLies[1]->getSku());
        $this
                ->assertEquals('Produit lié 123456',
                    $produitsLies[1]->getLibelle());
    }

    /**
     * Test a simple metadata analyze with namespace
     */
    public function testMetadataWithNamespace()
    {
        $xml = file_get_contents(__DIR__ . '/Resources/xml_sample_withns.xml');

        $metaFactory = $this->container->get('notjaxb.metadata.factory');

        /* @var $metaFactory ClassMetadataFactory */

        $meta = $metaFactory
                ->getClassMetadata(
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes');
        $this->assertNotNull($meta, 'Metadata failed for Personnes class');
        $this
                ->assertEquals('http://test/namespace#', $meta->getNamespace(),
                    'Namespace not found');
    }

    /**
     * Test a simple unmarshalling with namespace
     */
    public function testUnmarshallingSimpleWithNamespace()
    {
        $xml = file_get_contents(__DIR__ . '/Resources/xml_sample_withns.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes',
                    $result);

        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(4, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals('1', $personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertEquals('4', $personnes[3]->getId());
        $this->assertEquals('Personnel', $personnes[3]->getService());
        $this->assertEquals('Dupont', $personnes[3]->getNom());

        $this->assertCount(3, $personnes[3]->getAdresses());

        $adresses = $personnes[3]->getAdresses();

        $this->assertEquals('1', $adresses[0]->getId());
        $this->assertEquals('12', $adresses[0]->getNumero());
        $this->assertEquals('des docks', $adresses[0]->getRue());
        $this->assertEquals('69000', $adresses[0]->getCodePostal());
        $this->assertEquals('LYON', $adresses[0]->getVille());

        $this->assertEquals('2', $adresses[1]->getId());
        $this->assertEquals('22', $adresses[1]->getNumero());
        $this->assertEquals('place de la république', $adresses[1]->getRue());
        $this->assertEquals('01000', $adresses[1]->getCodePostal());
        $this->assertEquals('BOURG EN BRESSE', $adresses[1]->getVille());

        $this->assertEquals('3', $adresses[2]->getId());
        $this->assertEquals('32', $adresses[2]->getNumero());
        $this->assertEquals('place de la libération', $adresses[2]->getRue());
        $this->assertEquals('75000', $adresses[2]->getCodePostal());
        $this->assertEquals('PARIS', $adresses[2]->getVille());

        $this->assertCount(3, $adresses[2]->getComplements());

        $complements = $adresses[2]->getComplements();

        $this->assertEquals('Complément 1', $complements[0]->getValeur());
        $this->assertEquals('Complément 2', $complements[1]->getValeur());
        $this->assertEquals('Complément 3', $complements[2]->getValeur());
    }

    /**
     * Test a simple unmarshalling with namespace but no "id" attribute
     */
    public function testUnmarshallingSimpleWithNamespaceButNoIdAttribute()
    {
        $xml = file_get_contents(__DIR__ . '/Resources/xml_sample_noattr.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes',
                    $result);
        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(1, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertNull($personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());
    }

    /**
     * Test a simple unmarshalling with namespace but no "id" attribute
     */
    public function testUnmarshallingSimpleWithNamespaceAndMultipleAttributes()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_multipleattr.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NSPersonnes',
                    $result);
        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(2, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals(1, $personnes[0]->getId());
        $this->assertFalse($personnes[0]->isEnabled());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertNull($personnes[1]->getId());
        $this->assertTrue($personnes[1]->isEnabled());
        $this->assertEquals('Personnel', $personnes[1]->getService());
        $this->assertEquals('Durand', $personnes[1]->getNom());
    }

    /**
     * Test a simple unmarshalling with multiple namespaces
     */
    public function testUnmarshallingSimpleWithMultipleNamespaces()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_withmultins.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NS2Personnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NS2Personnes',
                    $result);
        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(4, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals(1, $personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertEquals(2, $personnes[1]->getId());
        $this->assertEquals('Achats', $personnes[1]->getService());
        $this->assertEquals('Durand', $personnes[1]->getNom());

        $this->assertEquals(3, $personnes[2]->getId());
        $this->assertEquals('Courrier', $personnes[2]->getService());
        $this->assertEquals('Dupuis', $personnes[2]->getNom());

        $this->assertEquals(4, $personnes[3]->getId());
        $this->assertEquals('Personnel', $personnes[3]->getService());
        $this->assertEquals('Dupont', $personnes[3]->getNom());
        $this->assertCount(3, $personnes[3]->getAdresses());

        $adresses = $personnes[3]->getAdresses();

        $this->assertEquals('1', $adresses[0]->getId());
        $this->assertEquals('12', $adresses[0]->getNumero());
        $this->assertEquals('des docks', $adresses[0]->getRue());
        $this->assertEquals('69000', $adresses[0]->getCodePostal());
        $this->assertEquals('LYON', $adresses[0]->getVille());
        $this->assertCount(0, $adresses[0]->getComplements());

        $this->assertEquals('2', $adresses[1]->getId());
        $this->assertEquals('22', $adresses[1]->getNumero());
        $this->assertEquals('place de la république', $adresses[1]->getRue());
        $this->assertEquals('01000', $adresses[1]->getCodePostal());
        $this->assertEquals('BOURG EN BRESSE', $adresses[1]->getVille());
        $this->assertCount(0, $adresses[1]->getComplements());

        $this->assertEquals('3', $adresses[2]->getId());
        $this->assertEquals('32', $adresses[2]->getNumero());
        $this->assertEquals('place de la libération', $adresses[2]->getRue());
        $this->assertEquals('75000', $adresses[2]->getCodePostal());
        $this->assertEquals('PARIS', $adresses[2]->getVille());
        $this->assertCount(3, $adresses[2]->getComplements());

        $complements = $adresses[2]->getComplements();
        $this->assertEquals('Complément 1', $complements[0]->getValeur());
        $this->assertEquals('Complément 2', $complements[1]->getValeur());
        $this->assertEquals('Complément 3', $complements[2]->getValeur());
    }

    /**
     * Test a simple unmarshalling with multiple namespaces #2
     */
    public function testUnmarshallingSimpleWithMultipleNamespaces2()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_withmultins2.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NS2Personnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NS2Personnes',
                    $result);
        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(4, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals(1, $personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertEquals(2, $personnes[1]->getId());
        $this->assertEquals('Achats', $personnes[1]->getService());
        $this->assertEquals('Durand', $personnes[1]->getNom());

        $this->assertEquals(3, $personnes[2]->getId());
        $this->assertEquals('Courrier', $personnes[2]->getService());
        $this->assertEquals('Dupuis', $personnes[2]->getNom());

        $adressePrincipale = $personnes[2]->getAdressePrincipale();
        $this->assertEquals('0', $adressePrincipale->getId());
        $this->assertEquals('1', $adressePrincipale->getNumero());
        $this->assertEquals('Place Verrazzano', $adressePrincipale->getRue());
        $this->assertEquals('69009', $adressePrincipale->getCodePostal());
        $this->assertEquals('LYON', $adressePrincipale->getVille());

        $this->assertEquals(4, $personnes[3]->getId());
        $this->assertEquals('Personnel', $personnes[3]->getService());
        $this->assertEquals('Dupont', $personnes[3]->getNom());
        $this->assertCount(3, $personnes[3]->getAdresses());

        $adresses = $personnes[3]->getAdresses();

        $this->assertEquals('1', $adresses[0]->getId());
        $this->assertEquals('12', $adresses[0]->getNumero());
        $this->assertEquals('des docks', $adresses[0]->getRue());
        $this->assertEquals('69000', $adresses[0]->getCodePostal());
        $this->assertEquals('LYON', $adresses[0]->getVille());
        $this->assertCount(0, $adresses[0]->getComplements());

        $this->assertEquals('2', $adresses[1]->getId());
        $this->assertEquals('22', $adresses[1]->getNumero());
        $this->assertEquals('place de la république', $adresses[1]->getRue());
        $this->assertEquals('01000', $adresses[1]->getCodePostal());
        $this->assertEquals('BOURG EN BRESSE', $adresses[1]->getVille());
        $this->assertCount(0, $adresses[1]->getComplements());

        $this->assertEquals('3', $adresses[2]->getId());
        $this->assertEquals('32', $adresses[2]->getNumero());
        $this->assertEquals('place de la libération', $adresses[2]->getRue());
        $this->assertEquals('75000', $adresses[2]->getCodePostal());
        $this->assertEquals('PARIS', $adresses[2]->getVille());
        $this->assertCount(3, $adresses[2]->getComplements());

        $complements = $adresses[2]->getComplements();
        $this->assertEquals('Complément 1', $complements[0]->getValeur());
        $this->assertEquals('Complément 2', $complements[1]->getValeur());
        $this->assertEquals('Complément 3', $complements[2]->getValeur());
    }

    /**
     * Test a simple unmarshalling with partial namespaces
     */
    public function testUnmarshallingSimpleWithPartialNamespaces()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_withpartialns.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NS3Personnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NS3Personnes',
                    $result);

        $this->assertNotNull($result->getPersonnes());
        $this->assertCount(4, $result->getPersonnes());

        $personnes = $result->getPersonnes();

        $this->assertEquals('1', $personnes[0]->getId());
        $this->assertEquals('Achats', $personnes[0]->getService());
        $this->assertEquals('Dupond', $personnes[0]->getNom());

        $this->assertEquals('4', $personnes[3]->getId());
        $this->assertEquals('Personnel', $personnes[3]->getService());
        $this->assertEquals('Dupont', $personnes[3]->getNom());

        $this->assertCount(3, $personnes[3]->getAdresses());

        $adresses = $personnes[3]->getAdresses();

        $this->assertEquals('1', $adresses[0]->getId());
        $this->assertEquals('12', $adresses[0]->getNumero());
        $this->assertEquals('des docks', $adresses[0]->getRue());
        $this->assertEquals('69000', $adresses[0]->getCodePostal());
        $this->assertEquals('LYON', $adresses[0]->getVille());

        $this->assertEquals('2', $adresses[1]->getId());
        $this->assertEquals('22', $adresses[1]->getNumero());
        $this->assertEquals('place de la république', $adresses[1]->getRue());
        $this->assertEquals('01000', $adresses[1]->getCodePostal());
        $this->assertEquals('BOURG EN BRESSE', $adresses[1]->getVille());

        $this->assertEquals('3', $adresses[2]->getId());
        $this->assertEquals('32', $adresses[2]->getNumero());
        $this->assertEquals('place de la libération', $adresses[2]->getRue());
        $this->assertEquals('75000', $adresses[2]->getCodePostal());
        $this->assertEquals('PARIS', $adresses[2]->getVille());

        $this->assertCount(3, $adresses[2]->getComplements());

        $complements = $adresses[2]->getComplements();

        $this->assertEquals('Complément 1', $complements[0]->getValeur());
        $this->assertEquals('Complément 2', $complements[1]->getValeur());
        $this->assertEquals('Complément 3', $complements[2]->getValeur());
    }

    /**
     * Test a simple unmarshalling with xmlRow Annotation
     */
    public function testUnmarshallingSimpleWithXmlRow()
    {
        $xml = file_get_contents(
                __DIR__ . '/Resources/xml_sample_xmlrow.xml');

        $result = $this->service
                ->unmarshall($xml,
                    'Level42\NotJaxbBundle\Tests\Entity\NS4Personnes');

        $this
                ->assertInstanceOf(
                    'Level42\NotJaxbBundle\Tests\Entity\NS4Personnes',
                    $result);

        $this->assertNotNull($result->getPersonne());
        $this->assertEquals('<personne><nom>Nom</nom><prenom>Prenom</prenom><email>Email</email></personne>', $result->getPersonne());
    }
}
