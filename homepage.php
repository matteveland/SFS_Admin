<?php
/*if (!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))) {
  //Does not exist. Redirect user back to page-one.php
  header("refresh:0; url='./../../resources/Admin/Login-Logout/login.php'");

  exit;
}*/
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
include $_SERVER['DOCUMENT_ROOT'].'/resources/ESS/trends-homepage.php';
include('/Users/matteveland/code/data.env');
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/classes/findUser.class.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/functions/functions.php';
parse_str($_SERVER['QUERY_STRING'], $query);

$unitName = $_SESSION['unitName'];

//find User from class. this will be used throughout site to find user
//$findUser = new FindUser();
//$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);



//find User from class. this will be used throughout site to find user
//$findUser = new FindUser();
//$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

/*
$findMember = $mysqli->query("SELECT * From login l inner JOIN members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name");

while ($row = $findMember->fetch_assoc()) {

    $userID = $row['user_name'];
    //$last = $row['lastName'];
    $first = $row['firstName'];
    $middle = $row['middleName'];
    $admin = $row['admin'];
    $unitName = $row['unitName'];
    $img = $row['image'];
    $imgDetail = $row['imageDetail'];

}
*/
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SFS Admin | Homepage</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-sm-6">
            <!--<h1 class="m-0">Starter Page</h1>-->
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
      <section class="content">
          <div class="container-fluid">
              <div class="col-sm-6">
                  <h3 class="m-0">Nuisance Alarms</h3>
              </div><!-- /.col -->

              <!-- Small boxes (Stat box) -->

              <div class="row">

                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-info">
                          <div class="inner">
                              <h3><?php echo $Nuisance_daily; ?></h3>

                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                          <p class="small-box-footer">Daily</p>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-success">
                          <div class="inner">
                              <h3><?php echo $Nuisance_weekly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                          </div>
                          <a href="#" class="small-box-footer">Weekly</a>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-info">
                          <div class="inner">
                              <h3><?php echo $Nuisance_monthly; ?></h3>

                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                          <p class="small-box-footer">Monthly</p>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                          <div class="inner">
                              <h3><?php echo $Nuisance_quarterly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-person-add"></i>
                          </div>
                          <a href="#" class="small-box-footer">Quarterly</i></a>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                          <div class="inner">
                              <h3><?php echo $Nuisance_yearly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-pie-graph"></i>
                          </div>
                          <a href="#" class="small-box-footer">Yearly</a>
                      </div>
                  </div>
                  <!-- ./col -->
              </div>





              <!------------------->

              <div class="col-sm-6">
                  <h3 class="m-0">False Alarms</h3>
              </div><!-- /.col -->
              <!-- Small boxes (Stat box) -->
              <div class="row">

                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-info">
                          <div class="inner">
                              <h3><?php echo $False_daily; ?></h3>

                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                          <p class="small-box-footer">Daily</p>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-success">
                          <div class="inner">
                              <h3><?php echo $False_weekly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                          </div>
                          <a href="#" class="small-box-footer">Weekly</a>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-info">
                          <div class="inner">
                              <h3><?php echo $False_monthly; ?></h3>

                          </div>
                          <div class="icon">
                              <i class="ion ion-bag"></i>
                          </div>
                          <p class="small-box-footer">Monthly</p>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-warning">
                          <div class="inner">
                              <h3><?php echo $False_quarterly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-person-add"></i>
                          </div>
                          <a href="#" class="small-box-footer">Quarterly</i></a>
                      </div>
                  </div>
                  <!-- ./col -->
                  <div class="col">
                      <!-- small box -->
                      <div class="small-box bg-danger">
                          <div class="inner">
                              <h3><?php echo $False_yearly; ?></h3>
                          </div>
                          <div class="icon">
                              <i class="ion ion-pie-graph"></i>
                          </div>
                          <a href="#" class="small-box-footer">Yearly</a>
                      </div>
                  </div>
                  <!-- ./col -->
              </div>
              <!-- /.row -->

              <!-- Main row -->
              <div class="row">
                  <!-- Left col -->
                  <!-- STACKED BAR CHART -->
                  <div class="card card-success">
                    <div class="card-header">
                      <h3 class="card-title">Stacked Bar Chart</h3>

                      <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                          <i class="fas fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="chart">
                        <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                  <!-- /.Left col -->


                  <!-- right col (We are only adding the ID to make the widgets sortable)-->
                  <section class="col-lg-6 connectedSortable">
                      <!-- Map card -->
                      <div class="card bg-gradient-primary">
                          <div class="card-header border-0">
                              <h3 class="card-title">
                                  <i class="fas fa-map-marker-alt mr-1"></i>
                                  Visitors
                              </h3>
                              <!-- card tools -->
                              <div class="card-tools">
                                  <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                                      <i class="far fa-calendar-alt"></i>
                                  </button>
                                  <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                                      <i class="fas fa-minus"></i>
                                  </button>
                              </div>
                              <!-- /.card-tools -->
                          </div>
                          <div class="card-body">
                              <div id="world-map" style="height: 250px; width: 100%;"></div>
                          </div>
                          <!-- /.card-body-->
                          <div class="card-footer bg-transparent">
                              <div class="row">
                                  <div class="col-4 text-center">
                                      <div id="sparkline-1"></div>
                                      <div class="text-white">Visitors</div>
                                  </div>
                                  <!-- ./col -->
                                  <div class="col-4 text-center">
                                      <div id="sparkline-2"></div>
                                      <div class="text-white">Online</div>
                                  </div>
                                  <!-- ./col -->
                                  <div class="col-4 text-center">
                                      <div id="sparkline-3"></div>
                                      <div class="text-white">Sales</div>
                                  </div>
                                  <!-- ./col -->
                              </div>
                              <!-- /.row -->
                          </div>
                      </div>
                      <!-- /.card -->
                  </section>
                  <!-- right col -->
              </div>
              <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
      </section>


    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>

                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div><!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>

            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Featured</h5>
              </div>
              <div class="card-body">
                <h6 class="card-title">Special title treatment</h6>

                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
    <?php include '../Navigation/footer_new.php' ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
</body>
</html>
