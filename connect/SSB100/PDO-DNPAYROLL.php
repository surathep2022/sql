<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// session_start();
// date_default_timezone_set('Asia/Bangkok');
$servername = "10.6.200.100";
$username = "sa";
$password = "password@123";
$dbName = 'DNPAYROLL';

try {
    $connPAYROLL = new PDO("sqlsrv:Server=$servername;Database=$dbName", $username, $password);
    // set the PDO error mode to exception
    $connPAYROLL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    // $_SESSION['success'] = "PDO Connected Databas: '" . $dbName . "' is successfully";
    $_SESSION['success'] = "PDO Connected Databas: PAYROLL is successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
    // $_SESSION['errorS'] = "PDO Connection Databas: '" . $dbName . "' is failed: " . $e->getMessage();
    $_SESSION['errorS'] = "PDO Connection Databas: PAYROLL is failed: " . $e->getMessage();
}

if (isset($_SESSION['success'])) {
    // echo $_SESSION['success'];
    // unset($_SESSION['success']);
?>
    <script language="javascript">
        // alert("<?php echo $_SESSION['success'] ?>");
        console.log("<?php echo $_SESSION['success'] ?>");
        <?php unset($_SESSION['success']); ?>
    </script>
<?php
} elseif (isset($_SESSION['errorS'])) {
    // echo $_SESSION['errorS'];
    // unset($_SESSION['errorS']);
?>
    <script language="javascript">
        // alert("<?php echo $_SESSION['errorS'] ?>");
        console.log("<?php echo $_SESSION['errorS'] ?>");
        <?php unset($_SESSION['errorS']); ?>
    </script>
<?php
} else {
    die("What the hell happened What is the cause?");
}
?>