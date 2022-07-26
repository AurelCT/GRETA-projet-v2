<?php
$routes = [];

$routes['home'] = '\App\Controller\DefaultController::getHome';
$routes['signup'] = '\App\Controller\DefaultController::getSignUp';
$routes['logout'] = '\App\Controller\DefaultController::getLogout';

$routes['createMeeting'] = '\App\Controller\MeetingController::getMeetingForm';
$routes['meeting'] = '\App\Controller\MeetingController::getOneMeeting';
$routes['allMeeting'] = '\App\Controller\MeetingController::getAllMeeting';
$routes['editCandidateMeeting'] = '\App\Controller\MeetingController::editCandidateInMeeting';
$routes['deleteCandidatFromMeeting'] = '\App\Controller\MeetingController::deleteCandidatFromMeeting';
$routes['deleteMeeting'] = '\App\Controller\MeetingController::deleteMeeting';

$routes['addCandidate'] = '\App\Controller\CandidateController::getAddCandidate';
$routes['candidate'] = '\App\Controller\CandidateController::getCandidate';
$routes['candidates'] = '\App\Controller\CandidateController::getAllCandidate';
$routes['editCandidate'] = '\App\Controller\CandidateController::editCandidate';
$routes['deleteCandidate'] = '\App\Controller\CandidateController::deleteCandidate';


$routes['filterCandidate'] = '\App\Controller\AjaxController::filterCandidate';
$routes['filterReunion'] = '\App\Controller\AjaxController::filterReunion';
$routes['AddCandidateToMeeting'] = '\App\Controller\AjaxController::insertCandidate';