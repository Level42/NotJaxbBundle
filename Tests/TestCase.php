<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Level42\NotJaxbBundle\Tests;

use Symfony\Component\DependencyInjection\Container;
use \NotJaxbTestKernel;

/**
 * Parent class to implement test case with service container
 * support
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Service container
     * @var Container
     */
    public $container;

    /**
     * Testcase constructor with Kernel instanciation
     */
    public function __construct()
    {
        $kernel = new NotJaxbTestKernel('test', true);
        $kernel->loadClassCache();
        $kernel->boot();
        $this->container = $kernel->getContainer();
    }
}
