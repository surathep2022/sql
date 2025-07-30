<?php
include_once '0top.php';
$_SESSION['Page_Active'] = 'index.php';

if (isset($_POST['submitMemo'])) {
    $AppointmentNo = $_POST['AppointmentNo'];
    $AppointDate = $_POST['AppointDate'];
    $day = $_POST['day'];
    $time = $_POST['time'];
    $Memo = $_POST['Memo'];
    $user = '';
    try {
        $sqlINSERT = "INSERT INTO log (AppointmentNo, AppointDate, day, time, Memo, user) 
                            VALUES (:AppointmentNo, :AppointDate, :day, :time, :Memo, :user)";
        $stmtINSERT = $connlocal->prepare($sqlINSERT);
        $stmtINSERT->bindParam(':AppointmentNo', $AppointmentNo);
        $stmtINSERT->bindParam(':AppointDate', $AppointDate);
        $stmtINSERT->bindParam(':day', $day);
        $stmtINSERT->bindParam(':time', $time);
        $stmtINSERT->bindParam(':Memo', $Memo);
        $stmtINSERT->bindParam(':user', $user);
        $stmtINSERT->execute();
        $_SESSION['success'] = "INSERT successfully";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error " . $e->getMessage();
    }
}


if (isset($_POST['submitClinicDate'])) {
    // Retrieve form data    
    if (isset($_POST['startdate'])) {
        $tmp1 = $_POST['startdate'];
    }
    if (isset($_POST['enddate'])) {
        $tmp2 = $_POST['enddate'];
    }
    // Check if $tmp1 is greater than $tmp2
    if ($tmp1 != null or $tmp2 != null) {
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
    $tmp1 = null;
    $tmp2 = null;
    // Retrieve form data
    if ((isset($_POST['clinic_code'])) and $_POST['clinic_code'] != '') {
        $_SESSION['clinic_code'] = $_POST['clinic_code'];
    } elseif (isset($_POST['ClinicGroup']) and $_POST['ClinicGroup'] != '') {
        $_SESSION['ClinicGroup'] = $_POST['ClinicGroup'];

        unset($_SESSION['clinic_code']);
        unset($_SESSION['clinic_name']);
        $_SESSION['ClinicGroup_name'] = $_POST['ClinicGroup'];
    }
} elseif (isset($_POST['submitReset'])) {
    unset($_SESSION['clinic_code']);
    unset($_SESSION['clinic_name']);
    unset($_SESSION['ClinicGroup_name']);
    unset($_SESSION['ClinicGroup']);
}

if (empty($_SESSION['startdate']) and empty($_SESSION['enddate']) and empty($_SESSION['clinic_code']) and empty($_SESSION['ClinicGroup'])) {
    $_SESSION['startdate'] = empty($_SESSION['startdate']) ? date('Y-m-d') : $_SESSION['startdate'];
    $_SESSION['enddate'] = empty($_SESSION['enddate']) ? date('Y-m-d') : $_SESSION['enddate'];
    // $_SESSION['clinic_code'] = empty($_SESSION['clinic_code']) ? '01001' : $_SESSION['clinic_code'];
    // $_SESSION['ClinicGroup'] = empty($_SESSION['ClinicGroup']) ? 'GYN' : $_SESSION['ClinicGroup'];
    unset($_SESSION['clinic_code']);
    unset($_SESSION['clinic_name']);
    unset($_SESSION['ClinicGroup_name']);
}

if ((isset($_POST['clinic_code'])) and $_POST['clinic_code'] != '') {
    $query_clinic_submit = "SELECT 
                            code
                            ,LocalName
                            ,CASE		
                                WHEN code in ('07031','07032','07038','07039') THEN 'ARI'
                                WHEN code in ('07033') THEN 'Drive-through'
                                WHEN code in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                                WHEN code in ('01001','01003','01005','15006') THEN 'GYN'
                                WHEN code in ('15007','15009') THEN 'เวชปฏิบัติ'
                                WHEN code in ('07043') THEN 'Home Isolation'
                                WHEN code in ('07046') THEN 'Hospitel'
                                WHEN code in ('07047') THEN 'Hotel'
                                WHEN code in ('20000') THEN 'Metro Health'
                                WHEN code in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                                WHEN code in ('01002','01004','01006') THEN 'OBS+ANC'
                                WHEN code in ('13003','15022') THEN 'Observe Room'
                                WHEN code in ('15036') THEN 'ODS SC'
                                WHEN code in ('07044','07045') THEN 'Op Selft'
                                WHEN code in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                                WHEN code in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                                WHEN code in ('07034','07035','07036','07037') THEN 'Screening'
                                WHEN code in ('07040','07041') THEN 'SHA PLUS'
                                WHEN code in ('06001','06002') THEN 'กายภาพบำบัด'
                                WHEN code in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                                WHEN code in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                                WHEN code in ('11002','15005') THEN 'จักษุวิทยา'
                                WHEN code in ('04015','05013','15020') THEN 'จิตเวช'
                                WHEN code in ('15037') THEN 'ฉีดวัคซีน COVID'
                                WHEN code in ('15039') THEN 'ฉีดวัคซีน Moderna'
                                WHEN code in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                                WHEN code in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                                WHEN code in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                                WHEN code in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                                WHEN code in ('07003','07004') THEN 'นิติเวช'
                                WHEN code in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                                WHEN code in ('19001') THEN 'โภชนาการบำบัด'
                                WHEN code in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                                WHEN code in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                                WHEN code in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                                WHEN code in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                                WHEN code in ('13002') THEN 'ห้องคลอด'
                                WHEN code in ('11001','15001') THEN 'หู คอ จมูก'
                                WHEN code in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                                WHEN code in ('14009') THEN 'FUA'
                                WHEN code in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                                ELSE 'no Group'
                            END as ClinicGroup
                        FROM clinic
                        WHERE code = :code";
    try {
        $stmtsubmit = $connlocal->prepare($query_clinic_submit);
        $stmtsubmit->bindParam(':code', $_SESSION['clinic_code']);
        $stmtsubmit->execute();
        $submitclinic = $stmtsubmit->fetch(PDO::FETCH_ASSOC);
        $_SESSION['clinic_name'] = $submitclinic['LocalName'];
        $_SESSION['ClinicGroup_name'] = $submitclinic['ClinicGroup'];
    } catch (PDOException $e) {
        die("Error stmtclinic " . $e->getMessage());
    }
}

$query_clinic = "SELECT 
                    code
                    ,LocalName
                FROM clinic
                ORDER BY code ASC";
try {
    $stmtclinic = $connlocal->prepare($query_clinic);
    $stmtclinic->execute();
    $clinic_rows = $stmtclinic->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error stmtclinic " . $e->getMessage());
}

$query_ClinicGroup = "SELECT DISTINCT
                            CASE		
                                WHEN code in ('07031','07032','07038','07039') THEN 'ARI'
                                WHEN code in ('07033') THEN 'Drive-through'
                                WHEN code in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                                WHEN code in ('01001','01003','01005','15006') THEN 'GYN'
                                WHEN code in ('15007','15009') THEN 'เวชปฏิบัติ'
                                WHEN code in ('07043') THEN 'Home Isolation'
                                WHEN code in ('07046') THEN 'Hospitel'
                                WHEN code in ('07047') THEN 'Hotel'
                                WHEN code in ('20000') THEN 'Metro Health'
                                WHEN code in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                                WHEN code in ('01002','01004','01006') THEN 'OBS+ANC'
                                WHEN code in ('13003','15022') THEN 'Observe Room'
                                WHEN code in ('15036') THEN 'ODS SC'
                                WHEN code in ('07044','07045') THEN 'Op Selft'
                                WHEN code in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                                WHEN code in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                                WHEN code in ('07034','07035','07036','07037') THEN 'Screening'
                                WHEN code in ('07040','07041') THEN 'SHA PLUS'
                                WHEN code in ('06001','06002') THEN 'กายภาพบำบัด'
                                WHEN code in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                                WHEN code in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                                WHEN code in ('11002','15005') THEN 'จักษุวิทยา'
                                WHEN code in ('04015','05013','15020') THEN 'จิตเวช'
                                WHEN code in ('15037') THEN 'ฉีดวัคซีน COVID'
                                WHEN code in ('15039') THEN 'ฉีดวัคซีน Moderna'
                                WHEN code in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                                WHEN code in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                                WHEN code in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                                WHEN code in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                                WHEN code in ('07003','07004') THEN 'นิติเวช'
                                WHEN code in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                                WHEN code in ('19001') THEN 'โภชนาการบำบัด'
                                WHEN code in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                                WHEN code in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                                WHEN code in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                                WHEN code in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                                WHEN code in ('13002') THEN 'ห้องคลอด'
                                WHEN code in ('11001','15001') THEN 'หู คอ จมูก'
                                WHEN code in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                                WHEN code in ('14009') THEN 'FUA'
                                WHEN code in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                                ELSE 'no Group'
                            END as ClinicGroup
                    FROM clinic ";
try {
    $stmtClinicGroup = $connlocal->prepare($query_ClinicGroup);
    $stmtClinicGroup->execute();
    $ClinicGroup_rows = $stmtClinicGroup->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error stmtClinicGroup " . $e->getMessage());
}

$rowsPerPage = 20;
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate total pages
$RowsQuery = "  SELECT COUNT(*)
                From HNAPPMNT_HEADER
                Where 1=1
                    AND CxlReasonCode is NULL
                    AND CONVERT(date, AppointDateTime) BETWEEN CONVERT(date,:StartDate) AND CONVERT(date,:EndDate) ";
if (isset($_SESSION['clinic_code'])) {
    $RowsQuery .= " AND Clinic = :clinic_code ";
} elseif (isset($_SESSION['ClinicGroup'])) {
    $RowsQuery .= " AND (CASE		
                            WHEN Clinic in ('07031','07032','07038','07039') THEN 'ARI'
                            WHEN Clinic in ('07033') THEN 'Drive-through'
                            WHEN Clinic in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                            WHEN Clinic in ('01001','01003','01005','15006') THEN 'GYN'
                            WHEN Clinic in ('15007','15009') THEN 'เวชปฏิบัติ'
                            WHEN Clinic in ('07043') THEN 'Home Isolation'
                            WHEN Clinic in ('07046') THEN 'Hospitel'
                            WHEN Clinic in ('07047') THEN 'Hotel'
                            WHEN Clinic in ('20000') THEN 'Metro Health'
                            WHEN Clinic in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                            WHEN Clinic in ('01002','01004','01006') THEN 'OBS+ANC'
                            WHEN Clinic in ('13003','15022') THEN 'Observe Room'
                            WHEN Clinic in ('15036') THEN 'ODS SC'
                            WHEN Clinic in ('07044','07045') THEN 'Op Selft'
                            WHEN Clinic in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                            WHEN Clinic in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                            WHEN Clinic in ('07034','07035','07036','07037') THEN 'Screening'
                            WHEN Clinic in ('07040','07041') THEN 'SHA PLUS'
                            WHEN Clinic in ('06001','06002') THEN 'กายภาพบำบัด'
                            WHEN Clinic in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                            WHEN Clinic in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                            WHEN Clinic in ('11002','15005') THEN 'จักษุวิทยา'
                            WHEN Clinic in ('04015','05013','15020') THEN 'จิตเวช'
                            WHEN Clinic in ('15037') THEN 'ฉีดวัคซีน COVID'
                            WHEN Clinic in ('15039') THEN 'ฉีดวัคซีน Moderna'
                            WHEN Clinic in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                            WHEN Clinic in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                            WHEN Clinic in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                            WHEN Clinic in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                            WHEN Clinic in ('07003','07004') THEN 'นิติเวช'
                            WHEN Clinic in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                            WHEN Clinic in ('19001') THEN 'โภชนาการบำบัด'
                            WHEN Clinic in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                            WHEN Clinic in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                            WHEN Clinic in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                            WHEN Clinic in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                            WHEN Clinic in ('13002') THEN 'ห้องคลอด'
                            WHEN Clinic in ('11001','15001') THEN 'หู คอ จมูก'
                            WHEN Clinic in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                            WHEN Clinic in ('14009') THEN 'FUA'
                            WHEN Clinic in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                            ELSE 'no Group'
                        END) = :ClinicGroup ";
}
$totalRowsQuery = $connHos->prepare($RowsQuery);
$totalRowsQuery->bindParam(':StartDate', $_SESSION['startdate']);
$totalRowsQuery->bindParam(':EndDate', $_SESSION['enddate']);
if (isset($_SESSION['clinic_code'])) {
    $totalRowsQuery->bindParam(':clinic_code', $_SESSION['clinic_code']);
} elseif (isset($_SESSION['ClinicGroup'])) {
    $totalRowsQuery->bindParam(':ClinicGroup', $_SESSION['ClinicGroup']);
}
$totalRowsQuery->execute();
$totalRows = $totalRowsQuery->fetchColumn();
$totalPages = ceil($totalRows / $rowsPerPage);

// Ensure $current_page is within a valid range
if ($current_page < 1) {
    $current_page = 1;
} elseif ($current_page > $totalPages) {
    $current_page = $totalPages;
}

// Calculate the range of visible page buttons (e.g., 10 pages)
$visible_pages = 10;
$start_page = max(1, $current_page - ($visible_pages / 2));
$end_page = min($totalPages, $start_page + $visible_pages - 1);
$start_page = max(1, $end_page - $visible_pages + 1);

// Calculate the offset
$offset = max(0, ($current_page - 1) * $rowsPerPage);

// Query to fetch data for the current page
$query = "SELECT 
        AppointmentNo
        ,HN
        ,Doctor
        ,DoctorName=(select top 1  substring(isnull(localname,englishname),2,100) From DNHOSPITAL.dbo.DNSYSCONFIG as TBCFG where TBCFG.CtrlCode='10031' and TBCFG.code=Doctor)
        ,Clinic as Clinic_Code
        ,Clinic=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic)
        ,ClinicGroup = CASE		
                WHEN Clinic in ('07031','07032','07038','07039') THEN 'ARI'
                WHEN Clinic in ('07033') THEN 'Drive-through'
                WHEN Clinic in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                WHEN Clinic in ('01001','01003','01005','15006') THEN 'GYN'
                WHEN Clinic in ('15007','15009') THEN 'เวชปฏิบัติ'
                WHEN Clinic in ('07043') THEN 'Home Isolation'
                WHEN Clinic in ('07046') THEN 'Hospitel'
                WHEN Clinic in ('07047') THEN 'Hotel'
                WHEN Clinic in ('20000') THEN 'Metro Health'
                WHEN Clinic in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                WHEN Clinic in ('01002','01004','01006') THEN 'OBS+ANC'
                WHEN Clinic in ('13003','15022') THEN 'Observe Room'
                WHEN Clinic in ('15036') THEN 'ODS SC'
                WHEN Clinic in ('07044','07045') THEN 'Op Selft'
                WHEN Clinic in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                WHEN Clinic in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                WHEN Clinic in ('07034','07035','07036','07037') THEN 'Screening'
                WHEN Clinic in ('07040','07041') THEN 'SHA PLUS'
                WHEN Clinic in ('06001','06002') THEN 'กายภาพบำบัด'
                WHEN Clinic in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                WHEN Clinic in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                WHEN Clinic in ('11002','15005') THEN 'จักษุวิทยา'
                WHEN Clinic in ('04015','05013','15020') THEN 'จิตเวช'
                WHEN Clinic in ('15037') THEN 'ฉีดวัคซีน COVID'
                WHEN Clinic in ('15039') THEN 'ฉีดวัคซีน Moderna'
                WHEN Clinic in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                WHEN Clinic in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                WHEN Clinic in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                WHEN Clinic in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                WHEN Clinic in ('07003','07004') THEN 'นิติเวช'
                WHEN Clinic in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                WHEN Clinic in ('19001') THEN 'โภชนาการบำบัด'
                WHEN Clinic in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                WHEN Clinic in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                WHEN Clinic in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                WHEN Clinic in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                WHEN Clinic in ('13002') THEN 'ห้องคลอด'
                WHEN Clinic in ('11001','15001') THEN 'หู คอ จมูก'
                WHEN Clinic in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                WHEN Clinic in ('14009') THEN 'FUA'
                WHEN Clinic in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                ELSE 'no Group'
            END
        ,RightCode as RightCode_Code
        ,RightCode=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42086' AND Code = RightCode)
        ,AppmntProcedureCode1 as App_Code
        ,App=(SELECT STUFF(LocalName, 1, 1, '')  FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42211' AND Code = AppmntProcedureCode1)
        ,AppmntProcedureCode1 
        ,CONVERT(VARCHAR, FORMAT(AppointDateTime, 'yyyy-MM-dd HH:mm'), 120) as AppointDateTime
        ,TelephoneNo
        ,MobilePhone
        ,FirstName=(SELECT top 1 STUFF(FirstName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN) 
        ,LastName=(SELECT top 1 STUFF(LastName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN)
        From HNAPPMNT_HEADER
        Where 1=1
            AND CxlReasonCode is NULL
            AND CONVERT(date, AppointDateTime) BETWEEN CONVERT(date,:StartDate) AND CONVERT(date,:EndDate) ";
if (isset($_SESSION['clinic_code'])) {
    $query .= " AND Clinic = :clinic_code ";
} elseif (isset($_SESSION['ClinicGroup'])) {
    $query .= " AND (CASE		
                            WHEN Clinic in ('07031','07032','07038','07039') THEN 'ARI'
                            WHEN Clinic in ('07033') THEN 'Drive-through'
                            WHEN Clinic in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                            WHEN Clinic in ('01001','01003','01005','15006') THEN 'GYN'
                            WHEN Clinic in ('15007','15009') THEN 'เวชปฏิบัติ'
                            WHEN Clinic in ('07043') THEN 'Home Isolation'
                            WHEN Clinic in ('07046') THEN 'Hospitel'
                            WHEN Clinic in ('07047') THEN 'Hotel'
                            WHEN Clinic in ('20000') THEN 'Metro Health'
                            WHEN Clinic in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                            WHEN Clinic in ('01002','01004','01006') THEN 'OBS+ANC'
                            WHEN Clinic in ('13003','15022') THEN 'Observe Room'
                            WHEN Clinic in ('15036') THEN 'ODS SC'
                            WHEN Clinic in ('07044','07045') THEN 'Op Selft'
                            WHEN Clinic in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                            WHEN Clinic in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                            WHEN Clinic in ('07034','07035','07036','07037') THEN 'Screening'
                            WHEN Clinic in ('07040','07041') THEN 'SHA PLUS'
                            WHEN Clinic in ('06001','06002') THEN 'กายภาพบำบัด'
                            WHEN Clinic in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                            WHEN Clinic in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                            WHEN Clinic in ('11002','15005') THEN 'จักษุวิทยา'
                            WHEN Clinic in ('04015','05013','15020') THEN 'จิตเวช'
                            WHEN Clinic in ('15037') THEN 'ฉีดวัคซีน COVID'
                            WHEN Clinic in ('15039') THEN 'ฉีดวัคซีน Moderna'
                            WHEN Clinic in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                            WHEN Clinic in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                            WHEN Clinic in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                            WHEN Clinic in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                            WHEN Clinic in ('07003','07004') THEN 'นิติเวช'
                            WHEN Clinic in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                            WHEN Clinic in ('19001') THEN 'โภชนาการบำบัด'
                            WHEN Clinic in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                            WHEN Clinic in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                            WHEN Clinic in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                            WHEN Clinic in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                            WHEN Clinic in ('13002') THEN 'ห้องคลอด'
                            WHEN Clinic in ('11001','15001') THEN 'หู คอ จมูก'
                            WHEN Clinic in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                            WHEN Clinic in ('14009') THEN 'FUA'
                            WHEN Clinic in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                            ELSE 'no Group'
                        END) = :ClinicGroup ";
}
$query .= " ORDER BY CONVERT(VARCHAR, FORMAT(AppointDateTime, 'yyyy-MM-dd HH:mm'), 120) ASC 
            OFFSET $offset ROWS FETCH NEXT $rowsPerPage ROWS ONLY  ";
try {
    $stmt = $connHos->prepare($query);
    $stmt->bindParam(':StartDate', $_SESSION['startdate']);
    $stmt->bindParam(':EndDate', $_SESSION['enddate']);
    if (isset($_SESSION['clinic_code'])) {
        $stmt->bindParam(':clinic_code', $_SESSION['clinic_code']);
    } elseif (isset($_SESSION['ClinicGroup'])) {
        $stmt->bindParam(':ClinicGroup', $_SESSION['ClinicGroup']);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error stmt->execute(): " . $e->getMessage());
}

if (!isset($_SESSION['dum1'])) {
    $_SESSION['dum1'] = 1;
}

if ($current_page == 1) {
    $_SESSION['dum1'] = 1;
} else {
    $_SESSION['dum1'] = 1 + ($rowsPerPage * ($current_page - 1));
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <title>Home - <?= $hospitalname ?></title>
    <?php include_once '0head.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <!-- <link rel="stylesheet" href="bootstrap-select.min.css"> -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>    
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72">
    <?php include_once '0navbar.php'; ?>
    <section id="portfolio" class="portfolio" style="padding-top: 150px;">
        <div class="container-fluid" style="padding-left: 50px;padding-right: 50px;">
            <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success text-center">
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger text-center">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <h2 class="text-center mb-4">APPOINTMENT</h2>
            <form action="" method="post">
                <nav class="navbar navbar-expand-md border rounded-0 py-3" style="margin-bottom: 10px; background: rgb(143,141,141); color:black">
                    <div class="container">
                        <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2">
                            <span class="visually-hidden">Toggle navigation</span>
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navcol-2">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item" style="margin-right: 5px;padding-top: 5px;padding-bottom: 0px;">
                                    <label class="form-label" style="margin-right: 5px;margin-bottom: 0px;">
                                        เลือก Clinic<br>
                                        <select name="clinic_code" class="selectpicker" data-live-search="true">
                                            <!-- <option value="">เลือก Clinic</option> -->
                                            <option value=""><?= $_SESSION['clinic_code'] . ' ' . $_SESSION['clinic_name'] ?><?php if ($_SESSION['clinic_name'] == '' or $_SESSION['clinic_name'] == null) echo 'เลือก Clinic' ?></option>
                                            <?php foreach ($clinic_rows as $row) {
                                                if ($row['code'] != $_SESSION['clinic_code']) { ?>
                                                    <option value="<?= $row['code'] ?>"><?= $row['code'] . ' ' . $row['LocalName'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="nav-item" style="margin-right: 5px;padding-top: 5px;padding-bottom: 0px;">
                                    <label class="form-label" style="margin-right: 5px;margin-bottom: 0px;">
                                        เลือก ClinicGroup<br>
                                        <select name="ClinicGroup" class="selectpicker" data-live-search="true">
                                            <!-- <option value="">เลือก ClinicGroup</option> -->
                                            <option value=""><?= $_SESSION['ClinicGroup_name'] ?><?php if ($_SESSION['ClinicGroup_name'] == '' or $_SESSION['ClinicGroup_name'] == null) echo 'เลือก ClinicGroup' ?></option>
                                            <?php foreach ($ClinicGroup_rows as $row) {
                                                if ($row['ClinicGroup'] != $_SESSION['ClinicGroup_name']) { ?>
                                                    <option value="<?= $row['ClinicGroup'] ?>"><?= $row['ClinicGroup'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </label>
                                </li>
                                <li class="nav-item" style="margin-right: 5px;padding-top: 5px;padding-bottom: 0px;">
                                    <label class="form-label" style="margin-right: 5px;margin-bottom: 0px;">
                                        วันที่ <input class="form-control" type="date" name="startdate">
                                    </label>
                                    <label class="form-label" style="margin-bottom: 0px;margin-right: 0px;">
                                        ถึงวันที่ <input class="form-control" type="date" name="enddate">
                                    </label>
                                </li>
                            </ul>
                            <button name="submitReset" class="btn btn-warning ms-md-2" style="margin-top: 25px;">ล้าง</button>
                            <button name="submitClinicDate" class="btn btn-primary ms-md-2" type="submit" style="margin-top: 25px;">เลือก</button>
                        </div>
                    </div>
                </nav>
            </form>
            <div class="row">
                <div class="col-12">
                    <div class="row d-flex justify-content-">
                        <div class="col-8">
                            <div class="text-start">
                                <h4>Clinic : <?= $_SESSION['clinic_code'] . ' ' . $_SESSION['clinic_name'] ?></h4>
                                <h4>ClinicGroup : <?= $_SESSION['ClinicGroup_name'] ?></h4>
                                <h4>วันที่ : <?= $_SESSION['startdate'] ?> ถึงวันที่ : <?= $_SESSION['enddate'] ?></h4>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-end">
                                <button onclick="exportToExcel()" type="button" class="btn btn-dark btn-lg" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">export</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="table-responsive"> -->
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th width='3%'>#</th>
                                <th>Appoint</th>
                                <th>Time</th>
                                <th>Phone</th>
                                <th>HN</th>
                                <th>ชื่อคนไข้</th>
                                <th>ชื่อแพทย์</th>
                                <th>Clinic</th>
                                <th>RightCode</th>
                                <th>เหตุผลการนัด</th>
                                <th>Memo</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: start;">
                            <?php if ($totalRows > 0) {
                                $no = 0;
                                foreach ($rows as $row) { ?>
                                    <?php $no++; ?>
                                    <tr>
                                        <td class='text-center'><?= $_SESSION['dum1'] ?></td>
                                        <!-- <td class='text-center'><?= $row['AppointmentNo'] ?></td> -->
                                        <!-- <td class='text-center'><?= $no; ?></td> -->
                                        <td class='text-center'><?= getOnlyDay($row['AppointDateTime']) ?></td>
                                        <td class='text-center'><?= getOnlyTime($row['AppointDateTime']) ?></td>
                                        <td class='text-center'><?= $row['MobilePhone'] ?></td>
                                        <td class='text-center'><?= $row['HN'] ?></td>
                                        <td><?= $row['FirstName'] . ' ' . $row['LastName'] ?></td>
                                        <td>
                                            <?php if ($row['DoctorName'] == null or $row['DoctorName'] == '') {
                                                echo 'ไม่ระบุแพทย์ (' . $row['Doctor'] . ')';
                                            } else {
                                                echo $row['DoctorName'];
                                            } ?>
                                        </td>
                                        <td><?= $row['Clinic'] ?></td>
                                        <!-- <td><?= str_replace(['(SC).', '(SC)', '(CS)', '(WI)'], '', $row['Clinic']) ?></td> -->
                                        <td><?= $row['RightCode'] ?></td>
                                        <td><?= $row['App'] ?></td>
                                        <?php
                                        $QueryCheck = $connlocal->prepare("SELECT COUNT(*) From log Where AppointmentNo = :AppointmentNo");
                                        $QueryCheck->bindParam(':AppointmentNo', $row['AppointmentNo']);
                                        $QueryCheck->execute();
                                        $CheckRows = $QueryCheck->fetchColumn();
                                        ?>
                                        <td class='text-center'>
                                            <?php if ($CheckRows > 0) {
                                                $QueryCheck = $connlocal->prepare("SELECT * From log Where AppointmentNo = :AppointmentNo");
                                                $QueryCheck->bindParam(':AppointmentNo', $row['AppointmentNo']);
                                                $QueryCheck->execute();
                                                $data = $QueryCheck->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                                <!-- <a class="d-block mx-auto portfolio-item" href="#portfolio-modal-1" data-bs-toggle="modal" style="margin-bottom: 0px;">
                                                    <button class="btn btn-success" type="button">อ่าน</button>
                                                </a> -->
                                                <?= $data['Memo']; ?>
                                            <?php } else { ?>
                                                <a class="d-block mx-auto portfolio-item" href="#portfolio-modal-<?= $no; ?>" data-bs-toggle="modal" style="margin-bottom: 0px;">
                                                    <button class="btn btn-danger btn-sm" type="button">บันทึก</button>
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <div class="modal text-center" role="dialog" tabindex="-1" id="portfolio-modal-<?= $no; ?>">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <!-- <form action="script/insertMemo.php" method="post"> -->
                                            <form action="" method="post">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="container text-start">
                                                            <div class="row">
                                                                <div class="col-lg-8 mx-auto">
                                                                    <h3 class="text-uppercase text-secondary text-center mb-4">Remark Memo</h3>
                                                                    <p class="mb-2">AppointmentNo : <?= ' ' . $row['AppointmentNo']; ?></p>
                                                                    <p class="mb-2">AppointDateTime : <?= ' ' . $row['AppointDateTime']; ?></p>
                                                                    <p class="mb-2">HN : <?= ' ' . $row['HN']; ?></p>
                                                                    <p class="mb-2">Doctor : <?= ' ' . $row['DoctorName']; ?></p>
                                                                    <p class="mb-2">Clinic : <?= ' ' . $row['Clinic']; ?></p>
                                                                    <p class="mb-2">RightCode : <?= ' ' . $row['RightCode']; ?></p>
                                                                    <p class="mb-2">App : <?= ' ' . $row['App']; ?></p>
                                                                    <input hidden name="AppointmentNo" class="form-control" type="text" value="<?= $row['AppointmentNo']; ?>">
                                                                    <input hidden name="AppointDate" class="form-control" type="text" value="<?= getOnlyDay($row['AppointDateTime']); ?>">
                                                                    <input hidden name="day" class="form-control" type="text" value="<?= date('Y-m-d') ?>">
                                                                    <input hidden name="time" class="form-control" type="text" value="<?= date('H:i:s') ?>">
                                                                    <label class="form-label">Memo</label>
                                                                    <textarea <?php if ($CheckRows > 0) {
                                                                                    echo 'readonly';
                                                                                } else {
                                                                                    echo 'required';
                                                                                } ?> name="Memo" class="form-control" rows="3"><?php if ($CheckRows > 0) {
                                                                                                                                    echo $data['Memo'];
                                                                                                                                } ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer pb-5">
                                                        <a class="btn btn-danger btn-lg mx-auto rounded-pill portfolio-modal-dismiss" role="button" data-bs-dismiss="modal">
                                                            <i class="fa fa-close"></i>&nbsp;ยกเลิก
                                                        </a>
                                                        <?php if ($CheckRows < 1) { ?>
                                                            <button name="submitMemo" type="submit" class="btn btn-success btn-lg mx-auto rounded-pill portfolio-modal-dismiss">
                                                                <i class="fa fa-check"></i>&nbsp;บันทึก
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php $_SESSION['dum1']++;
                                }
                            } else { ?>
                                <tr>
                                    <td colspan='9' class='text-center'>no data!!</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <!-- </div> -->
                    <?php if ($totalRows > 0) { ?>
                        <div class="pagination">
                            <?php
                            if ($totalPages > 1) {
                                if ($current_page > 1) {
                                    echo "<a href='index.php?page=1'>Home</a>";
                                    echo "<a href='index.php?page=" . ($current_page - 1) . "'>Previous</a>";
                                }

                                for ($i = $start_page; $i <= $end_page; $i++) {
                                    echo "<a href='index.php?page=$i'";
                                    if ($i == $current_page) {
                                        echo " class='active'";
                                    }
                                    echo ">$i</a>";
                                }

                                if ($current_page < $totalPages) {
                                    echo "<a href='index.php?page=" . ($current_page + 1) . "'>Next</a>";
                                    echo "<a href='index.php?page=$totalPages'>Last Page</a>";
                                }
                            }
                            ?>
                        </div>
                        <div class="info-message">
                            <?php echo "Total Records: $totalRows, Total Pages: $totalPages"; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    $queryhiden = "SELECT 
                    AppointmentNo
                    ,HN
                    ,Doctor
                    ,DoctorName = (SELECT CASE WHEN NationalityCode = '00' THEN (SELECT STUFF(LocalName, 1, 1, '') FROM HNDOCTOR_MASTER WHERE HNAPPMNT_HEADER.Doctor = HNDOCTOR_MASTER.Doctor) else (SELECT STUFF(EnglishName, 1, 1, '') FROM HNDOCTOR_MASTER WHERE HNAPPMNT_HEADER.Doctor = HNDOCTOR_MASTER.Doctor) end From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)
                    --,DoctorName=(select top 1  substring(isnull(localname,englishname),2,100) From DNHOSPITAL.dbo.DNSYSCONFIG as TBCFG where TBCFG.CtrlCode='10031' and TBCFG.code=Doctor)
                    
					--,Clinic_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic)
                    ,Clinic as Clinic_Code
					,Clinic = (SELECT CASE WHEN NationalityCode = '00' THEN	(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic) else (SELECT STUFF(EnglishName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic) end From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)
					--,Clinic=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42203' AND Code = Clinic)
                    
					--,Right_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42086' AND Code = RightCode)
                    ,RightCode as Right_Code
					,RightCode=(SELECT STUFF(LocalName, 1, 1, '') FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42086' AND Code = RightCode)
                    					
					--,App_Code=(SELECT Code FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42211' AND Code = AppmntProcedureCode1)
                    ,AppmntProcedureCode1 
					,App=(SELECT STUFF(LocalName, 1, 1, '')  FROM dbo.DNSYSCONFIG WHERE CtrlCode = '42211' AND Code = AppmntProcedureCode1)
                    
					,CONVERT(VARCHAR, FORMAT(AppointDateTime, 'yyyy-MM-dd HH:mm'), 120) as AppointDateTime
                    ,TelephoneNo
                    ,MobilePhone
                    ,FirstName=(SELECT top 1 STUFF(FirstName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN) 
                    ,LastName=(SELECT top 1 STUFF(LastName, 1, 1, '') From HNPAT_NAME WHERE HNPAT_NAME.HN = HNAPPMNT_HEADER.HN)
                    --,Nation = (SELECT NationalityCode From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)			
                    ,NationCASE = (SELECT CASE WHEN NationalityCode = '00' THEN 'th' else 'eng' end From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)
                    --,Gender = (SELECT Gender From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)
                    ,InitialName = (SELECT CASE WHEN NationalityCode = '00' THEN (InitialName) else (CASE WHEN Gender = '1' THEN 'Ms.' else 'Mr.' end) end From HNName WHERE HNName.HN = HNAPPMNT_HEADER.HN)
                From HNAPPMNT_HEADER
                Where 1=1
                    AND CxlReasonCode is NULL
                    AND CONVERT(date, AppointDateTime) BETWEEN CONVERT(date,:StartDate) AND CONVERT(date,:EndDate) ";
    if (isset($_SESSION['clinic_code'])) {
        $queryhiden .= " AND Clinic = :clinic_code ";
    } elseif ((isset($_SESSION['ClinicGroup']))) {
        $queryhiden .= " AND (CASE		
                            WHEN Clinic in ('07031','07032','07038','07039') THEN 'ARI'
                            WHEN Clinic in ('07033') THEN 'Drive-through'
                            WHEN Clinic in ('07002','07005','07006','07007','07008','07009','07010','07012','07013','07014','07015','07016','07017','07018','07019','07020','07021','07022','07023','07024','07025','07026','07028','07030') THEN 'ER'
                            WHEN Clinic in ('01001','01003','01005','15006') THEN 'GYN'
                            WHEN Clinic in ('15007','15009') THEN 'เวชปฏิบัติ'
                            WHEN Clinic in ('07043') THEN 'Home Isolation'
                            WHEN Clinic in ('07046') THEN 'Hospitel'
                            WHEN Clinic in ('07047') THEN 'Hotel'
                            WHEN Clinic in ('20000') THEN 'Metro Health'
                            WHEN Clinic in ('08001','08002','08003','08004','08005','08006','08007','08008','08009','08010','08011','08012','08013','08014') THEN 'Night Time OPD'
                            WHEN Clinic in ('01002','01004','01006') THEN 'OBS+ANC'
                            WHEN Clinic in ('13003','15022') THEN 'Observe Room'
                            WHEN Clinic in ('15036') THEN 'ODS SC'
                            WHEN Clinic in ('07044','07045') THEN 'Op Selft'
                            WHEN Clinic in ('13004','13005','13006','150043','999910','999911','99994','99995','99996','99997','99998','99999') THEN 'Other'
                            WHEN Clinic in ('14001','14002','14003','14004','14005','14006','14007','14008') THEN 'PP non UC'
                            WHEN Clinic in ('07034','07035','07036','07037') THEN 'Screening'
                            WHEN Clinic in ('07040','07041') THEN 'SHA PLUS'
                            WHEN Clinic in ('06001','06002') THEN 'กายภาพบำบัด'
                            WHEN Clinic in ('04001','04002','04003','04004','04005','04006','04007','04008','04009','04010','04011','04012','04013','04014','04016') THEN 'กุมารเวชกรรม'
                            WHEN Clinic in ('09003') THEN 'คลินิคสุขภาพดีที่บ้าน'
                            WHEN Clinic in ('11002','15005') THEN 'จักษุวิทยา'
                            WHEN Clinic in ('04015','05013','15020') THEN 'จิตเวช'
                            WHEN Clinic in ('15037') THEN 'ฉีดวัคซีน COVID'
                            WHEN Clinic in ('15039') THEN 'ฉีดวัคซีน Moderna'
                            WHEN Clinic in ('09002') THEN 'ตรวจสุขภาพนอกสถานที่'
                            WHEN Clinic in ('12001','12002','12003','12004') THEN 'ไตเทียม'
                            WHEN Clinic in ('10001','10002','10003','10004','10005','10006','10007','10008','10009','10010') THEN 'ทันตกรรม'
                            WHEN Clinic in ('02013','07027','07029','15002','07027') THEN 'ทำแผล'
                            WHEN Clinic in ('07003','07004') THEN 'นิติเวช'
                            WHEN Clinic in ('150042') THEN 'ประกันสังคมฉีดวัคซีน'
                            WHEN Clinic in ('19001') THEN 'โภชนาการบำบัด'
                            WHEN Clinic in ('02001','02003','02004','02005','02006','02007','02008','02009','02010','02011','02012','02014','15024','15026','15027','15028','15029','15030','15031','15032','15033','15034','15035','02015','02015') THEN 'ศัลยกรรม'
                            WHEN Clinic in ('03001','03002','03003','03004','15023') THEN 'ศัลยกรรมกระดูก'
                            WHEN Clinic in ('09001','15003','15004','150041') THEN 'ศูนย์ตรวจสุขภาพ'
                            WHEN Clinic in ('03005','18001','18002','18003','18004','18005','18006','18007','18008','18009') THEN 'ศูนย์เบาหวาน'
                            WHEN Clinic in ('13002') THEN 'ห้องคลอด'
                            WHEN Clinic in ('11001','15001') THEN 'หู คอ จมูก'
                            WHEN Clinic in ('05001','05002','05003','05004','05005','05006','05007','05008','05009','05010','05011','05012','13001','15008','15010','15011','15012','15013','15014','15015','15016','15017','15018','15019','15021','15038') THEN 'อายุรกรรม'
                            WHEN Clinic in ('14009') THEN 'FUA'
                            WHEN Clinic in ('02002','15025') THEN 'ศัลยกรรมประสาทและสมอง'
                            ELSE 'no Group'
                        END) = :ClinicGroup ";
    }
    $queryhiden .= " ORDER BY CONVERT(VARCHAR, FORMAT(AppointDateTime, 'yyyy-MM-dd HH:mm'), 120) ASC";
    try {
        $stmthiden = $connHos->prepare($queryhiden);
        $stmthiden->bindParam(':StartDate', $_SESSION['startdate']);
        $stmthiden->bindParam(':EndDate', $_SESSION['enddate']);
        if (isset($_SESSION['clinic_code'])) {
            $stmthiden->bindParam(':clinic_code', $_SESSION['clinic_code']);
        } elseif ((isset($_SESSION['ClinicGroup']))) {
            $stmthiden->bindParam(':ClinicGroup', $_SESSION['ClinicGroup']);
        }
        $stmthiden->execute();
        $hidenrows = $stmthiden->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error stmthiden " . $e->getMessage());
    }
    ?>
    <table hidden class="table table-striped table-hover table-bordered" id="report_Appointment">
        <thead>
            <tr style="text-align: center;">
                <th>เบอร์</th>
                <th>ข้อความ</th>
            </tr>
        </thead>
        <tbody style="text-align: start;">
            <?php if ($hidenrows) {
                foreach ($hidenrows as $row) {
                    $query_keyworld = " SELECT 
                                            Code
                                            ,EnglishName
                                            ,ThaiName
                                        FROM keyworld
                                        where Code=:Code";
                    try {
                        $stmtkeyworld = $connlocal->prepare($query_keyworld);
                        $stmtkeyworld->bindParam(':Code', $_SESSION['clinic_code']);
                        $stmtkeyworld->execute();
                        $keyworld = $stmtkeyworld->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        die("Error stmtkeyworld " . $e->getMessage());
                    } ?>
                    <tr>
                        <td><?= $row['MobilePhone']; ?></td>
                        <!-- <td>คุณ <?= $row['FirstName'] . ' ' . $row['LastName'] ?> มีนัดพบ <?= $row['DoctorName'] ?> แผนก <?= $row['Clinic'] ?> วันที่ <?= getOnlyDay($row['AppointDateTime']) ?> เวลา <?= getOnlyTime($row['AppointDateTime']) ?> น.</td> -->
                        <?php if ($row['NationCASE'] == 'th') { ?>
                            <td><?= $row['InitialName'] ?> <?= $row['FirstName'] . ' ' . $row['LastName'] ?> มีนัด<?php if ($keyworld != null) {
                                                                                                                        echo $keyworld['ThaiName'];
                                                                                                                    } else { ?>พบ <?= $row['DoctorName'] ?><?php } ?> แผนก <?= str_replace(['(SC).', '(SC)', '(CS)', '(WI)'], '', $row['Clinic']) ?> โรงพยาบาลเกษมราษฎร์ รามคำแหง วันที่ <?= convertToThaiDate(getOnlyDay($row['AppointDateTime'])) ?> เวลา <?= getOnlyTime($row['AppointDateTime']) ?> น.</td>
                        <?php } else { ?>
                            <td><?= $row['InitialName'] ?> <?= $row['FirstName'] . ' ' . $row['LastName'] ?> has an appointment <?php if ($keyworld != null) {
                                                                                                                                    echo $keyworld['EnglishName'];
                                                                                                                                } else { ?>with Dr.<?= $row['DoctorName'] ?><?php } ?> at the <?= str_replace(['(SC).', '(SC)', '(CS)', '(WI)'], '', $row['Clinic']) ?> Department, Kasemrad Hospital Ramkhamhaeng, on <?= convertToEngDate(getOnlyDay($row['AppointDateTime'])) ?>,at <?= getFormattedTime($row['AppointDateTime']) ?>.</td>
                        <?php } ?>
                    </tr>
                    <?php $keyworld = null ?>
                <?php }
            } else { ?>
                <tr>
                    <td colspan='3' class='text-center'>no data!!</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


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