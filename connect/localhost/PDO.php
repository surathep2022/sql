<?php
$servername = "localhost";
$username = "root";
$password = "Admin@2018";
$myDB = 'appointment';

try {
    $connlocal = new PDO("mysql:host=$servername;dbname=$myDB", $username, $password);
    $connlocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $_SESSION['success'] = "PDO Connected Databas: '" . $myDB . "' connlocal is successfully";
} catch (PDOException $e) {
    $_SESSION['errorS'] = "PDO Connection Databas: '" . $myDB . "' connlocal is failed: " . $e->getMessage();
}

if (isset($_SESSION['success'])) { ?>
    <script language="javascript">
        console.log("<?php echo $_SESSION['success'] ?>");
        <?php unset($_SESSION['success']); ?>
    </script>
<?php } elseif (isset($_SESSION['errorS'])) { ?>
    <script language="javascript">
        console.log("<?php echo $_SESSION['errorS'] ?>");
        <?php unset($_SESSION['errorS']); ?>
    </script>
<?php } else {
    die("What the hell happened What is the cause?");
} ?>