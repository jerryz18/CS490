<?php
require_once("db.php");
//pull grades from Grades table to send to jerry for autograding
$obj = new stdClass();

$db = getDB();
if (isset($db)){
    $stmt = $db->prepare("SELECT username, exam_id, test_name, student_responses, earned_points, updated_points, possible_points, grade, auto_comments, comments from Grades WHERE grade = -1;");
    $r = $stmt->execute();
    $e = $stmt->errorInfo();
    if ($e[0] != "00000"){
        $obj->debug = "Something went wrong with error code " . $e[0];
    }
    $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($grades) > 0){
        $usernames = array();
        $ids = array();
        $names = array();
        $responses = array();
        $earned = array();
        $updated = array();
        $possible = array();
        $scores = array();
        $autoComments = array();
        $teacherComments = array();
        foreach ($grades as $g){
            array_push($usernames, $g["username"]);
            array_push($ids, $g["exam_id"]);
            array_push($names, $g["test_name"]);
            array_push($responses, $g["student_responses"]);
            array_push($earned, $g["earned_points"]);
            array_push($updated, $g["updated_points"]);
            array_push($possible, $g["possible_points"]);
            array_push($scores, $g["grade"]);
            array_push($autoComments, $g['auto_comments']);
            array_push($teacherComments, $g["comments"]);
        }
        $obj->username = $usernames;
        $obj->examID = $ids;
        $obj->testName = $names;
        $obj->studentResponses = $responses;
        $obj->earnedPoints = $earned;
        $obj->updatedPoints = $updated;
        $obj->possiblePoints = $possible;
        $obj->grade = $scores;
        $obj->auto = $autoComments;
        $obj->comments = $teacherComments;
        $obj->error = "Grades successfully returned";
    } else {
        $obj->error = "No grades returned";
    }
} else {
    $obj->error = "Error setting db";
}

echo json_encode($obj);
?>
