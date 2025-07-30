<?php
include_once '../0top.php';

$query = "SELECT 
            Code
            ,STUFF(LocalName, 1, 1, '') as LocalName
        FROM dbo.DNSYSCONFIG 
        WHERE CtrlCode = '42203'";
try {
    $stmt = $connHos->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error stmt " . $e->getMessage());
}
$no = 0;

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">LocalName</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($query) {
                    foreach ($rows as $row) { ?>
                        <?php $no++; ?>
                        <tr>
                            <td scope="row"><?= $no ?></td>
                            <td><?= $row['Code'] ?></td>
                            <td><?= $row['LocalName'] ?></td>
                            <?php
                            $checklocal = "SELECT COUNT(*) FROM clinic WHERE code = :code";
                            try {
                                $stmtchecklocal = $connlocal->prepare($checklocal);
                                $stmtchecklocal->bindParam(':code', $row['Code']);
                                $stmtchecklocal->execute();
                                $checkRows = $stmtchecklocal->fetchColumn();
                            } catch (PDOException $e) {
                                die("Error stmtcheck->execute(): " . $e->getMessage());
                            }

                            if ($checkRows > 0) {
                                try {
                                    $sqlUPDATE = "UPDATE clinic SET LocalName = :LocalName WHERE code = :code";
                                    $stmtUPDATE = $connlocal->prepare($sqlUPDATE);
                                    $stmtUPDATE->bindParam(':code', $row['Code']);
                                    $stmtUPDATE->bindParam(':LocalName', $row['LocalName']);
                                    $stmtUPDATE->execute();
                                    echo "<td>stmtUPDATE successfully</td>";
                                } catch (PDOException $e) {
                                    echo "<td>Error stmtUPDATE" . $e->getMessage()."</td>";
                                }
                            } else {
                                try {
                                    $sqlINSERT = "INSERT INTO clinic (code, LocalName) VALUES (:code, :LocalName)";
                                    $stmtINSERT = $connlocal->prepare($sqlINSERT);
                                    $stmtINSERT->bindParam(':code', $row['Code']);
                                    $stmtINSERT->bindParam(':LocalName', $row['LocalName']);
                                    $stmtINSERT->execute();
                                    echo "<td>stmtINSERT successfully</td>";
                                } catch (PDOException $e) {
                                    echo "<td>Error stmtINSERT" . $e->getMessage()."</td>";
                                }
                            } ?>                           
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>