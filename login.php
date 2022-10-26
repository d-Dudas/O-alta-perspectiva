<?php
    include 'header.php';
?>

<section class = "center-section">
    <div class="sign-up-style">
        <h2>Autentificare</h2>
        <form action="./includes/login.inc.php" method="post"> 
            <input type="text" name="name" placeholder = "Email/Nume utilizator...">
            <input type="password" name="pwd" placeholder = "Parola...">
            <button type="submit" name="submit">Autentificare</button>
        </form>
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Completați fiecare casetă!</p>";
                }
                else if ($_GET["error"] == "wronguidoremail") {
                    echo "<p>Nu există utilizator înregistrat cu acest nume de utilizator sau email.</p>";
                }
                else if ($_GET["error"] == "wrongpassword") {
                    echo "<p>Parolă incorectă.</p>";
                }
            }
        ?>
    </div>
</section>

<?php
    include 'footer.php';
?>