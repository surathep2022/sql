<?php
include_once '../0top.php';

if (isset($_POST['submitMemo'])) {
    echo $_POST['AppointmentNo'];
    echo '<br>';
    echo $_POST['day'];
    echo '<br>';
    echo $_POST['time'];
    echo '<br>';
    echo $_POST['Memo'];
    echo '<br>';

    $AppointmentNo = $_POST['AppointmentNo'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $Memo = $_POST['Memo'];
    $user = '';
    try {
        $sqlINSERT = "INSERT INTO log (AppointmentNo, day, time, Memo, user) 
                                  VALUES (:AppointmentNo, :day, :time, :Memo, :user)";
        $stmtINSERT = $connlocal->prepare($sqlINSERT);
        $stmtINSERT->bindParam(':AppointmentNo', $AppointmentNo);
        $stmtINSERT->bindParam(':day', $day);
        $stmtINSERT->bindParam(':time', $time);
        $stmtINSERT->bindParam(':Memo', $Memo);
        $stmtINSERT->bindParam(':user', $user);
        $stmtINSERT->execute();
        // echo "INSERT successfully";
        $_SESSION['success'] = "INSERT successfully";
    } catch (PDOException $e) {
        // echo "Error " . $e->getMessage();
        $_SESSION['error'] = "Error " . $e->getMessage();
    }
    // header("Location: ../index.php");
    // exit;
}
