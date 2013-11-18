<?php
/**
 * This file is part of the NotJaxbBundle package
 *
 * (c) Level42 <level42.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$loader = @include __DIR__ . '/../vendor/autoload.php';
if (!$loader) {
    die(
            <<<'EOT'
You must set up the project dependencies, run the following commands:
wget http://getcomposer.org/composer.phar
php composer.phar install
EOT
    );
}
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

spl_autoload_register(
        function ($class)
        {
            if (0 === strpos($class, 'Level42\\NotJaxbBundle\\')) {
                $path = __DIR__ . '/../'
                        . implode('/', array_slice(explode('\\', $class), 2))
                        . '.php';
                if (!stream_resolve_include_path($path)) {

                    return false;
                }
                require_once $path;

                return true;
            }
        }
);

// Chargement du kernel
require_once __DIR__ . '/app/NotJaxbTestKernel.php';
