<?php

    //print_r($_POST);

    $articol = $_POST;

    $titlu = $articol["titlu"];
    $text_art = $articol["text"];
    //$text_preview = strtok($articol["text"], "\n");

    for($i = 0; $i < strlen($text_art); $i ++) {
        if($text_art[$i] == '<' && $text_art[$i+1] == 'p'){
            $start = $i;
            break;
        }
    }

    $end = strlen($text_art);
    
    for($i = 0; $i < strlen($text_art); $i ++) {
        if($text_art[$i] == '<' && $text_art[$i+1] == '\\' && $text_art[$i+2] == '/' && $text_art[$i+3] == 'p'){
            $end = $i;
            break;
        }
        if($text_art[$i] == '<' && $text_art[$i+1] == '/' && $text_art[$i+2] == 'p'){
            $end = $i;
            break;
        }
    }
    
    $text_preview = substr($text_art, $start, $end);

    print_r($text_preview);

    $image = $articol["image"];


    $json = file_get_contents('../articles.json');
    $data = json_decode($json, true);
    //print_r($data["articles"]);

    $articol_nou = [
        "title" => $titlu,
        "image" => ".\/articles_images\/".$image,
        "text preview" =>  $text_preview,
        "text" => $text_art,
        "views" => 0,
        "data" => date("d.m.Y")
    ];

    array_push($data["articles"], $articol_nou);

    //print_r($data["articles"]);

    $newJsonString = json_encode($data);
    file_put_contents('../articles.json', $newJsonString);

    echo "<script> location.href='../index.php'; </script>";
    exit;

?>