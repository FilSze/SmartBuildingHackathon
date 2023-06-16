<?php

if(!isset($_GET["USER_ID"]) OR !isset($_GET["LOCK_ID"])){ 
    http_response_code(400); 
    exit("Missing GET variables");
}

include('dbc.php');
$ServerDateOffset = "0:00"; // 

$user = $_GET["USER_ID"];
$lock = $_GET["LOCK_ID"];

# DB Querry
$query =        'SELECT open_time FROM locks WHERE id='.$lock.';';
$response =     mysqli_query($dbc, $query);
$open_times =   json_decode(mysqli_fetch_row($response)[0], true); 


$date = date("l");
$time = date("H:i");

// Sort $open_times to be sure that rest of the code does not break
$day    = array_column($open_times, 'weekd');
$startT = array_column($open_times, 'start');
array_multisort($day, SORT_ASC, $startT, SORT_ASC);

$output = null;
$flag = false;
foreach($open_times as $open_time){
    if($open_time["weekd"] != $date){continue;}

    if(time() >= strtotime($open_time["start"]) AND time() <= $open_time["stop"]){
        //  During OPEN time window
        $output = ScoreAdj($user, 10);

        $flag = true;
        break;   
    }
}

if($flag == false){
    // User completly outside open time
    $output = ScoreAdj($user, -20);
}

print_r('<pre>');
print_r($open_times);
print_r("</pre>");

function ScoreAdj($id, $offset){
    // $id      => user id
    // $offset  => score adjustment
    global $dbc;

    $query = 'SELECT score FROM Users WHERE ID = '.$id.';';
    $response = mysqli_query($dbc, $query);
    $data = mysqli_fetch_assoc($response);
    $score = $data['score'] + $offset;

    $query = 'UPDATE Users SET Score = '.$score.' WHERE ID = '.$id.';';
    mysqli_query($dbc, $query);

    return "Score Adjusted by [".$offset."] for userID = ".$id.".";
}

http_response_code(200);    
mysqli_close($dbc);

print_r(date("l H:i")."<br>");

print_r("END<br>");
exit($output);
?>