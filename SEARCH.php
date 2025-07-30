<?php
include_once '0top.php';
$_SESSION['Page_Active'] = 'SEARCH.php';


if (($_SESSION['startdate'] == '') or ($_SESSION['startdate'] == null)) {
    $_SESSION['startdate'] = date('Y-m-d');
}
if (($_SESSION['enddate'] == '') or ($_SESSION['enddate'] == null)) {
    $_SESSION['enddate'] = date('Y-m-d');
}

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <title>SEARCH - <?= $hospitalname ?></title>
    <?php include_once '0head.php'; ?>
</head>

<body id="page-top" data-bs-spy="scroll" data-bs-target="#mainNav" data-bs-offset="72">
    <?php include_once '0navbar.php'; ?>
    <section id="portfolio" class="portfolio" style="padding-top: 150px;">
        <div class="container" style="padding-left: 0px;padding-right: 0px;">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <h2 class="text-center mb-4">SEARCH</h2>
                    <form action="" method="post">
                        <div class='text-center'>
                            <label class="form-label text-start" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ค้นหาด้วย HN
                                <input name="" class="form-control" type="text" placeholder="HN"/>
                            </label>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ค้นหาด้วย ชื่อ-นามสกุล ผู้ป่วย
                                <input name="" class="form-control" type="text" placeholder="ผู้ป่วย" />
                            </label>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ค้นหาด้วย Clinic
                                <input name="" class="form-control" type="text" placeholder="Clinic" />
                            </label>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ค้นหาด้วย ว.แพทย์
                                <input name="" class="form-control" type="text" placeholder="ว.แพทย์" />
                            </label>
                            <label class="form-label" style="margin-top: 10px;margin-left: 10px;margin-right: 10px;margin-bottom: 10px;">ค้นหาด้วย ชื่อ-นามสกุล แพทย์
                                <input name="" class="form-control" type="text" placeholder="แพทย์" />
                            </label>
                            <button name="submit" class="btn btn-primary ms-md-2" type="submit">ค้นหา</button>
                        </div>
                    </form>
                </div>
                <div class="col-12">                  
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th width='3%'>#</th>
                                <th width='8%'>Appoint</th>
                                <th width='5%'>Time</th>
                                <th width='8%'>HN</th>
                                <th width='17%'>ชื่อแพทย์</th>
                                <th width='18%'>Clinic</th>
                                <th width='12%'>RightCode</th>
                                <th width='21%'>App</th>
                                <th width='8%'>Action</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: start;">

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
</body>

</html>