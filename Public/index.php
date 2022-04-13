<?php
// TODO: Use an autoloader.
use Config\Config;
use Routes\Dispatcher;

require('../Routes/Server.php');
require_once('../Config/Config.php');

Config::loadConfig();
session_start();

require_once('../Routes/Router.php');
require_once('../Routes/Request.php');
require_once('../Routes/Dispatcher.php');

require_once('../App/Controllers/Controller.php');
require_once('../App/Views/View.php');
require_once('../App/Models/Model.php');
require_once('../Core/Database.php');
include_once('../Core/Logger.php');
require_once('../Core/Validator.php');

Dispatcher::dispatch();
