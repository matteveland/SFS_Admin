<?php
include $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/config/config.php';
include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/functions/fitnessFunction.php';
//include $_SERVER['DOCUMENT_ROOT'].'/resources/Admin/Login-Logout/verifyLogin.php';
//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();
//verify login to account before access is given to site
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');
$unitName = $_SESSION['unitName'];
$userName = $_SESSION['page_admin'];
$now = date('Y-m-d');

$findUser = new FindUser();
$findUser->get_user($_SESSION['page_user'], $_SESSION['page_admin']);

if (($_SESSION['page_admin']) OR ($_SESSION['page_user']) == true) {

  $findsectionFitness = $mysqli->query("SELECT *
    from fitness f
    INNER join members m
    on m.lastName = f.lastName AND m.firstName = f.firstName
    where (m.dutySection = '$findUser->dutySection')
    AND (m.unitName = '$unitName')
    AND m.rank <> 'Civ'
    AND NOT m.lastName LIKE 'DELETE_%'
    order by m.lastName, f.dueDate ASC") or die(mysqli_errno($mysqli));


    if ($findsectionFitness->num_rows) {
      // output data of each row

      echo "<br><h3 style='text-align: center'>Section Fitness (".$findUser->dutySection.")</h3><table>
      <table id='fitness' class='table table-bordered table-hover'>
      <thead>
      <tr>
      <th>Rank</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Mock Date</th>
      <th>Fitness Assessment Date</th>
      <th>Push Up</th>
      <th>Push Up Composite</th>
      <th>Sit Up</th>
      <th>Sit Up Composite</th>
      <th>Run</th>
      <th>Run Composite</th>
      <th>Waist</th>
      <th>Waist Composite</th>
      <th>Total Composite Score</th>
      </tr>
      </thead>";




      while ($row = $findsectionFitness->fetch_assoc()) {

        $plusOneYearStrToTime = strtotime($row["dueDate"]);

        $plusOneYear = date('Y-m-d', strtotime($plusOneYearStrToTime . '+365 days'));

        $now = date("Y-m-d");
        $minus30Years = date('Y-m-d', strtotime($now . '-30 years'));
        $minus40Years = date('Y-m-d', strtotime($now . '-40 years'));
        $minus50Years = date('Y-m-d', strtotime($now . '-50 years'));
        $minus60Years = date('Y-m-d', strtotime($now . '-60 years'));

        $sitUp = $row["sitUps"];
        $pushUp = $row["pushUps"];
        $time = $row["run"];
        $waist = $row["waist"];
        $mockDate = $row["mockDate"];
        $dueDate = $row["dueDate"];
        $dueDate = date('Y-m-d', strtotime($dueDate . '+365 days'));
        $birthDate = strtotime($row['birthdate']);

        //echo $row["lastname"]. " " . $row["firstname"]. " " . $row["dutysection"]. " " . $row["trngType"]. " " . $row["trnglastcompleted"]. " " . $row["trngdue"]. "<br>";

        echo "<tr class='nth-child' align='center'>
        <td class='nth-child'>" . $row["rank"] . "</td>
        <td>" . $row["lastName"] . "</td>
        <td>" . $row["firstName"] . "</td>
        <td>";
        if ($mockDate > 1) {
          echo $mockDate;
        } else {
          echo "";
        }
        echo "</td>
        <td>";
        if ($dueDate > 1) {
          echo $dueDate;
        } else {
          echo "";
        }
        echo "</td>
        <td>" . $row["pushUps"] . "</td>

        <td>";

        //Run function
        if (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Male') AND (!$row['pushUps'] = '')) {
          malesLess30PushUps($pushUp);

          ob_start();
          malesLess30PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Male') AND (!$row['pushUps'] = '')) {

          malesLess40PushUps($pushUp);

          ob_start();
          malesLess40PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Male') AND (!$row['pushUps'] = '')) {
          malesLess50PushUps($pushUp);

          ob_start();
          malesLess50PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Male') AND (!$row['pushUps'] = '')) {
          malesLess60PushUps($pushUp);

          ob_start();
          malesLess60PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] < $minus60Years) AND ($row['gender'] == 'Male') AND (!$row['pushUps'] = '')) {
          males60PlusPushUps($pushUp);

          ob_start();
          males60PlusPushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } ////female scores need to be created Male function is being called to show concept
        elseif (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Female') AND (!$row['pushUps'] = '')) {
          malesLess30PushUps($pushUp);

          ob_start();
          malesLess30PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Female') AND (!$row['pushUps'] = '')) {

          malesLess40PushUps($pushUp);

          ob_start();
          malesLess40PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Female') AND (!$row['pushUps'] = '')) {
          malesLess50PushUps($pushUp);

          ob_start();
          malesLess50PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Female') AND (!$row['pushUps'] = '')) {
          malesLess60PushUps($pushUp);

          ob_start();
          malesLess60PushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();


        } elseif (($row['birthdate'] < $minus60Years) AND ($row['gender'] == 'Female') AND ($row['pushUps'] <> '')) {
          males60PlusPushUps($pushUp);

          ob_start();
          males60PlusPushUps($pushUp);
          $pushUpOutput = ob_get_contents();
          ob_end_clean();
        } else {
          echo "";
        }

        echo "</td>

        <td>" . $row["sitUps"] . "</td>
        <td>";

        if (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Male') AND (!$row['sitUps'] = '')) {

          malesLess30sitUps($sitUp);

          ob_start();
          malesLess30sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Male') AND (!$row['sitUps'] = '')) {

          malesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Male') AND (!$row['sitUps'] = '')) {

          malesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Male') AND (!$row['sitUps'] = '')) {

          malesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

          /*  }elseif (($row['birthdate'] > $) AND ($row['gender'] == 'Male')) {

          malesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();*/

        } elseif (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Female') AND (!$row['sitUps'] = '')) {

          femalesLess30sitUps($sitUp);

          ob_start();
          malesLess30sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Female') AND (!$row['sitUps'] = '')) {

          femalesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Female') AND (!$row['sitUps'] = '')) {

          femalesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Female') AND (!$row['sitUps'] = '')) {

          femalesLess40sitUps($sitUp);

          ob_start();
          malesLess40sitUps($sitUp);
          $situpOutput = ob_get_contents();
          ob_end_clean();

        } else {
          echo "";
        }


        echo "</td>
        <td>" . $time . "</td>
        <td>";


        //Run function

        if (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Male') AND (!$row['run'] = '')) {
          malesLess30($time);

          ob_start();
          malesLess30($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Male') AND (!$row['run'] = '')) {
          malesLess40($time);

          ob_start();
          malesLess40($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Male') AND (!$row['run'] = '')) {
          malesLess50($time);

          ob_start();
          malesLess50($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Male') AND (!$row['run'] = '')) {
          malesLess60($time);

          ob_start();
          malesLess60($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] < $minus60Years) AND ($row['gender'] == 'Male') AND (!$row['run'] <> '')) {
          males60Plus($time);

          ob_start();
          males60Plus($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus30Years) AND ($row['gender'] == 'Female') AND (!$row['run'] = '')) {
          femalesLess30($time);

          ob_start();
          femalesLess30($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus40Years) AND ($row['gender'] == 'Female') AND (!$row['run'] = '')) {
          femalesLess40($time);

          ob_start();
          femalesLess40($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus50Years) AND ($row['gender'] == 'Female') AND (!$row['run'] = '')) {
          femalesLess50($time);

          ob_start();
          femalesLess50($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['birthdate'] > $minus60Years) AND ($row['gender'] == 'Female') AND (!$row['run'] = '')) {
          femalesLess60($time);

          ob_start();
          femalesLess60($time);
          $runTimeOutput = ob_get_contents();
          ob_end_clean();

        } else {
          echo "";
        }
        echo "</td>

        <td>" . $row["waist"] . "</td>


        <td>";

        //waist function
        if (($row['gender'] == 'Female') AND (!$row['waist'] == '')) {
          femalesAbs($waist);

          ob_start();
          femalesAbs($waist);
          $waistOutput = ob_get_contents();
          ob_end_clean();

        } elseif (($row['gender'] == 'Male') AND (!$row['waist'] == '')) {
          malesAbs($waist);

          ob_start();
          malesAbs($waist);
          $waistOutput = ob_get_contents();
          ob_end_clean();


        } else {
          echo "";
        }

        echo "</td>


        <td>";


        $compositeTotal = ((int)$pushUpOutput + (int)$runTimeOutput + (int)$waistOutput + (int)$situpOutput);


        echo "$compositeTotal points <br>";
        /* echo "$pushUpOutput push up points<br>";
        echo "$runTimeOutput run  end<br>";

        echo "$situpOutput sit up points end<br>"; */


        echo "</td>
        </tr>

        ";
        // code...
      }


    } else {
      echo "<br>
      <h3 style='text-align: center'>No personnel Fitness Assessments (".$findUser->dutySection.")</h3>";
    }

    echo "</table><br>";

    //view open alarm data
    //exterior alarms
    //


  }else {
    echo "<p style='alignment: center; size: 24px'>You do not have permissions to view this page non-admin</p>";

    include __DIR__ . '/../../footer.php';

    header('Location: /UnitTraining/home.php');
    exit;
  }
