<?php

/**
 * Example usage of the WP MVC Redux library
 */

require_once __DIR__ . '/vendor/autoload.php';

use ClubDeuce\WpmvcRedux\Application;

// Create an instance of the Application class
$app = new Application();

// Display the version
echo "WP MVC Redux version: " . $app->getVersion() . PHP_EOL;
