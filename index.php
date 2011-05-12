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

$app->set('CACHE', false);
$app->set('DEBUG', 3);
$app->set('EXTEND', true);
$app->set('GUI','gui/');
$app->set('AUTOLOAD', 'inc/');
$app->set('LOCALES','lang/');
$app->set('LANGUAGE', 'de'); // TODO: remove this line when english localization is done too
$app->set('PROXY', 1);

F3::set('DB', new DB('sqlite:' .$dbFile));

// Template functions
$app->set('getPermission', function($permission) {
    return true;
});

F3::set('getUserName', function($id) {
    $user = new user();
    $user->load('id = '.$id);
    return $user->name;
});

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
$app->route('GET /project/settings/role/@hash', 'main->showProjectSettingsRole');
$app->route('GET /project/settings/role/add', 'main->showAddRole');
$app->route('GET /project/settings/milestone/@hash', 'main->showProjectSettingsMilestone');
$app->route('GET /project/settings/milestone/add', 'main->showAddMilestone');

$app->route('POST /user/login', 'main->loginUser');
$app->route('POST /user/new', 'main->registerUser');
$app->route('POST /ticket', 'main->addTicket');
$app->route('POST /ticket/@hash', 'main->editTicket');
$app->route('POST /milestone', 'main->addMilestone');
$app->route('POST /project/select', 'main->selectProject');
$app->route('POST /project/settings/member/setrole', 'main->projectSetRole');
$app->route('POST /project/settings/role/edit', 'main->addEditRole');
$app->route('POST /project/settings/main/edit', 'main->projectEditMain');
$app->route('POST /project/settings/milestone/edit', 'main->addEditMilestone');

require 'inc/mapping.inc.php';

$app->run();

F3::clear('SESSION.SUCCESS');
