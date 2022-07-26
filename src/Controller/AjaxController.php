<?php
namespace App\Controller;
use App\Repository\MeetingModel;
use App\Repository\CandidateModel;

class AjaxController extends AbstractController
{ 
    public function filterCandidate()
    {
        $nameCandidate = $_GET['orderby'];
        $candidate = (new CandidateModel())->getCandidatePerName($nameCandidate);
        $candidates = (new CandidateModel())->getAllCandidate();
        return json_encode($candidate);
    }

    public function filterReunion()
    {
        $reunion = $_GET['reunion'];
        $meetings = (new MeetingModel())->getAllMeetingPerFormation($reunion);
        return json_encode($meetings);  
    }

    //Ajouter un candidat à la réunion
    public function insertCandidate()
    {
        $id_candidat = $_POST['id_candidat'];
        $id_meeting = $_POST['id_meeting'];
        $errors = (new MeetingModel())->checkCandidateInMeeting($id_candidat, $id_meeting);
        if(empty($errors)){
            $add = (new MeetingModel())->addCandidateToMeeting(intval($id_meeting), intval($id_candidat));    
        }
        $Allcandidates = (new CandidateModel())->getAllCandidate();
        $candidates = (new MeetingModel())->getCandidatesPerMeeting($id_meeting);
        $meeting = (new MeetingModel())->getOneMeeting($id_meeting);
        
        
        return $this->render('meetings/meetingDetail', [
            'Allcandidates' => $Allcandidates,
            'meeting' => $meeting,
            'candidates' => $candidates,
            'errors' => $errors,
        ],  'meetings/meetingDetail.phtml');
    }

}