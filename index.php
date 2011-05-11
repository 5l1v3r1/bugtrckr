<?php

/**
 * index.php
 * 
 * to recieve globally different data from the DB
 * 
 * @package Index
 * @author Sascha Ohms
 * @author Phillipp Hirsch
 * @copyright Copyright 2011, Bugtrckr-Team
 * @license http://www.gnu.org/licenses/lgpl.txt
 *   
**/

session_start();

$app = require(__DIR__.'/lib/base.php');

require 'inc/config.inc.php';
require 'inc/main.php';

$app->set('CACHE', true);
$app->set('DEBUG', 2);
$app->set('EXTEND', true);
$app->set('GUI','gui/');
$app->set('AUTOLOAD', 'inc/');
$app->set('LOCALES','lang/');
$app->set('LANGUAGE', 'de'); // TODO: remove this line when english localization is done too
$app->set('PROXY', 1);

F3::set('DB', new DB('sqlite:' .$dbFile));

$app->route('GET /', 'main->start');
$app->route('GET /roadmap', 'main->showRoadmap');
$app->route('GET /timeline', 'main->showTimeline');
$app->route('GET /tickets', 'main->showTickets');
$app->route('GET /tickets/@order', 'main->showTickets');
$app->route('GET /ticket/@hash', 'main->showTicket');
$app->route('GET /user/@name', 'main->showUser');
$app->route('GET /user/new', 'main->showUserRegister');
$app->route('GET /user/login', 'main->showUserLogin');
$app->route('GET /user/logout', 'main->logoutUser');
$app->route('GET /milestone/@hash', 'main->showMilestone');
$app->route('GET /project/settings', 'main->showProjectSettings');

$app->route('POST /user/login', 'main->loginUser');
$app->route('POST /user/new', 'main->registerUser');
$app->route('POST /ticket', 'main->addTicket');
$app->route('POST /ticket/@hash', 'main->editTicket');
$app->route('POST /milestone', 'main->addMilestone');
$app->route('POST /project/select', 'main->selectProject');

$app->run();
