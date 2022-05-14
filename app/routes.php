<?php
$routes = [];

$routes['home'] = '\App\Controller\DefaultController::getHome';
$routes['signup'] = '\App\Controller\DefaultController::getSignUp';
$routes['logout'] = '\App\Controller\DefaultController::getLogout';

$routes['createMeeting'] = '\App\Controller\MeetingController::getMeetingForm';
$routes['meeting'] = '\App\Controller\MeetingController::getOneMeeting';
$routes['allMeeting'] = '\App\Controller\MeetingController::getAllMeeting';

$routes['addCandidate'] = '\App\Controller\CandidateController::getAddCandidate';
$routes['candidate'] = '\App\Controller\CandidateController::getCandidate';
$routes['candidates'] = '\App\Controller\CandidateController::getAllCandidate';