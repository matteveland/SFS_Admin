<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';

//check if user is logged in. if logged in allow access, otherwise return to login page
//isUserLogged_in();//verify login to account before access is given to site
parse_str($_SERVER['QUERY_STRING'], $query);
$unitName = $_SESSION['unitName'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php $siteTitle ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/AdminLTE-master/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-master/dist/css/adminlte.min.css">
  <style media="screen">
  /* The message box is shown when the user clicks on the password field */
  #message {
    display:none;
    background: #f1f1f1;
    color: #000;
    position: relative;
    padding: 20px;
    margin-top: 10px;
  }

  #message p {
    padding: 10px 35px;
    font-size: 18px;
  }

  /* Add a green text color and a checkmark when the requirements are right */
  .valid {
    color: green;
  }

  .valid:before {
    position: relative;
    left: -35px;
    content: "✔";
  }

  /* Add a red text color and an "x" when the requirements are wrong */
  .invalid {
    color: red;
  }

  .invalid:before {
    position: relative;
    left: -35px;
    content: "✖";
  }

  </style>
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="/`resources/Admin/Login-Logout/login.php" class="h1"><b>SFS</b>Admin</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Create User Login</p>

        <form action="register-insert-login.php" method="post">
          <?php include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/unitSelect.php'?>

          <!--   -->
          <div class="input-group mb-3">
            <input type="text" name="firstName" id="firstName" class="form-control" value=""placeholder="First Name" required>
          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="text" name="middleName" id="middleName" class="form-control" placeholder="Middle Name" required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Last Name" required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your @us.af.mil/@mail.mil address" required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="text" name="TAFMSD" id="inputTAFMSD" class="form-control" placeholder="TAFMSD DD-MMM-YY " required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" maxlength="30"required>

          </div>
          <!--   -->
          <div class="input-group mb-3">
            <input type="password" name="verifyPassword" id="inputPassword" class="form-control" placeholder="Verify Password" maxlength="30"  required>
          </div>


          <div id="message">
            <h3>Password must contain the following:</h3>
            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
            <p id="number" class="invalid">A <b>number</b></p>
            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
          </div>
          <!--   -->
          <label for="secretQuestion">Secret Question</label>
          <div class="input-group mb-3">


            <select class="form-control" id="secretQuestion" name="secretQuestion" required autofocus>
              <option value="">Select</option>
              <option value="1">What is your favorite color?</option>
              <option value="2">Make of your first car?</option>
              <option value="3">Favorite sport?</option>
              <option value="4">Best location your have visited?</option>
              <option value="5">Are sharks fish?</option>
            </select>

          </div>
          <div class="input-group mb-3">
            <input type="text" name="secretAnswer" id="secretAnswer" class="form-control" placeholder="Secret Answer" required>
          </div>

          <div class="row">
            <div class="col-8">
              <div >

              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="submit" id="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.col -->
        </form>
        <p class="mb-1">
          <a href="forgot-password.html">I forgot my password</a>
        </p>

        <p class="mb-1">


        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../../../AdminLTE-master/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../../../AdminLTE-master/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../../../AdminLTE-master/dist/js/adminlte.min.js"></script>
</body>
</html>
