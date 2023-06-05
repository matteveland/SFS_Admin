<?php


require_once __DIR__ . '/../../config/connect.php';
require_once __DIR__ . '/../../config/config.php';
//include __DIR__ . "../../AdminLTE-master/pages/UI/modals.html";
include('/Users/matteveland/code/data.env');

//check if user is logged in. if logged in allow access, otherwise return to login page
isUserLogged_in();


$findESSTrendsDesc = "SELECT alarmDescription from alarmData
                        where unitName = '432 SFS' order BY id";

$findESSTrendsId = "SELECT id from alarmData
                        where unitName = '432 SFS' order BY id";
$resultFindESSTrendsDesc = mysqli_query($mysqli, $findESSTrendsDesc);

$findESSTrendsIv = "SELECT iv from alarmData
                        where unitName = '432 SFS' order BY id";
$resultFindESSTrendsIv = mysqli_query($mysqli, $findESSTrendsIv);


$resultFindESSTrendsId = mysqli_query($mysqli, $findESSTrendsId);
$count = mysqli_num_rows($resultFindESSTrendsDesc);

echo $count;


echo "<br>";
while ($row = mysqli_fetch_array($resultFindESSTrendsDesc)) {
    $resultsDesc[] = $row['alarmDescription'];
}

while ($row = mysqli_fetch_array($resultFindESSTrendsId)) {
    $resultsId[] = $row['id'];
}

while ($row = mysqli_fetch_array($resultFindESSTrendsIv)) {
    $resultsIv[] = $row['iv'];
}
//echo $essDescriptionKey;


$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipherMethod));

for ($i = 0; $i < $count; $i++) {
    $encryptedAlarmData = openssl_encrypt($resultsDesc[$i], $cipherMethod, $essDescriptionKey, $options = 0, $iv);
    [$i];
     echo "$encryptedAlarmData<br>";[$i];
   $update = "update alarmData set alarmDescription = '$encryptedAlarmData', iv = '$iv' where id = '$resultsId[$i]'";
    [$i];
    echo "$update<br>";
    //$updateUpdate = mysqli_query($mysqli, $update) or die(mysqli_error($mysqli));

    if (!$updateUpdate) {

        echo "error";

    } else {
        echo "success";
    }
}


for ($i = 0; $i < $count; $i++) {
    $decryptESS = openssl_decrypt($resultsDesc[$i], $cipherMethod, $essDescriptionKey, 0, $resultsIv[$i]);
    // echo "$encryptedAlarmData<br>";[$i];
    $show = "update alarmData set alarmDescription = '$decryptESS' where id = '$resultsId[$i]'";
    [$i];

    echo "Decrypted -> $show<br>";
    // $updateUpdate = mysqli_query($mysqli, $update);
}
