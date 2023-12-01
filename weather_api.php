
<?php
    header('Content-Type: application/json');
    include_once('inc/wmo.php');
    
    define("LF","<br>");
    $cord=$_REQUEST;
    $cord=json_decode($cord["a"]);
    $cord = (Array) $cord;

    $rawdata=file_get_contents('https://api.open-meteo.com/v1/forecast?latitude='.$cord[1].'&longitude='.$cord[0].'&timezone=GMT&daily=weathercode');
    $data=json_decode($rawdata,true);
    $weather_code=$data["daily"]["weathercode"][0];

    $rawdata=file_get_contents('https://api.open-meteo.com/v1/forecast?latitude='.$cord[1].'&longitude='.$cord[0].'&hourly=temperature_2m');
    $data=json_decode($rawdata,true);
    $time=$data["hourly"]["time"];
    $temp=$data["hourly"]["temperature_2m"];

    $dataPoints = array();
    $h=date("H");
    for($i=$h+1;$i<49+$h;$i++){
       $dataPoints[]=array("y" => $temp[$i], "label" => "$time[$i]");
      }
    if($h<20){
        $dn="d";
    }else{
        $dn="n";
    }
    $all = array();
    $all["dataPoints"]=$dataPoints;
    $all["src"]="http://openweathermap.org/img/wn/".$wmocode[$weather_code][1].$dn."@2x.png";
    $all["tex"]=$wmocode[$weather_code][0];
    echo json_encode($all);
?>

 
 

