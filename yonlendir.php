<?php

$GelenKlasorIsmi        =  $_POST["klasorIsmi"];

if($GelenKlasorIsmi == ""){
    $DurumKodu = 0;
    header("Location: index.php");
}else{

    $KlasorIsmi = $GelenKlasorIsmi;
    // eğer klasör ismi dizindeki hiçbir klasörle eşleşmiyorsa hata ver
    if(!is_dir($KlasorIsmi)){
        $DurumKodu = 1;
        header("Location: index.php");
    }
    else{
        $DurumKodu = 2;
        header("Location: $KlasorIsmi");
    }
}



?>