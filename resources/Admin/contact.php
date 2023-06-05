<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/classes/findUser.class.php';

//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();//verify login to account before access is given to site

//find User from class. this will be used throughout site to find user
$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);


parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];


$findMember = $mysqli->query("SELECT * From login l inner JOIN members m on l.lastName = m.lastName AND l.firstName = m.firstName AND l.dodId = m.dodId WHERE '" . $_SESSION['page_user'] . "' = user_name OR '" . $_SESSION['page_admin'] . "' = user_name");

while ($row = $findMember->fetch_assoc()) {

    $userID = $row['user_name'];
    $last = $row['lastName'];
    $first = $row['firstName'];
    $middle = $row['middleName'];
    $admin = $row['admin'];
    $unitName = $row['unitName'];
    $img = $row['image'];
    $imgDetail = $row['imageDetail'];
}



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
  <link rel="stylesheet" href="../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../AdminLTE-master/dist/css/adminlte.min.css">

    <!-- Theme style -->
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>

    </script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

      <!--Nav bar-->
      <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>

      <!-- Main Sidebar Container -->
      <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/sidebar.php'; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="min-height: 1403.625px;">
            <!-- Content Header (Page header) -->

            <!-- Main content -->
            <div class="container-fluid">
                <section class="content">
                    <div class="container-fluid">

                        <div class="col-md-8">

                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-10">
                                    <!-- general form elements -->
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Submit Contact Form</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form action="insert-contact.php" method="post">
                                            <div class="card-body">

                                                <div class="alert alert-warning" role="alert">
                                                    <p>By submitting your suggestion, you agree to submit the following with your suggestion:<br>
                                                    <ul>
                                                    <li>  <strong>Rank</strong>
                                                        <li>  <strong>Last Name</strong>
                                                        <li>  <strong>First Name</strong>
                                                        <li>  <strong>Unit Name</strong>
                                                        <li> <strong>Email Address</strong></li>
                                                    </ul>
                                                </div>


                                                <div class="form-group">
                                                    <label for="rank">Rank</label>
                                                    <select class="form-control" id="rank" name="rank" title="rank" required>
                                                        <option value="">Select Rank</option>
                                                        <option value="AB">AB</option>
                                                        <option value="Amn">Amn</option>
                                                        <option value="A1C">A1C</option>
                                                        <option value="SrA">SrA</option>
                                                        <option value="SSgt">SSgt</option>
                                                        <option value="TSgt">TSgt</option>
                                                        <option value="MSgt">MSgt</option>
                                                        <option value="SMSgt">SMSgt</option>
                                                        <option value="CMSgt">CMCgt</option>
                                                        <option value="2nd Lt">2nd Lt</option>
                                                        <option value="1st Lt">1st Lt</option>
                                                        <option value="Capt">Capt</option>
                                                        <option value="Maj">Maj</option>
                                                        <option value="Lt Col">Lt Col</option>
                                                        <option value="Col">Col</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" name="firstName" id="firstName" class="form-control" value="" placeholder="" required>

                                                </div>


                                                <div class="form-group">
                                                    <label for="LastName">Last Name</label>
                                                    <input type="text" name="lastName" id="lastName" class="form-control" placeholder="" required>

                                                </div>
                                                <div class="form-group">
                                                    <label for="suggestionField">Suggestion</label>

                                                    <textarea rows="8" cols="50" name="suggestionField" id="suggestionField" class="form-control" placeholder=""></textarea>
                                                </div>

                                            </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" name="inputSubmit" id="inputSubmit" class="btn btn-primary">Submit Contact Form</button>
                                    </div>
                                    </form>
                                </div>
                                <!-- /.card -->

                                <!--/.col (left) -->
                                <!-- right column -->

                            </div>
                            <!-- /.row -->
                        </div><!-- /.container-fluid -->

                    </div>
            </div>
            </section>
            <!-- /.content -->

        </div>

        <!-- Content Header (Page header) -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../AdminLTE-master/dist/js/adminlte.min.js"></script>
</body>

</html>
