<?php
    include 'header.php';
?>

<section class = "center-section">
    <div class="sign-up-style">
        <h2>Înregistrare</h2>
        <form action="./includes/signup.inc.php" method="post"> 
            <input type="text" name="name" placeholder = "Numele complet...">
            <input type="text" name="email" placeholder = "Email...">
            <input type="text" name="uid" placeholder = "Nume utilizator...">
            <input type="password" name="pwd" placeholder = "Parola...">
            <input type="password" name="pwdrepeat" placeholder = "Confirmare parola...">
            <button type="submit" name="submit">Înregistrare</button>
        </form>
        <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p>Completați fiecare casetă!</p>";
                }
                else if ($_GET["error"] == "invaliduid") {
                    echo "<p>Încercați un alt nume de utilizator!</p>";
                }
                else if ($_GET["error"] == "invalidemail") {
                    echo "<p>Email-ul introdus nu este corect!</p>";
                }
                else if ($_GET["error"] == "passwordsdontmatch") {
                    echo "<p>Parolele nu corespund</p>";
                }
                else if ($_GET["error"] == "stmtfailed") {
                    echo "<p>A apărut o eroare. Încercați din nou.</p>";
                }
                else if ($_GET["error"] == "usernametaken") {
                    echo "<p>Deja există un utilizator care folosește acest nume de utilizator sau acest email.</p>";
                }
            }
        ?>
    </div>
</section>

<?php
    include 'footer.php';
?>