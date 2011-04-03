<?php

$app=require(__DIR__.'/lib/base.php');

require 'inc/main.php';

$app->set('CACHE', true);
$app->set('DEBUG', 2);
$app->set('EXTEND', true);
$app->set('GUI','gui/');

$app->route('GET /', 'main->start');
$app->route('GET /roadmap', 'main->showRoadmap');
$app->route('GET /timeline', 'main->showTimeline');
$app->route('GET /tickets', 'main->showTickets');
$app->route('GET /ticket/@hash', 'main->showTicket');
$app->route('POST /ticket', 'main->addTicket');

$app->run();
