<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
parse_str($_SERVER['QUERY_STRING'], $query);
$id = $mysqli->real_escape_string($query['ID']);
$last = $mysqli->real_escape_string($query['last']);

if ($_SERVER['HTTP_REFERER'] != 'http://localhost:8888/resources/Admin/Appointments/appointment-insert.php'){
  unset($_SESSION['allArray']);
}else{
}

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];

$allArray = $_SESSION['allArray'];

foreach ($allArray as $key =>$value ) {
  // code...
  echo "<br>$key - $value";
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
  <title><?php echo $siteTitle; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../AdminLTE-master/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../AdminLTE-master/dist/css/adminlte.min.css">

  <!-- Theme style -->
  <!-- JS, Popper.js, and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

  <script type="text/javascript">


  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!--Nav bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/NavBar.php'; ?>
    <!--side bar-->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/resources//Navigation/sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Submit Appointment</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo $home_link; ?>">Home</a></li>
                <li class="breadcrumb-item active">Insert Appointment</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

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
                      <h3 class="card-title">Submit Appointment</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="appointment-insert.php" method="post">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="dodId">DOD ID Number</label>
                          <input type="text" name="dodId" id="dodId" class="form-control" placeholder=""
                          <?php if (!empty($allArray)) {
                            echo "value=$allArray[0]";
                            // code...
                          }else{echo "value=''";} ?> required autofocus>

                        </div>
                        <div class="form-group" hidden>
                          <label for="rank">Rank</label>
                          <select class="form-control" id="rank" name="rank" title="rank" >
                            <option value="">Select Rank</option>
                            <option value="A1C" <?php if ($allArray[1] == "AB") echo "selected"; ?>>AB</option>
                            <option value="Amn" <?php if ($allArray[1] == "Amn") echo "selected"; ?>>Amn</option>
                            <option value="A1C" <?php if ($allArray[1] == "A1C") echo "selected"; ?>>A1C</option>
                            <option value="SrA" <?php if ($allArray[1] == "SrA") echo "selected"; ?>>SrA</option>

                            <option value="SSgt" <?php if ($allArray[1] == "SSgt") echo "selected"; ?>>SSgt</option>
                            <option value="TSgt" <?php if ($allArray[1] == "TSgt") echo "selected"; ?>>TSgt</option>
                            <option value="MSgt" <?php if ($allArray[1] == "MSgt") echo "selected"; ?>>MSgt</option>
                            <option value="SMSgt" <?php if ($allArray[1] == "SMSgt") echo "selected"; ?>>SMSgt</option>
                            <option value="CMSgt" <?php if ($allArray[1] == "CMSgt") echo "selected"; ?>>CMSgt</option>
                            <option value="2nd Lt" <?php if ($allArray[1] == "2nd Lt") echo "selected"; ?>>2nd Lt</option>
                            <option value="1st Lt" <?php if ($allArray[1] == "1st Lt") echo "selected"; ?>>1st Lt</option>
                            <option value="Capt" <?php if ($allArray[1] == "Capt") echo "selected"; ?>>Capt</option>
                            <option value="Maj" <?php if ($allArray[1] == "Maj") echo "selected"; ?>>Maj</option>
                            <option value="Lt Col" <?php if ($allArray[1] == "Lt Col") echo "selected"; ?>>Lt Col</option>
                            <option value="Col" <?php if ($allArray[1] == "Col") echo "selected"; ?>>Col</option>
                          </select>
                        </div>

                        <div class="form-group">
                          <label for="firstName">First Name</label>
                          <input type="text" name="firstName" id="firstName" class="form-control"
                          <?php if (!empty($allArray)) {
                            echo "value='$allArray[2]'";
                            // code...
                          }else{echo "value=''";} ?>
                          placeholder="" required>
                        </div>


                        <div class="form-group" hidden>
                          <label for="middleName">Middle Name</label>
                          <input type="text" name="middleName" id="middleName" class="form-control" value="" placeholder="" >
                        </div>
                        <div class="form-group">
                          <label for="LastName">Last Name</label>
                          <input type="text" name="lastName" id="lastName" class="form-control"   <?php if (!empty($allArray)) {
                            echo "value='$allArray[3]'";
                            // code...
                          }else{echo "value=''";} ?>
                          placeholder="" required >
                        </div>





                        <div class="form-group">
                          <label for="appointmentType">Appointment Type: </label>
                          <select class="form-control" id="appointmentType" name="appointmentType" onchange="changeToState(this)">
                            <option value="">Select Type</option>
                            <option value="Housing Office" <?php if ($allArray[5] == "Housing Office") echo "selected"; ?>>Housing Office</option>
                            <option value="Firing" <?php if ($allArray[5] == "Firing") echo "selected"; ?>>Firing</option>
                            <option value="Medical" <?php if ($allArray[5] == "Medical") echo "selected"; ?>>Medical</option>
                            <option value="Dental" <?php if ($allArray[5] == "Dental") echo "selected"; ?>>Dental</option>
                            <option value="FTAC" <?php if ($allArray[5] == "FTAC") echo "selected"; ?>>FTAC</option>
                            <option value="Off-Base" <?php if ($allArray[5] == "Off-Base") echo "selected"; ?>>Off-Base</option>
                            <option value="Out-Process" <?php if ($allArray[5] == "Out-Process") echo "selected"; ?>>Out-Process</option>
                            <option value="TAPS" <?php if ($allArray[5] == "TAPS") echo "selected"; ?>>TAPS</option>
                            <option value="Fitness Test" <?php if ($allArray[5] == "Fitness Test") echo "selected"; ?>>Fitness Test</option>
                            <option value="Leave" <?php if ($allArray[5] == "Leave") echo "selected"; ?>>Leave</option>
                            <option value="Other" <?php if ($allArray[5] == "Other") echo "selected"; ?>>Other</option>
                          </select>
                        </div>

                        <script type="text/javascript">

                        function changeToState(){
                          if(document.getElementById('appointmentType').value=='Leave'){
                            document.getElementById("changeToState").innerHTML = "State";
                            document.getElementById("installation").placeholder = "State";
                            document.getElementById("changeToCity").innerHTML = "City";
                            document.getElementById("changeToLeaveStart").innerHTML = "Leave Start Date";
                            document.getElementById("changeToLeaveEnd").innerHTML = "Leave End Date";
                            document.getElementById("changeToHidden").style.display = 'none';


                          }else{
                            document.getElementById("changeToState").innerHTML = "Installation";
                            document.getElementById("installation").placeholder = "Installation";
                            document.getElementById("changeToCity").innerHTML = "Location";
                            document.getElementById("location").placeholder = "Building # or Building Name";
                            document.getElementById("changeToLeaveStart").innerHTML = "Appointment Start Date";
                            document.getElementById("changeToLeaveEnd").innerHTML = "Appointment End Date";
                            document.getElementById("changeToHidden").style.display = '';

                          }
                        }



                        window.addEventListener('load', (event) => {
                                  document.getElementById("showEmail").style.display = 'none';
                        });


                        function showEmail() {

                          if (document.getElementById('emailReminder').checked == true) {
                            document.getElementById("showEmail").style.display = 'block';
                          } else {
                            document.getElementById("showEmail").style.display = 'none';
                          }

                        }


                        </script>

                        <div class="form-group">
                          <label for="installation" id="changeToState">Installation</label>
                          <input type="text" name="installation" id="installation" class="form-control" placeholder="Installation"  <?php if (!empty($allArray)) {
                            echo "value='$allArray[4]'";
                            // code...
                          }else{echo "value=''";} ?> required>
                        </div>
                        <div class="form-group">
                          <label for="location" id="changeToCity">Location</label>
                          <input type="text" name="location" id="location" class="form-control" placeholder="Building # or Building Name"  <?php if (!empty($allArray)) {
                            echo "value='$allArray[6]'";
                            // code...
                          }else{echo "value=''";} ?> required>
                        </div>


                        <div class="form-group">
                          <label for="startdate" id="changeToLeaveStart">Appointment Start Date</label>
                          <input type="datetime-local" name="startdate" id="startdate" class="form-control" placeholder="" <?php if (!empty($allArray)) {
                            echo "value='$allArray[8]'";
                            // code...
                          }else{echo "value=''";} ?> required>
                        </div>
                        <div class="form-group" >
                          <label for="enddate" id="changeToLeaveEnd">Appointment End Date</label>
                          <input type="datetime-local" name="enddate" id="enddate" class="form-control" placeholder="" <?php if (!empty($allArray)) {
                            echo "value='$allArray[9]'";
                            // code...
                          }else{echo "value=''";} ?> required >
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4" id="changeToHidden">

                            <label for="selfMade">Self Made</label>
                            <input type="checkbox" name="selfMade" id="selfMade" class="form-control" placeholder="" value="yes" style="align:left" display="">
                          </div>
                          <div class="form-group col-md-4" onchange="showEmail()">
                            <label for="emailReminder">Email Reminder</label>
                            <input type="checkbox" name="emailReminder" id="emailReminder" class="form-control" placeholder="" style="align:left" value="Yes"
                            <?php if (empty($allArray[11])) {

                              // code...
                            }else{echo "value='Yes' checked";} ?>  >
                          </div>



                          <div class="form-group col-md-4">
                            <label for="override">Override</label>
                            <input type="checkbox" name="override" id="override" class="form-control" placeholder="" style="align:left" value="Yes"
                            <?php if (!isset($allArray[10])==true) {
                              echo "value='No'";
                              // code...
                            }else{echo "value='Yes' checked";} ?>  >
                          </div>
                          <div class="form-group col-md-4" hidden>
                            <label for="delete">Delete</label>
                            <input type="checkbox" name="delete" id="delete" class="form-control" placeholder="">
                          </div>
                        </div>



                                                <div class="form-group" id="showEmail">
                                                  <label for="email">Email Address</label>
                                                  <input type="text" name="email" id="email" class="form-control" placeholder="" <?php if (!empty($allArray)) {
                                                    echo "value='".urldecode($allArray[7])."'";
                                                    // code...
                                                  }else{echo "value=''";} ?> >
                                                </div>


                        <div class="form-group">
                          <label for="notes">Note: </label>
                          <select class="form-control" id="notes" name="notes" title="notes">
                            <option value="">Select Note</option>
                            <option value="0">No Notes</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <!-- /.card-body -->

                    <div class="card-footer">
                      <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
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
    <!-- /.content-wrapper -->
    <!-- Footer -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->
  <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Navigation/footer.php'; ?>
  <!-- jQuery -->
  <script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../../../AdminLTE-master/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/jszip/jszip.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../../AdminLTE-master/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../../../AdminLTE-master/dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#ExteriorAlarmTables').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#InteriorAlarmTables').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    $('#AdminViewCompletedAlarmTables').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
