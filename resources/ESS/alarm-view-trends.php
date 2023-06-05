<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
parse_str($_SERVER['QUERY_STRING'], $query);
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
isAdmin('/resources/ESS/alarm-report.php');
$unitName = $_SESSION['unitName'];
$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);


//permissionsToEdit('ESS', $findUser->lastName, $findUser->dodId, $findUser->unitName, '/resources/ESS/alarm-report.php');



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $siteTitle; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">
  <?php


  /*
  [0] => 47 [total] => 47
  [1] => 6621 [accountName] => 6621
  [2] => NOA [buildingNumber] => NOA
  [3] => 43 [roomNumber] => 43
  [4] => Exterior [alarmLocationType] => Exterior
  [5] => 43 [fossZone] => 43

  { label: "New Jersey", y: 210.5 },

  */



  $findESSExt = $mysqli->query("SELECT accountName, count(*) AS total FROM alarmData where reportedTime > '2021-01-01' and alarmLocationType = 'Exterior' GROUP BY accountName ORDER BY total Desc");

  $findESSInt = $mysqli->query("SELECT accountName, count(*) AS total FROM alarmData where reportedTime > '2021-01-01' and alarmLocationType = 'Interior' GROUP BY accountName ORDER BY total Desc");







      ob_start();
      include('alarm-find-trends.php');
      ob_end_clean();

  ?>




  <script>


  window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
      exportEnabled: true,
      animationEnabled: true,
      title:{
        text: "Alarm Data highest recorded"
      },
      subtitles: [{
        text: "Click Legend to Hide or Unhide Data Series"
      }],
      axisX: {
        title: "Account Name"
      },
      axisY: {
        title: "Exeritor - Count",
        titleFontColor: "#4F81BC",
        lineColor: "#4F81BC",
        labelFontColor: "#4F81BC",
        tickColor: "#4F81BC",
        includeZero: true
      },
      axisY2: {
        title: "Interior - Count",
        titleFontColor: "#C0504E",
        lineColor: "#C0504E",
        labelFontColor: "#C0504E",
        tickColor: "#C0504E",
        includeZero: true
      },
      toolTip: {
        shared: true
      },
      legend: {
        cursor: "pointer",
        itemclick: toggleDataSeries
      },
      data: [{
        type: "column",
        name: "Exterior",
        showInLegend: true,
        yValueFormatString: "#,##0.# Units",
        //foreach ($findESS->fetch_assoc() as $key => $value) { echo '{ label: "'.$value.'", "y" => '.$key.'}'; }
        dataPoints: [

          <?php
          /* fetch associative array */
          while ($row =$findESSExt->fetch_assoc()) {
            //printf ("%s (%s)\n", $row['accountName'], $row['total']);
            echo '{ label: "'.$row['accountName'].'",  y: '.$row['total'].' },';

          }

          ?>


        ]
      },
      {
        type: "column",
        name: "Interior",
        axisYType: "secondary",
        showInLegend: true,
        yValueFormatString: "#,##0.# Units",
        dataPoints: [
          <?php
          /* fetch associative array */
          while ($row =$findESSInt->fetch_assoc()) {
            //printf ("%s (%s)\n", $row['accountName'], $row['total']);
            echo '{ label: "'.$row['accountName'].'",  y: '.$row['total'].' },';

          }

          ?>

        ]
      }]
    });
    chart.render();

    function toggleDataSeries(e) {
      if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
      } else {
        e.dataSeries.visible = true;
      }
      e.chart.render();
    }

  }
  </script>
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!--Nav bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>

    <!-- Main Sidebar Container -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Alarm Administration</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Alarm Administration
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <!--<div class="card-header">
                  <h3 class="card-title">Alarm Data Tables</h3>
                </div>-->
                <!-- /.card-header -->
                <div class="card-body">
                  <?php require "alarm-find-trends.php";?>
                </div>
                <!-- /.card-body -->

                <div class="col-lg-12">
                  <div class="card card-info">
                    <div class="card-header">
                      <h5 class="m-0">Most recent alarms 24 hrs</h5>
                    </div>
                    <div class="card-body">
                      <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                      <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                    </div>
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </section>
          <!-- /.content -->


        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
          <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
      </div>
      <!-- ./wrapper -->

      <!-- jQuery -->
      <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
      <!-- Bootstrap 4 -->
      <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- DataTables  & Plugins -->
      <script src="../../AdminLTE-master/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
      <script src="../../AdminLTE-master/plugins/jszip/jszip.min.js"></script>
      <script src="../../AdminLTE-master/plugins/pdfmake/pdfmake.min.js"></script>
      <script src="../../AdminLTE-master/plugins/pdfmake/vfs_fonts.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.print.min.js"></script>
      <script src="../../AdminLTE-master/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
      <!-- AdminLTE App -->
      <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
      <!-- AdminLTE for demo purposes -->
      <script src="../../AdminLTE-master/dist/js/demo.js"></script>
      <!-- Page specific script -->
      <script>
      $(function () {
        $("#example1").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#sectionSponsor').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
        $('#sectionGTC').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
        $('#sectionDecs').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
        $('#sectionEPRs').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
          "responsive": true,
        });
      });
      </script>
    </body>
 
    </html>
