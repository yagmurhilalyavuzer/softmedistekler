<?php 
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
include("session.php");
include("config.php");
$db=getDB();



header('Content-Type: text/html; charset=utf-8');


if ($_SESSION['UserCode']) {
    $userCode = $_SESSION['UserCode'];

    $stmt = $db->prepare("SELECT ADMIN FROM usermaster WHERE USERCODE = ?");
    $stmt->execute([$userCode]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);  

    if ($user && $user['ADMIN'] == 1) {
        // ADMIN: Tüm kayıtlar, yeniden eskiye
        $istekSorgu = $db->query("SELECT * FROM istekler_master ORDER BY ID DESC");
        $istekler = $istekSorgu->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Normal kullanıcı: Sadece kendi kayıtları, yeniden eskiye
        $istekSorgu = $db->prepare("SELECT * FROM istekler_master WHERE USERCODE = ? ORDER BY ID DESC");
        $istekSorgu->execute([$userCode]);
        $istekler = $istekSorgu->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="theme_ocean">
    <!--! The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags !-->
    <!--! BEGIN: Apps Title-->
    <title>Duralux || Customers</title>
    <!--! END:  Apps Title-->
    <!--! BEGIN: Favicon-->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
    <!--! END: Favicon-->
    <!--! BEGIN: Bootstrap CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!--! END: Bootstrap CSS-->
    <!--! BEGIN: Vendors CSS-->
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/dataTables.bs5.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/vendors/css/select2-theme.min.css">
    <!--! END: Vendors CSS-->
    <!--! BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/theme.min.css">
    <!--! END: Custom CSS-->
    <!--! HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries !-->
    <!--! WARNING: Respond.js doesn"t work if you view the page via file: !-->
    <!--[if lt IE 9]>
			<script src="https:oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https:oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
</head>

<body>
    <!--! ================================================================ !-->
    <!--! [Start] Navigation Manu !-->
    <!--! ================================================================ !-->
    <?php include("sidebar.php"); ?>
    <!--! ================================================================ !-->
    <!--! [End]  Navigation Manu !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! [Start] Header !-->
    <!--! ================================================================ !-->
    <?php include("header.php"); ?>
            <!-- [ page-header ] end -->
            <!-- [ Main Content ] start -->
            <div class="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card stretch stretch-full">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="customerList">
                                        <thead>
                                            <tr>
                                                <th style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Tarih</th>
                                                <th style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Başlık</th>
                                                <th>Aciliyet</th>
                                                <th>İşlemler</th>                                           
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($istekler as $istek): ?>
                                            <tr class="single-item">
                                                <td> <?= $istek['TARIH'] ?> </td>
                                                <td> <?= KarakterDuzelt($istek['BASLIK']) ?> </td>
                                                <td> <?= $istek['ACILIYET'] ?> </td>
                                                <td>
                                                <a href="istek_ekle.php?id=<?= $row['ID'] ?>" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> Düzenle
                                                </a>
                                                </td>
                                            </tr>    
                                            <?php endforeach; ?>    
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Main Content ] end -->
        </div>
        <!-- [ Footer ] start -->
        <footer class="footer">
            <p class="fs-11 text-muted fw-medium text-uppercase mb-0 copyright">
                <span>Copyright ©</span>
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </p>
            <div class="d-flex align-items-center gap-4">
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Help</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Terms</a>
                <a href="javascript:void(0);" class="fs-11 fw-semibold text-uppercase">Privacy</a>
            </div>
        </footer>
        <!-- [ Footer ] end -->
    </main>
    <!--! ================================================================ !-->
    <!--! [End] Main Content !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! ================================================================ !-->
    <!--! Footer Script !-->
    <!--! ================================================================ !-->
    <!--! BEGIN: Vendors JS !-->
    <script src="assets/vendors/js/vendors.min.js"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="assets/vendors/js/dataTables.min.js"></script>
    <script src="assets/vendors/js/dataTables.bs5.min.js"></script>
    <script src="assets/vendors/js/select2.min.js"></script>
    <script src="assets/vendors/js/select2-active.min.js"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="assets/js/common-init.min.js"></script>
    <script src="assets/js/customers-init.min.js"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="assets/js/theme-customizer-init.min.js"></script>

    <script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#paymentList')) {
            $('#paymentList').DataTable().destroy();
        }
        
        $('#paymentList').DataTable({
            responsive: false,   
            scrollX: false,       
            autoWidth: false,     
            pageLength: 10,
            order: [[2, "desc"]],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/tr.json"
            }
        });
    });
    </script>  

    <script>
            $('#monitorTable').DataTable({
            order: [] // Varsayılan sıralamayı kapatır, ama kullanıcı elle sıralayabilir
            });
    </script>  
</body>

</html>
