<?php
include_once '0top.php';
$_SESSION['Page_Active'] = 'EXPORT.php';

if (isset($_POST['submitDate'])) {
    // Retrieve form data
    $tmp1 = $_POST['startdate'];
    $tmp2 = $_POST['enddate'];
    // Check if $tmp1 is greater than $tmp2
    if ($tmp1 > $tmp2) {
        $_SESSION['startdate'] = $tmp2;
        $_SESSION['enddate'] = $tmp1;
    } else {
        $_SESSION['startdate'] = $tmp1;
        $_SESSION['enddate'] = $tmp2;
    }
    if (empty($_SESSION['startdate']) && !empty($_SESSION['enddate'])) {
        $_SESSION['startdate'] = $_SESSION['enddate'];
    } elseif (!empty($_SESSION['startdate']) && empty($_SESSION['enddate'])) {
        $_SESSION['enddate'] = $_SESSION['startdate'];
    }
}

$_SESSION['startdate'] = empty($_SESSION['startdate']) ? date('Y-m-d') : $_SESSION['startdate'];
$_SESSION['enddate'] = empty($_SESSION['enddate']) ? date('Y-m-d') : $_SESSION['enddate'];

$query = "SELECT 
            AppointmentNo
            ,HN
            ,Doctor
            ,DoctorName=(select top 1  substring(isnull(localname,englishname),2,100) From DNHOSPITAL.dbo.DNSYSCONFIG as TBCFG where TBCFG.CtrlCode='10031' and TBCFG.code=Doctor)
            ,Clinic_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic)
            ,Clinic=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic)
            ,Right_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42086' AND Code = RightCode)
            ,RightCode=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42086' AND Code = RightCode)
            ,App_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42211' AND Code = AppmntProcedureCode1)
            ,App=(SELECT STUFF(LocalName, 1, 1, '')  FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42211' AND Code = AppmntProcedureCode1)
            ,AppmntProcedureCode1 
            ,CONVERT(VARCHAR, FORMAT(AppointDateTime, 'yyyy-MM-dd HH:mm'), 120) as AppointDateTime
            ,TelephoneNo
            ,MobilePhone
            ,FirstName=(SELECT top 1 STUFF(FirstName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN) 
            ,LastName=(SELECT top 1 STUFF(LastName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN)
        From HNAPPMNT_HEADER
        Where 1=1
            AND CONVERT(date, AppointDateTime) BETWEEN CONVERT(date,:StartDate) AND CONVERT(date,:EndDate)
        ORDER BY CONVERT(date, AppointDateTime) ASC";
try {
    $stmt = $connHos->prepare($query);
    $stmt->bindParam(':StartDate', $_SESSION['startdate']);
    $stmt->bindParam(':EndDate', $_SESSION['enddate']);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error stmtclinic " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <title>EXPORT - <?= $hospitalname ?></title>
    <?php include_once '0head.php'; ?>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72">
    <?php include_once '0navbar.php'; ?>
    <section id="portfolio" class="portfolio" style="padding-top: 150px;">
        <div class="container" style="padding-left: 0px;padding-right: 0px;">
            <div class="row d-flex justify-content-">
                <div class="col-12">
                    <h2 class="text-center mb-4">EXPORT</h2>
                    <form action="" method="post">
                        <div class='text-center'>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">วันที่
                                <input class="form-control" type="date" name="startdate">
                            </label>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ถึงวันที่
                                <input class="form-control" type="date" name="enddate">
                            </label>
                            <button name="submitDate" class="btn btn-primary ms-md-2" type="submit">ค้นหา</button>
                        </div>
                    </form>
                </div>
                <div class="col-12">
                    <div class="row d-flex justify-content-">
                        <div class="col-6">
                            <div class="text-start">
                                <h4 style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">วันที่ : <?= $_SESSION['startdate'] ?> ถึงวันที่ : <?= $_SESSION['enddate'] ?></h4>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <button onclick="exportToExcel()" type="button" class="btn btn-dark btn-lg" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">export</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-bordered" id="report_Appointment">
                        <thead>
                            <tr style="text-align: center;">
                                <th>เบอร์</th>
                                <th>ข้อความ</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: start;">
                            <?php if ($rows) {
                                foreach ($rows as $row) { ?>
                                    <tr>
                                        <td><?= $row['MobilePhone']; ?></td>
                                        <td>คุณ <?= $row['FirstName'] . ' ' . $row['LastName'] ?> มีนัดพบ <?= $row['DoctorName'] ?> แผนก <?= $row['Clinic'] ?> วันที่ <?= getOnlyDay($row['AppointDateTime']) ?> เวลา <?= getOnlyTime($row['AppointDateTime']) ?> น.</td>
                                    </tr>
                                <?php }
                            } else { ?>
                                <tr>
                                    <td colspan='3' class='text-center'>no data!!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="d-lg-none scroll-to-top position-fixed rounded">
        <a class="text-center d-block rounded text-white" href="#page-top"><i class="fa fa-chevron-up"></i></a>
    </div>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/freelancer.js"></script>

    <!-- Export HTML to Excel -->
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

    <script>
        function exportToExcel() {
            const table = document.getElementById("report_Appointment");
            const workbook = XLSX.utils.book_new();
            const worksheet = XLSX.utils.json_to_sheet(getTableData(table), {
                raw: true
            });

            // Iterate through the rows
            for (const key in worksheet) {
                if (worksheet.hasOwnProperty(key) && key.startsWith('!ref')) {
                    const range = XLSX.utils.decode_range(worksheet[key]);
                    for (let R = range.s.r; R <= range.e.r; ++R) {
                        for (let C = range.s.c; C <= range.e.c; ++C) {
                            const cellAddress = {
                                r: R,
                                c: C
                            };
                            const cellObject = worksheet[XLSX.utils.encode_cell(cellAddress)];

                            // Set the cell type to string and update the value
                            if (cellObject && cellObject.t === 'n' && typeof cellObject.v === 'number') {
                                cellObject.t = 's';
                                cellObject.v = String(cellObject.v);
                                cellObject.w = String(cellObject.v);
                            }
                        }
                    }
                }
            }

            XLSX.utils.book_append_sheet(workbook, worksheet, "Appointment");
            XLSX.writeFile(workbook, "report_Appointment.xlsx");
        }

        function getTableData(table) {
            const data = [];
            const headers = [];
            for (let i = 0; i < table.rows[0].cells.length; i++) {
                headers[i] = table.rows[0].cells[i].textContent.trim();
            }

            for (let i = 1; i < table.rows.length; i++) {
                const row = {};
                for (let j = 0; j < table.rows[i].cells.length; j++) {
                    row[headers[j]] = table.rows[i].cells[j].textContent.trim();
                }
                data.push(row);
            }

            return data;
        }
    </script>

</body>

</html>