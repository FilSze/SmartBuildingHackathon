<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/1.css">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Fetch'n'Show</title>
</head>
<body>

<table>
        <tr>
            <th>user ID</th><th>user name</th><th>score</th>
        </tr>
    
<?php

include("../backend/dbc.php");
$muricaTimeMode = true;

$query = "SELECT *  FROM users;";
$response = mysqli_query($dbc, $query);
$data = mysqli_fetch_all($response, MYSQLI_ASSOC);

foreach($data as $row){
    
    print("<tr>");
    print("<td>".$row['id']."</td>");
    print("<td>".$row["name"]."</td>");
    print("<td>".$row["score"]."</td>");
    print("</tr>");
}

?>
    </table>
    <table>
        <tr>
            <th>lock ID</th><th>name</th><th>open windows</th>
        </tr>
    
<?php

$query = "SELECT *  FROM locks;";
$response = mysqli_query($dbc, $query);
$data = mysqli_fetch_all($response, MYSQLI_ASSOC);

foreach($data as $row){
    
    print("<tr>");
    print("<td>".$row['id']."</td>");
    print("<td>".$row["name"]."</td>");

    print("<td><pre>");

    $json = json_decode($row["open_time"], true);
    
    foreach($json as $jsn){
        //print_r($jsn);
        if($muricaTimeMode){
            $jsn['start'] = date('h:i a', strtotime($jsn['start']));
            $jsn['stop'] = date('h:i a', strtotime($jsn['stop']));
        }
            print($jsn['weekd']." ".$jsn['start']." - ".$jsn['stop']."<br>");
    }

    print("</pre></td>");

    print("</tr>");
}

?>
    </table>  

</body>
</html>