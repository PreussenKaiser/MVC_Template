<?php
// TODO: Use an autoloader.
// TODO: Get CSS loaded urls to work.

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
require_once('../App/Models/Teams.php');
require_once('../App/Models/Games.php');
include_once('../App/Models/Logs.php');
require_once('../Core/Database.php');
include_once('../Core/Logger.php');
require_once('../Core/Validation.php');

Dispatcher::dispatch();
