<?php

function invalidUid($username) {
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function invalidemail($email) {
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat) {
    $result;
    if($pwd !== $pwdRepeat) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username, $email) {
    $result;
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    }
    else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $username, $pwd) {
    $result;
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, ifAdmin) VALUES (?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    $ifadmin = 0;

    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $username, $hashedPwd, $ifadmin);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../login.php");
    exit();
}

function emptyInputLogin($username, $pwd) {
    $result;
    if(empty($username) || empty($pwd)) {
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists === false) {
        header("location: ../login.php?error=wronguidoremail");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=wrongpassword");
        exit();
    }
    else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["ifadmin"] = $uidExists["ifAdmin"];
        header("location: ../index.php");
        exit();
    }
}

function deleteArticol($id) {

    $json = file_get_contents('./articles.json');
    $data = json_decode($json, true);

    array_splice($data['articles'], $id, 1);

    $newJsonString = json_encode($data);
    file_put_contents('./articles.json', $newJsonString);

    header("location: ./controlPanel.php");
    exit();
}

function setAdmin($uid) {
    $serverName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "oAltaPerspectiva";

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    $uidExists = uidExists($conn, $uid, $uid);


    if($uidExists == false) {
        header("location: ./controlPanel.php?error=uidNotFound");
        exit();
    }
    else {
        $sql = "UPDATE users SET ifAdmin=1 WHERE usersEmail = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../controlPanel.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $uidExists['usersEmail']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ./controlPanel.php");
        exit();
    }
}

function unsetAdmin($uid) {
    $serverName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "oAltaPerspectiva";

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    $uidExists = uidExists($conn, $uid, $uid);


    if($uidExists == false) {
        header("location: ./controlPanel.php?error=uidNotFound");
        exit();
    }
    else {
        $sql = "UPDATE users SET ifAdmin=0 WHERE usersEmail = ?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../controlPanel.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $uidExists['usersEmail']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ./controlPanel.php");
        exit();
    }
}

function listOfAdmins() {
    $serverName = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "oAltaPerspectiva";

    $conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

    $sql = "SELECT usersUid FROM users WHERE ifAdmin = 1 ORDER BY usersUid";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../controlPanel.php?error=stmtfailed");
        exit();
    }

    $data_result = mysqli_query($conn, $sql);

    $result = array();

    while($row = mysqli_fetch_assoc($data_result)) {
        array_push($result, $row);
    }

    return $result;
}