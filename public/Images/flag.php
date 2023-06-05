<?php


require_once __DIR__.'/dbconfig/connect.php';
//require_once __DIR__.'/login_logout/verifyLogin.php'; //verify login to account before access is given to site

if(!isset($_SESSION['page_admin']) && (!isset($_SESSION['page_user']))){
}else {

    $unitName = $_SESSION['unitName'];
    $admin = $_SESSION['page_admin'];
    $user = $_SESSION['page_user'];

    $getUserName = "SELECT lastName, firstName FROM login WHERE (user_name = '$admin' OR user_name = '$user')";

    $resultsUser = mysqli_query($connection, $getUserName);

    if (mysqli_num_rows($resultsUser) > 0) {
        while ($row = mysqli_fetch_assoc($resultsUser)) {

            $recallAdmin_UserLastRecall = $row['lastName'];
            $recallAdmin_UserFirstRecall = $row['firstName'];
        }
    }

    $sqlLeave = "select *
    from appointmentRoster a
    where ((lastName = '$recallAdmin_UserLastRecall' AND firstName = '$recallAdmin_UserFirstRecall')
    AND a.title = 'Leave' AND (a.enddate BETWEEN now() - INTERVAL 5 DAY AND now() + INTERVAL 45 DAY ))
    ";

    $sqlArming = "SELECT *
    FROM members m
    INNER JOIN armingRoster a
    ON m.lastName = a.lastName AND m.firstName = a.firstName
    WHERE a.lastName = '$recallAdmin_UserLastRecall' AND a.firstName = '$recallAdmin_UserFirstRecall' AND ((a.m4Qual <> '') OR (a.m9Qual <> '') OR (a.baton <> '') OR (a.useOfForce <> '') OR (a.lat <> '') OR (a.smcFired <> '') OR (a.m203Exp <> '') OR (a.m249Exp <> '') OR (a.m240Exp <> '') OR (a.m870Exp <> '') OR (a.taser <> ''))
    ";


    $sqlCBTList = "SELECT *
    FROM members
    INNER JOIN cbtList799
    ON cbtList799.lastName = members.lastName AND cbtList799.firstName = members.firstName
    WHERE members.lastName = '$recallAdmin_UserLastRecall' AND members.firstName = '$recallAdmin_UserFirstRecall'
    ";

    $sqlCCTK = "select *
        from members m
    INNER join cctkList c
     on m.lastName LIKE c.lastName AND m.firstName LIKE c.firstName
    where (c.lastName LIKE '$recallAdmin_UserLastRecall' AND c.firstName LIKE '$recallAdmin_UserFirstRecall')
    order by m.lastName
    ";

    $sqlSFMQ = "select *
    from sfmq WHERE lastName = '$recallAdmin_UserLastRecall' AND firstName = '$recallAdmin_UserFirstRecall' AND ((primCertDate <> '') OR (phase2Start <> '')) AND (reCertDate BETWEEN now() - INTERVAL 900 DAY AND now() + INTERVAL 45 DAY )
     ";


    $recallMemberFitnessInformation = "select * From fitness WHERE lastName = '$recallAdmin_UserLastRecall' AND firstName = '$recallAdmin_UserFirstRecall' AND unitName = '$unitName' AND (dueDate BETWEEN now() - INTERVAL 900 DAY AND now() + INTERVAL 45 DAY )";

    $resultRecallMemberFitnessInformation = mysqli_query($connection, $recallMemberFitnessInformation);
    $result4 = mysqli_query($connection, $sqlSFMQ);
    $result3 = mysqli_query($connection, $sqlCCTK);
    $resultcbt = mysqli_query($connection, $sqlCBTList);
    $resultArming = mysqli_query($connection, $sqlArming);
    $resultLeave = mysqli_query($connection, $sqlLeave) or die(mysqli_error($connection));

    if ((mysqli_num_rows($resultLeave) > 0) OR
        (mysqli_num_rows($resultArming) > 0) OR (mysqli_num_rows($resultcbt) > 0) OR
        (mysqli_num_rows($result3) > 0) OR (mysqli_num_rows($result4) > 0) OR (mysqli_num_rows($resultRecallMemberFitnessInformation) > 0)) {

        echo '<img src="/UnitTraining/adminpages/redCheckmark.png" style="width:15px;height:15px;">Not Current. You require the following:</br>';

        if (mysqli_num_rows($resultLeave) > 0) {
            echo "leave</br>";

        }
        if (mysqli_fetch_all($resultArming) > 0) {
            echo "arming </br>";
        }
        if (mysqli_num_rows($resultcbt) > 0) {

            echo "cbt</br>";
        }
        if (mysqli_num_rows($result3) > 0) {

            echo "cctk</br>";
        }
        if (mysqli_num_rows($result4) > 0) {

            echo "sfmq</br>";
        }
        if (mysqli_num_rows($resultRecallMemberFitnessInformation) > 0) {

            echo "fitness</br>";
        }
    } else {
        echo '<img src="/UnitTraining/adminpages/greenCheckmark.png" style="width:15px;height:15px;">current
';


    }

}
