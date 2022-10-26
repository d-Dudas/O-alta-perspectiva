

<?php

    //print_r($_GET);

    $id = $_GET["id_articol"];

    $json = file_get_contents('articles.json');
    $data = json_decode($json, true);
    $data["articles"][$id]["views"]++;

    //print_r($data["articles"][$id]);
    include 'header.php';

    /*
    <-- S-ar putea sa am nevoie mai incolo de astea -->$_COOKIE
    <img src=\"".$data["articles"][$id]["image"]."\" alt=\"\" class = \"imagine_articol_afisat\"> 
    <p class= \"text_articol_afisat\">".$data["articles"][$id]["text"]."</p>
    */

    echo "

        <div class = \"articol_afisat\">
            <h1 class = \"titlu_articol_afisat\">".$data["articles"][$id]["title"]."</h1>".
            $data["articles"][$id]["text"]."
            <div id = 'dateviews'>
                <p>".$data["articles"][$id]["data"]."</p>
                <p>Views: ".$data["articles"][$id]["views"]."</p>
            </div>
    
        </div>
        
        <div class=\"box-date-and-hour\" id = \"box_dah\">
            <h1 id=\"ora\"></h1>
            <h1 id=\"minute\"></h1>
            <h1 id=\"data\"></h1>
        </div>
        ";

    $newJsonString = json_encode($data);
    file_put_contents('./articles.json', $newJsonString);

    include 'footer.php';
?>