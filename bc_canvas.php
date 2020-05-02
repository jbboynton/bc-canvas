<?php

/**
 * Plugin Name: BC Canvas
 * Description: WordPress CPT for BC Marine Canvas' canvas service.
 * Version: 0.1.3
 * Author: James Boynton
 */

namespace BC\Canvas;

$autoload_path = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload_path)) {
  require_once($autoload_path);
}

new Services();
