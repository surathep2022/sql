<?php
date_default_timezone_set("Asia/Bangkok");
//ส่งกลับ วัน เดือน ปี
function convertToThaiDate($date)
{
    // Set the Thai months and days arrays
    $thaiMonths = array(
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );

    $thaiDays = array(
        'อาทิตย์',
        'จันทร์',
        'อังคาร',
        'พุธ',
        'พฤหัสบดี',
        'ศุกร์',
        'เสาร์'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $thaiMonth = $thaiMonths[$dateTime->format('n') - 1];
    $thaiDay = $thaiDays[$dateTime->format('w')];

    // Build the Thai date string
    $thaiDate = $dateTime->format('d') . ' ' . $thaiMonth . ' ' . ($dateTime->format('Y') + 543);
    return $thaiDate;
}
//ส่งกลับ วัน เดือน ปี วันชื่อเต็ม
function convertToThaiDate2($date)
{
    // Set the Thai months and days arrays
    $thaiMonths = array(
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );

    $thaiDays = array(
        'อาทิตย์',
        'จันทร์',
        'อังคาร',
        'พุธ',
        'พฤหัสบดี',
        'ศุกร์',
        'เสาร์'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $thaiMonth = $thaiMonths[$dateTime->format('n') - 1];
    $thaiDay = $thaiDays[$dateTime->format('w')];

    // Build the Thai date string
    $thaiDate = $dateTime->format('d') . ' ' . $thaiMonth . ' ' . ($dateTime->format('Y') + 543) . ', ' . $thaiDay;
    return $thaiDate;
}
//ส่งกลับแค่ ปี
function convertToThaiDate3($date)
{
    // Set the Thai months and days arrays
    $thaiMonths = array(
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );

    $thaiDays = array(
        'อาทิตย์',
        'จันทร์',
        'อังคาร',
        'พุธ',
        'พฤหัสบดี',
        'ศุกร์',
        'เสาร์'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $thaiMonth = $thaiMonths[$dateTime->format('n') - 1];
    $thaiDay = $thaiDays[$dateTime->format('w')];

    // Build the Thai date string
    $thaiDate = $dateTime->format('Y') + 543;
    return $thaiDate;
}
//ส่งกลับ เดือน ปี
function convertToThaiDate4($date)
{
    // Set the Thai months and days arrays
    $thaiMonths = array(
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );

    $thaiDays = array(
        'อาทิตย์',
        'จันทร์',
        'อังคาร',
        'พุธ',
        'พฤหัสบดี',
        'ศุกร์',
        'เสาร์'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $thaiMonth = $thaiMonths[$dateTime->format('n') - 1];
    $thaiDay = $thaiDays[$dateTime->format('w')];

    // Build the Thai date string
    $thaiDate = $thaiMonth . ' ' . ($dateTime->format('Y') + 543);
    return $thaiDate;
}
//ส่งกลับแค่ เดือน 
function convertToThaiDate5($date)
{
    // Set the Thai months and days arrays
    $thaiMonths = array(
        'มกราคม',
        'กุมภาพันธ์',
        'มีนาคม',
        'เมษายน',
        'พฤษภาคม',
        'มิถุนายน',
        'กรกฎาคม',
        'สิงหาคม',
        'กันยายน',
        'ตุลาคม',
        'พฤศจิกายน',
        'ธันวาคม'
    );

    $thaiDays = array(
        'อาทิตย์',
        'จันทร์',
        'อังคาร',
        'พุธ',
        'พฤหัสบดี',
        'ศุกร์',
        'เสาร์'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $thaiMonth = $thaiMonths[$dateTime->format('n') - 1];
    $thaiDay = $thaiDays[$dateTime->format('w')];

    // Build the Thai date string
    $thaiDate = $thaiMonth;
    return $thaiDate;
}

function convertToEngDate($date)
{
    // Set the Thai months and days arrays
    $EngMonths = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );

    $EngDays = array(
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday'
    );

    // Convert the input date to a DateTime object
    $dateTime = new DateTime($date);

    // Get the Thai month and day
    $EngMonths = $EngMonths[$dateTime->format('n') - 1];
    $EngDays = $EngDays[$dateTime->format('w')];

    // Build the Thai date string
    // $EngDate = $dateTime->format('d') . ' ' . $EngMonths . ' ' . ($dateTime->format('Y'));
    $EngDate = $EngMonths .' '.$dateTime->format('d') . ',' . ($dateTime->format('Y'));
    return $EngDate;
}
?>