<?php 
require "php/db_conn.php";

$xValues = [
    "city" => [],
    "type" => [],
    "interest" => []
];
$yValues = [
    "city" => [],
    "type" => [],
    "interest" => []
];

try {
    // Városok (city) lekérdezése
    $stmt = $conn->prepare("
        SELECT filter_value, COUNT(*) AS count 
        FROM filter_search_statistics 
        WHERE filter_name = 'city' 
        GROUP BY filter_value
    ");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $xValues["city"][] = $row['filter_value'];
        $yValues["city"][] = (int)$row['count'];  // Átváltás szám típusra
    }

    // Típusok (type) lekérdezése
    $stmt = $conn->prepare("
        SELECT filter_value, COUNT(*) AS count 
        FROM filter_search_statistics 
        WHERE filter_name = 'type' 
        GROUP BY filter_value
    ");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $xValues["type"][] = $row['filter_value'];
        $yValues["type"][] = (int)$row['count']; 
    }

    // Érdeklődés (interest) lekérdezése
    $stmt = $conn->prepare("
        SELECT filter_value, COUNT(*) AS count 
        FROM filter_search_statistics 
        WHERE filter_name = 'interest' 
        GROUP BY filter_value
    ");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $xValues["interest"][] = $row['filter_value'];
        $yValues["interest"][] = (int)$row['count'];  
    }
} catch (PDOException $e) {
    echo "Hiba: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EcoTrips</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card { 
            width:900px;
            height:526px;
        }   
    </style>
</head>

<body id="page-top">

<?php include 'nav.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">


                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Aktív felhasználók száma</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php 
                                                $stmt = $conn->prepare("SELECT COUNT(*) AS active_users FROM users WHERE is_active = 1");
                                                $stmt->execute();         
                                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                echo $row['active_users'];
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->

                    <div class="row">

                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Keresési statisztikai táblázat(Város alapján)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                    <canvas id="myChart0" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Keresési statisztikai táblázat(Típus alapján)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                    <canvas id="myChart1" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Keresési statisztikai táblázat(Érdeklődés alapján)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                    <canvas id="myChart2" style="width:100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
    // PHP adatok betöltése JavaScript-be
    var xValues0 = <?php echo json_encode($xValues["city"]); ?>;
    var yValues0 = <?php echo json_encode($yValues["city"]); ?>;

    var xValues1 = <?php echo json_encode($xValues["type"]); ?>;
    var yValues1 = <?php echo json_encode($yValues["type"]); ?>;

    var xValues2 = <?php echo json_encode($xValues["interest"]); ?>;
    var yValues2 = <?php echo json_encode($yValues["interest"]); ?>;

    var barColor = "#b58458"; // Az egységes szín beállítása
    var barColors0 = Array(xValues0.length).fill(barColor);
    var barColors1 = Array(xValues1.length).fill(barColor);
    var barColors2 = Array(xValues2.length).fill(barColor);

    // Város diagram
    new Chart("myChart0", {
        type: "bar",
        data: {
            labels: xValues0,
            datasets: [{
                backgroundColor: barColors0,
                data: yValues0
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Keresési statisztikák (Város alapján)"
            }
        }
    });

    // Típus diagram
    new Chart("myChart1", {
        type: "bar",
        data: {
            labels: xValues1,
            datasets: [{
                backgroundColor: barColors1,
                data: yValues1
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Keresési statisztikák (Típus alapján)"
            }
        }
    });

    // Érdeklődés diagram
    new Chart("myChart2", {
        type: "bar",
        data: {
            labels: xValues2,
            datasets: [{
                backgroundColor: barColors2,
                data: yValues2
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Keresési statisztikák (Érdeklődés alapján)"
            }
        }
    });
</script>

</script>

</body>
</html>