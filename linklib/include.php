<?php
/**
 * Akeeba Build Tools
 *
 * @package        buildfiles
 * @license        GPL v3
 * @copyright      2010-2017 Akeeba Ltd
 */

namespace Akeeba\LinkLibrary;

use Composer\Autoload\ClassLoader;

$autoloaderFile = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($autoloaderFile))
{
	echo <<< END

********************************************************************************
**                                   WARNING                                  **
********************************************************************************

You have NOT initialized Composer on the buildfiles repository. This script is
about to die with an error.

--------------------------------------------------------------------------------
HOW TO FIX
--------------------------------------------------------------------------------

Go to the buildfiles repository and run:

php ./composer.phar install


END;

	throw new \RuntimeException("Composer is not initialized in the buildfiles repository");
}

// Get a reference to Composer's autloader
/** @var ClassLoader $composerAutoloader */
$composerAutoloader = require($autoloaderFile);

// Register this directory as the PSR-4 source for our namespace prefix
$composerAutoloader->addPsr4('Akeeba\\LinkLibrary\\', __DIR__);