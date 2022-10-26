<?php
    include 'header.php';
    include './includes/functions.inc.php';

    if(isset($_POST['stergere'])) {
        preg_match_all('!\d+!', $_POST['stergere'], $id);
        $id = $id[0][0];
        echo '
            <div class = "confirmBoxBackground">
                <div class = "confirmBox">
                    <p>Confirmați această operațiue?</p>
                    <form action = "controlPanel.php" method = "POST">
                        <input type = "submit" name = "exit" value = "Exit" id = "exitbt">
                        <input type = "submit" name = "confirm" value = "Confirm ștergerea articol '.$id.'" id = "confirmbt">
                    </form>
                </div>
            </div>       
            ';
    }

    if(isset($_POST['editare'])) {
        preg_match_all('!\d+!', $_POST['editare'], $id);
        $id = $id[0][0];
        //print_r($id);
        header("location: ./editareArticole.php?id=".$id."");
    }

    if(isset($_POST['confirm'])) {
        preg_match_all('!\d+!', $_POST['confirm'], $id);
        $id = $id[0][0];
        deleteArticol($id);
    }

    if(isset($_POST['userUid'])) {
        setAdmin($_POST['userUid']); 
    }

    if(isset($_POST['deleteAdmin'])) {
        $string = $_POST['deleteAdmin'];
        $pieces = explode(' ', $string);
        $uid = array_pop($pieces);
        unsetAdmin($uid);
    }

?>

<section class = "admin_section">
    <div class = "adminControlBox">
        <form method = "POST" action="controlPanel.php" id = "setAdminForm">
            <input type="text" name = "userUid" placeholder = "Username/email...">
            <input type="submit" value="Setare admin">
            <?php
                if(isset($_GET['error'])) {
                    if($_GET['error'] == 'uidNotFound'){
                        echo'<p style = "color: red; margin-left: 10px;">User not found</p>';
                    }
                }
            ?>
        </form>
        <form method = "POST" action="controlPanel.php" id = "listAdmins">
            <?php
                $admins = listOfAdmins();
                for($i=count($admins)-1; $i >= 0; $i--) {
                    echo '<input class = "deleteAdminButton" type = "submit" name = "deleteAdmin" value = "Șterge adminul: '.$admins[$i]['usersUid'].'">';
                }
            ?>
</form>
    </div>

    <?php
        $json = file_get_contents('./articles.json');
        $data = json_decode($json, true);

        $id = count($data["articles"])-1;
        echo '<div class="box-articole" id="box-articole-admin">';
        //print_r($data["articles"]);
        while($id >= 0) {
            $articol = $data["articles"][$id];
            print_r('
                <a href = "articol.php?id_articol='.$id.'">
                    <div class = "card-articol card-articol-admin">
                        <div style = "background-image: url('.$articol["image"].'); background-size: cover; background-position: center"></div>
                        <div class = "texts">
                            <h1>'.$articol['title'].'</h1>
                            <p>'.$articol['text preview'].'</p>
                        </div>
                        <form action = "controlPanel.php" method = "POST">
                            <input class = "opt-bt" type = "submit" name = "stergere" value = "Șterge articolul '.$id.'">
                            <input class = "opt-bt" type = "submit" name = "editare" value = "Editează articolul '.$id.'">
                        </form>
                    </div>
                </a>
            ');
            $id--;
        }

        echo '</div>';
    ?>
</section>


<?php
    include 'footer.php';

    /* echo '
            <a href="articol.php?id_articol='.$id.'">
                <div class="card-articol card-articol-admin">
                    <div style = "background-image: url('.$articol["image"].'); background-size: cover; background-position: center"></div>
                    <div class="texts">
                        <h1>'.$articol["title"].'</h1>
                        <p>
                            '.$articol["text preview"].'
                        </p>
                    </div>
                    <form action = "controlPanel.php" method = "POST">
                        <input class = "opt-bt" type = "submit" name = "stergere" value = "Șterge articolul '.$id.'">
                        <input class = "opt-bt" type = "submit" name = "editare" value = "Editează articolul '.$id.'">
                    </form>
                </div>
            </a>';
            */
?>