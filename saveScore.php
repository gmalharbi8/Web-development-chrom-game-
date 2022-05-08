<?php
include './database.php';
// for POST requests read data and save it into DB
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_POST["userId"]) ? $_POST["userId"] : "";
    $startTime = isset($_POST["startTime"]) ? $_POST["startTime"] : "";
    $endTime = isset($_POST["endTime"]) ? $_POST["endTime"] : "";
    $score = isset($_POST["score"]) ? $_POST["score"] : "";

    // if the data not existing then stop processing
    if ($userId == "" || $startTime == "" || $endTime == "" || $score == "") {
        die();
    } // end if

    try {
        // connect to database and insert the data into it
        Database::connect();
        $result = Database::insert("SCORE_HISTORY", "USER_ID, START_TIME, END_TIME, SCORE", [[$userId, $startTime, $endTime, $score]]);
        Database::close();
        echo json_encode($result);
    } catch (\Throwable$th) {
        $error = [
            "error" => $th->getMessage(),
        ];
        echo json_encode($error);
    }
}
