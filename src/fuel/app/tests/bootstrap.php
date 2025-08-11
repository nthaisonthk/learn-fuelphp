<?php

/**
 * Test bootstrap file
 * This file is loaded before running tests
 */

// Load FuelPHP
require_once __DIR__.'/../../../fuel/core/bootstrap.php';

// Load test configuration
Fuel\Core\Config::load('test', true);

// Set test environment
Fuel\Core\Fuel::$env = Fuel\Core\Arr::get($_SERVER, 'FUEL_ENV', Fuel\Core\Fuel::TEST);

// Initialize FuelPHP
Fuel\Core\Fuel::init();

// Load test database configuration
Fuel\Core\Config::load('db', true);

// Set up test database connection
Fuel\Core\DB::connect();

// Load constants
require_once APPPATH.'config/constants.php'; 