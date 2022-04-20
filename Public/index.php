<?php
use Config\Config;
use Routes\Dispatcher;

// autoloader
require_once __DIR__ . '/../vendor/autoload.php';

session_start();

Config::loadConfig();
Dispatcher::dispatch();