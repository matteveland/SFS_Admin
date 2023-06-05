<?php


////MALE Run Time 17-29
function malesLess30($runTime)
{


//string value of score add to other componets
    if ($runTime == 'Exempt') {
        echo "Exempt";
    }elseif ($runTime == '0' OR '') {
        echo '';
    }elseif ($runTime >= '04:00' && $runTime <= '09:12') {
        echo "60.0";
    } else if ($runTime >= '09:13' && $runTime <= '09:34') {
        echo "59.7";
    } else if ($runTime >= '09:35' && $runTime <= '09:45') {
        echo "59.3";
    } else if ($runTime >= '09:46' && $runTime <= '09:58') {
        echo "58.9";
    } else if ($runTime >= '09:59' && $runTime <= '10:10') {
        echo "58.5";
    } else if ($runTime >= '10:11' && $runTime <= '10:37') {
        echo "57.3";
    } else if ($runTime >= '10:38' && $runTime <= '10:51') {
        echo "56.6";
    } else if ($runTime >= '10:51' && $runTime <= '11:06') {
        echo "55.7";
    } else if ($runTime >= '11:07' && $runTime <= '11:22') {
        echo "53.4";
    } else if ($runTime >= '11:23' && $runTime <= '11:38') {
        echo "54.8";
    } else if ($runTime >= '11:39' && $runTime <= '11:56') {
        echo "52.4";
    } else if ($runTime >= '11:57' && $runTime <= '12:14') {
        echo "50.9"; ;
    } else if ($runTime >= '12:15' && $runTime <= '12:33') {
        echo "49.2";
    } else if ($runTime >= '12:34' && $runTime <= '12:53') {
        echo "47.2";
    } else if ($runTime >= '12:54' && $runTime <= '13:14') {
        echo "44.9";
    } else if ($runTime >= '13:15' && $runTime <= '13:36') {
        echo "42.3";
    } else {

        echo "0";

    }
    //return $runTime;


}


////MALE Run Time 30-40
function malesLess40($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif  ($time >= '04:00' && $time <= '09:34') {
        echo "60.0";
    } else if ($time >= '09:35' && $time <= '09:58') {
        echo "59.3";
    } else if ($time >= '09:59' && $time <= '10:10') {
        echo "58.6";
    } else if ($time >= '10:11' && $time <= '10:23') {
        echo "57.9";
    } else if ($time >= '10:24' && $time <= '10:37') {
        echo "57.3";
    } else if ($time >= '10:38' && $time <= '10:51') {
        echo "56.6";
    } else if ($time >= '10:52' && $time <= '11:06') {
        echo "55.7";
    } else if ($time >= '11:07' && $time <= '11:22') {
       echo "54.8";
    } else if ($time >= '11:23' && $time <= '11:38') {
        echo "53.7";
    } else if ($time >= '11:39' && $time <= '11:56') {
        echo "52.4";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "50.9";
    } else if ($time >= '12:15' && $time <= '12:33') {
        echo "49.2";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "47.2";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "44.9";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "42.3";
    }else if ($time >= '13:37' && $time <= '14:00') {
    echo "30.3";
}
else {

        echo "0";

    }
}

////MALE Run Time 40-50
function malesLess50($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif  ($time >= '04:00' && $time <= '09:45') {
        echo "60.0";
    } else if ($time >= '09:46' && $time <= '10:10') {
        echo "59.8";
    } else if ($time >= '10:11' && $time <= '10:23') {
        echo "59.5";
    } else if ($time >= '10:24' && $time <= '10:37') {
        echo "59.1";
    } else if ($time >= '10:38' && $time <= '10:51') {
        echo "58.7";
    } else if ($time >= '10:52' && $time <= '11:06') {
        echo "56.6";
    } else if ($time >= '11:07' && $time <= '11:22') {
        echo "57.7";
    } else if ($time >= '11:23' && $time <= '11:38') {
        echo "57.1";
    } else if ($time >= '11:39' && $time <= '11:56') {
        echo "53.7";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "55.4";
    } else if ($time >= '12:14' && $time <= '12:33') {
        echo "54.3";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "53.1";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "51.5";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "49.8";
    }else if ($time >= '13:37' && $time <= '14:00') {
        echo "47.7";
    }else if ($time >= '14:01' && $time <= '14:25') {
        echo "45.2";
    }else if ($time >= '12:15' && $time <= '12:33') {
        echo "42.3";
    }
    else {

        echo "0";

    }
}

////MALE Run Time 50-60
function malesLess60($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif  ($time >= '04:00' && $time <= '10:37') {
        echo "60.0";
    } else if ($time >= '10:38' && $time <= '11:06') {
        echo "59.7";
    } else if ($time >= '11:07' && $time <= '11:22') {
        echo "59.4";
    } else if ($time >= '11:23' && $time <= '11:38') {
        echo "59.0";
    } else if ($time >= '11:39' && $time <= '11:56') {
        echo "58.5";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "58.0";
    } else if ($time >= '12:14' && $time <= '12:33') {
        echo "57.3";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "56.5";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "55.6";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "54.5";
    }else if ($time >= '13:37' && $time <= '14:00') {
        echo "53.3";
    }else if ($time >= '14:01' && $time <= '14:25') {
        echo "51.8";
    }else if ($time >= '14:26' && $time <= '14:52') {
        echo "50.0";
    }else if ($time >= '14:53' && $time <= '15:20') {
        echo "47.9";
    }else if ($time >= '15:21' && $time <= '15:50') {
        echo "45.4";
    }else if ($time >= '15:51' && $time <= '16:22') {
        echo "42.4";
    }
    else {

        echo "0";

    }
}

////MALE Run Time +60
function males60Plus($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif  ($time >= '04:00' && $time <= '11:22') {
        echo "60.0";
    } else if ($time >= '11:23' && $time <= '11:56') {
        echo "59.7";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "59.4";
    } else if ($time >= '12:15' && $time <= '12:33') {
        echo "59.0";
    }    else if ($time >= '12:34' && $time <= '12:53') {
        echo "58.5";
        } else if ($time >= '12:54' && $time <= '13:14') {
        echo "58.0";
        } else if ($time >= '13:15' && $time <= '13:36') {
        echo "57.3";
        } else if ($time >= '13:37' && $time <= '14:00') {
            echo "56.5";
        }else if ($time >= '14:01' && $time <= '14:25') {
            echo "55.6";
        }else if ($time >= '14:26' && $time <= '14:52') {
            echo "54.5";
        }else if ($time >= '14:53' && $time <= '15:20') {
            echo "53.3";
        }else if ($time >= '15:21' && $time <= '15:50') {
            echo "51.8";
        }else if ($time >= '15:51' && $time <= '16:22') {
            echo "50.0";
        }else if ($time >= '16:23' && $time <= '16:57') {
            echo "47.9";
        }else if ($time >= '16:58' && $time <= '17:34') {
            echo "45.4";
    } else if ($time >= '17:35' && $time <= '18:14') {
            echo "42.4";
    }
    else {

        echo "0";

    }
}

function malesAbs($waist)

{

//string value of score add to other componets
    if ($waist == 'Exempt') {
        echo "Exempt";
    }elseif ($waist == '0' OR $waist == '') {
        echo '';
    }elseif ($waist >= '10' && $waist <= '35') {
        echo "20.0";
    }elseif ($waist <= '35.5') {
        echo "17.6";
    }elseif ($waist <= '36') {
        echo "17.0";
    }elseif ($waist <= '36.5') {
        echo "16.4";
    }elseif ($waist <= '37') {
        echo "15.8";
    }elseif ($waist <= '37.5') {
        echo "15.1";
    }elseif ($waist <= '38') {
        echo "14.4";
    }elseif ($waist <= '38.5') {
        echo "13.5";
    }elseif ($waist <= '39') {
        echo "12.6";
    }
    else {

        echo "0";

    }

}


function femalesAbs($waist)

{

//string value of score add to other componets
    if ($waist == 'Exempt') {
        echo "Exempt";

    }elseif ($waist == '0' OR $waist == '') {
        echo '';
    }elseif ($waist >= '10' && $waist <= '31.5') {
        echo "20.0";
    }elseif ($waist <= '32.0') {
        echo "17.6";
    }elseif ($waist <= '32.5') {
        echo "17.1";
    }elseif ($waist <= '33.0') {
        echo "16.3";
    }elseif ($waist <= '33.5') {
        echo "15.9";
    }elseif ($waist <= '34.0') {
        echo "15.2";
    }elseif ($waist <= '34.5') {
        echo "14.5";
    }elseif ($waist <= '35.0') {
        echo "13.7";
    }elseif ($waist <= '35.5') {
        echo "12.8";
    }
    else {

        echo "0";

    }

}


function malesLess30PushUps($pushUp)

{

//string value of score add to other componets
    if ($pushUp == 'Exempt') {
        echo "Exempt";
    }elseif ($pushUp == '0' OR '') {
        echo '';
    }elseif ($pushUp >= '67') {
        echo "10.0";
    } elseif ($pushUp >= '62') {
        echo "9.5";
    }elseif ($pushUp >= '61') {
        echo "9.4";
    }elseif ($pushUp >= '60') {
        echo "9.3";
    }elseif ($pushUp >= '59') {
        echo "9.2";
    }elseif ($pushUp >= '58') {
        echo "9.1";
    }elseif ($pushUp >= '57') {
        echo "9.0";
    }elseif ($pushUp >= '56') {
        echo "8.9";
    }elseif ($pushUp >= '55') {
        echo "8.8";
    }elseif ($pushUp >= '54') {
        echo "8.8";
    }elseif ($pushUp >= '53') {
        echo "8.7";
    }elseif ($pushUp >= '52') {
        echo "8.6";
    }elseif ($pushUp >= '51') {
        echo "8.5";
    }elseif ($pushUp >= '50') {
        echo "8.4";
    }elseif ($pushUp >= '49') {
        echo "8.3";
    }elseif ($pushUp >= '48') {
        echo "8.1";
    }elseif ($pushUp >= '47') {
        echo "8.0";
    }elseif ($pushUp >= '46') {
        echo "7.8";
    }elseif ($pushUp >= '45') {
        echo "7.7";
    }elseif ($pushUp >= '44') {
        echo "7.5";
    }elseif ($pushUp >= '43') {
        echo "7.3";
    }elseif ($pushUp >= '42') {
        echo "7.2";
    }elseif ($pushUp >= '41') {
        echo "7.0";
    }elseif ($pushUp >= '40') {
        echo "6.8";
    }elseif ($pushUp >= '39') {
        echo "6.5";
    }elseif ($pushUp >= '38') {
        echo "6.3";
    }elseif ($pushUp >= '37') {
        echo "6.0";
    }elseif ($pushUp >= '36') {
        echo "5.8";
    }elseif ($pushUp >= '35') {
        echo "5.5";
    }elseif ($pushUp >= '34') {
        echo "5.3";
    }elseif ($pushUp >= '33') {
        echo "5.0";
    }
    else {

        echo "0";

    }
}


function malesLess40PushUps($pushUp)

{

//string value of score add to other componets

    if ($pushUp == 'Exempt') {
        echo "Exempt";
    }elseif ($pushUp == '0' OR '') {
        echo '';
    } elseif ($pushUp >= '57') {
        echo "10.0";
    } elseif ($pushUp >= '52') {
        echo "9.5";
    }elseif ($pushUp >= '51') {
        echo "9.4";
    }elseif ($pushUp >= '50') {
        echo "9.3";
    }elseif ($pushUp >= '49') {
        echo "9.2";
    }elseif ($pushUp >= '48') {
        echo "9.2";
    }elseif ($pushUp >= '47') {
        echo "9.1";
    }elseif ($pushUp >= '46') {
        echo "9.0";
    }elseif ($pushUp >= '45') {
        echo "8.9";
    }elseif ($pushUp >= '44') {
        echo "8.8";
    }elseif ($pushUp >= '43') {
        echo "8.7";
    }elseif ($pushUp >= '42') {
        echo "8.6";
    }elseif ($pushUp >= '41') {
        echo "8.5";
    }elseif ($pushUp >= '40') {
        echo "8.3";
    }elseif ($pushUp >= '39') {
        echo "8.0";
    }elseif ($pushUp >= '38') {
        echo "7.8";
    }elseif ($pushUp >= '37') {
        echo "7.7";
    }elseif ($pushUp >= '36') {
        echo "7.5";
    }elseif ($pushUp >= '35') {
        echo "7.3";
    }elseif ($pushUp >= '34') {
        echo "7.0";
    }elseif ($pushUp >= '33') {
        echo "6.8";
    }elseif ($pushUp >= '32') {
        echo "6.7";
    }elseif ($pushUp >= '31') {
        echo "6.5";
    }elseif ($pushUp >= '30') {
        echo "6.0";
    }elseif ($pushUp >= '29') {
        echo "5.5";
    }elseif ($pushUp >= '28') {
        echo "5.3";
    }elseif ($pushUp >= '27') {
        echo "5.0";
    }
    else {

        echo "0";

    }
}


function malesLess50PushUps($pushUp)

{

//string value of score add to other componets
    if ($pushUp == 'Exempt') {
        echo "Exempt";
    }elseif ($pushUp == '0' OR '') {
        echo '';
    }elseif ($pushUp >= '44') {
        echo "10.0";
    } elseif ($pushUp >= '39') {
        echo "9.5";
    }elseif ($pushUp >= '39') {
        echo "9.4";
    }elseif ($pushUp >= '37') {
        echo "9.4";
    }elseif ($pushUp >= '36') {
        echo "9.3";
    }elseif ($pushUp >= '35') {
        echo "9.3";
    }elseif ($pushUp >= '34') {
        echo "9.2";
    }elseif ($pushUp >= '33') {
        echo "9.2";
    }elseif ($pushUp >= '32') {
        echo "9.1";
    }elseif ($pushUp >= '31') {
        echo "9.1";
    }elseif ($pushUp >= '30') {
        echo "9.0";
    }elseif ($pushUp >= '29') {
        echo "8.8";
    }elseif ($pushUp >= '28') {
        echo "8.5";
    }elseif ($pushUp >= '27') {
        echo "8.3";
    }elseif ($pushUp >= '26') {
        echo "8.2";
    }elseif ($pushUp >= '25') {
        echo "8.0";
    }elseif ($pushUp >= '24') {
        echo "7.5";
    }elseif ($pushUp >= '23') {
        echo "7.3";
    }elseif ($pushUp >= '22') {
        echo "7.2";
    }elseif ($pushUp >= '21') {
        echo "7.0";
    }elseif ($pushUp >= '20') {
        echo "6.5";
    }elseif ($pushUp >= '19') {
        echo "6.0";
    }elseif ($pushUp >= '18') {
        echo "5.8";
    }elseif ($pushUp >= '17') {
        echo "5.5";
    }elseif ($pushUp >= '16') {
        echo "5.3";
    }elseif ($pushUp >= '15') {
        echo "5.0";
    }
    else {

        echo "0";

    }
}


function malesLess60PushUps($pushUp)

{

//string value of score add to other componets
    if ($pushUp == 'Exempt') {
        echo "Exempt";
    }elseif ($pushUp == '0' OR '') {
        echo '';
    }elseif  ($pushUp >= '44') {
        echo "10.0";
    }elseif ($pushUp >= '39') {
        echo "9.5";
    }elseif ($pushUp >= '39') {
        echo "9.4";
    }elseif ($pushUp >= '37') {
        echo "9.4";
    }elseif ($pushUp >= '36') {
        echo "9.3";
    }elseif ($pushUp >= '35') {
        echo "9.3";
    }elseif ($pushUp >= '34') {
        echo "9.2";
    }elseif ($pushUp >= '33') {
        echo "9.2";
    }elseif ($pushUp >= '32') {
        echo "9.1";
    }elseif ($pushUp >= '31') {
        echo "9.1";
    }elseif ($pushUp >= '30') {
        echo "9.0";
    }elseif ($pushUp >= '29') {
        echo "8.8";
    }elseif ($pushUp >= '28') {
        echo "8.5";
    }elseif ($pushUp >= '27') {
        echo "8.3";
    }elseif ($pushUp >= '26') {
        echo "8.2";
    }elseif ($pushUp >= '25') {
        echo "8.0";
    }elseif ($pushUp >= '24') {
        echo "7.5";
    }elseif ($pushUp >= '23') {
        echo "7.3";
    }elseif ($pushUp >= '22') {
        echo "7.2";
    }elseif ($pushUp >= '21') {
        echo "7.0";
    }elseif ($pushUp >= '20') {
        echo "6.5";
    }elseif ($pushUp >= '19') {
        echo "6.0";
    }elseif ($pushUp >= '18') {
        echo "5.8";
    }elseif ($pushUp >= '17') {
        echo "5.5";
    }elseif ($pushUp >= '16') {
        echo "5.3";
    }elseif ($pushUp >= '15') {
        echo "5.0";
    }
    else {

        echo "0";

    }
}


function males60PlusPushUps($pushUp)

{

//string value of score add to other componets
    if ($pushUp == 'Exempt') {
        echo "Exempt";
    }elseif ($pushUp == '0' OR '') {
        echo '';
    }elseif  ($pushUp >= '30') {
        echo "10.0";
    } elseif ($pushUp >= '28') {
        echo "9.5";
    }elseif ($pushUp >= '27') {
        echo "9.3";
    }elseif ($pushUp >= '26') {
        echo "9.0";
    }elseif ($pushUp >= '25') {
        echo "8.8";
    }elseif ($pushUp >= '24') {
        echo "8.5";
    }elseif ($pushUp >= '23') {
        echo "8.0";
    }elseif ($pushUp >= '22') {
        echo "7.5";
    }elseif ($pushUp >= '21') {
        echo "7.0";
    }elseif ($pushUp >= '20') {
        echo "6.5";
    }elseif ($pushUp >= '19') {
        echo "6.3";
    }elseif ($pushUp >= '18') {
        echo "6.0";
    }elseif ($pushUp >= '17') {
        echo "5.8";
    }elseif ($pushUp >= '16') {
        echo "5.5";
    }elseif ($pushUp >= '15') {
        echo "5.3";
    }elseif ($pushUp >= '14') {
        echo "5.0";
    }
    else {

        echo "0";

    }
}

////
///
////FEMALE Run Time 17-29
///


function femalesLess30($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif ($time == '0' OR '') {
        echo '';
    }elseif  ($time >= '04:00' && $time <= '10:32') {
        echo "60.0";
    } else if ($time >= '10:24' && $time <= '10:51') {
        echo "59.9";
    } else if ($time >= '10:52' && $time <= '11:06') {
        echo "59.5";
    } else if ($time >= '11:07' && $time <= '11:22') {
        echo "59.2";
    } else if ($time >= '11:23' && $time <= '11:38') {
        echo "58.9";
    } else if ($time >= '11:38' && $time <= '11:56') {
        echo "58.6";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "58.1";
    } else if ($time >= '12:15' && $time <= '12:33') {
        echo "57.6";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "57.0";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "56.2";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "55.3";
    } else if ($time >= '13:37' && $time <= '14:00') {
        echo "54.2";
    } else if ($time >= '14:01' && $time <= '14:25') {
        echo "52.8";
    } else if ($time >= '14:26' && $time <= '14:52') {
        echo "51.2Points";
    } else if ($time >= '14:53' && $time <= '15:20') {
        echo "49.3";
    } else if ($time >= '15:21' && $time <= '15:50') {
        echo "46.9";
    } else if ($time >= '15:51' && $time <= '16:22') {
        echo "44.1";
    }else {

        echo "0";

    }
}



////FEMALE Run Time 30-40
function femalesLess40($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif ($time == '0' OR '') {
        echo '';
    }elseif ($time >= '04:00' && $time <= '10:51') {
        echo "60.0";
    } else if ($time >= '10:52' && $time <= '11:22') {
        echo "59.5";
    } else if ($time >= '11:23' && $time <= '11:38') {
        echo "59.0";
    } else if ($time >= '11:39' && $time <= '11:56') {
        echo "58.6";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "58.1";
    } else if ($time >= '12:15' && $time <= '12:33') {
        echo "57.6";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "57.";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "56.2";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "55.3";
    } else if ($time >= '13:37' && $time <= '14:00') {
        echo "54.2";
    } else if ($time >= '14:01' && $time <= '14:25') {
        echo "52.8";
    } else if ($time >= '14:26' && $time <= '14:52') {
        echo "51.2Points";
    } else if ($time >= '14:53' && $time <= '15:20') {
        echo "49.3";
    } else if ($time >= '15:21' && $time <= '15:50') {
        echo "46.9";
    } else if ($time >= '15:51' && $time <= '16:22') {
        echo "44.1";
    } else if ($time >= '16:23' && $time <= '16:57') {
        echo "40.8";
    }else {

        echo "0";

    }
}

////FEMALE Run Time 40-50
function femalesLess50($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif ($time == '0' OR '') {
        echo '';
    }elseif ($time >= '04:00' && $time <= '11:22') {
        echo "60.0";
    } else if ($time >= '11:23' && $time <= '11:56') {
        echo "59.9";
    } else if ($time >= '11:57' && $time <= '12:14') {
        echo "59.8";
    } else if ($time >= '12:15' && $time <= '12:33') {
        echo "59.6";
    } else if ($time >= '12:34' && $time <= '12:53') {
        echo "59.4";
    } else if ($time >= '12:54' && $time <= '13:14') {
        echo "59.1";
    } else if ($time >= '13:15' && $time <= '13:36') {
        echo "58.7";
    } else if ($time >= '13:37' && $time <= '14:00') {
        echo "58.2";
    } else if ($time >= '14:01' && $time <= '14:25') {
        echo "57.7";
    } else if ($time >= '14:26' && $time <= '14:52') {
        echo "56.9";
    } else if ($time >= '14:53' && $time <= '15:20') {
        echo "56.0";
    } else if ($time >= '15:21' && $time <= '15:50') {
        echo "54.8";
    } else if ($time >= '15:51' && $time <= '16:22') {
        echo "53.3";
    } else if ($time >= '16:23' && $time <= '16:57') {
        echo "51.4";
    } else if ($time >= '16:58' && $time <= '17:34') {
        echo "49.0";
    } else if ($time >= '17:34' && $time <= '18:14') {
        echo "45.9";
    }

    else {

        echo "0";

    }
}

////FEMALE Run Time 50-60
function femalesLess60($time)
{

//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif ($time == '0' OR '') {
        echo '';
    }elseif ($time >= '04:00' && $time <= '12:53') {
        echo "60.0";
    } else if ($time >= '12:54' && $time <= '13:36') {
        echo "59.8";
    } else if ($time >= '13:37' && $time <= '14:00') {
        echo "59.6";
    }  else if ($time >= '14:01' && $time <= '14:25') {
        echo "59.6";
    } else if ($time >= '14:26' && $time <= '14:52') {
        echo "59.3";
    } else if ($time >= '14:53' && $time <= '15:20') {
        echo "58.9";
    } else if ($time >= '15:21' && $time <= '15:50') {
        echo "58.4";
    } else if ($time >= '15:51' && $time <= '16:22') {
        echo "57.7";
    } else if ($time >= '16:23' && $time <= '16:57') {
        echo "56.8";
    } else if ($time >= '16:58' && $time <= '17:34') {
        echo "55.6";
    }  else if ($time >= '17:34' && $time <= '18:14') {
        echo "54.0";
    }  else if ($time >= '18:15' && $time <= '18:56') {
        echo "51.9";
    }  else if ($time >= '18:57' && $time <= '19:43') {
        echo "49.2";
    } else if ($time >= '17:34' && $time <= '18:14') {
        echo "45.9";
    }else {

        echo "0";

    }
}

////FEMALE Run Time +60
function femalesLess60Plus($time)
{


//string value of score add to other componets
    if ($time == 'Exempt') {
        echo "Exempt";
    }elseif ($time == '0' OR '') {
        echo '';
    }elseif ($time >= '04:00'  && $time <= '14:00') {
        echo "60.0";
    } else if ($time >= '14:01' && $time <= '14:52') {
        echo "59.8";
    } else if ($time >= '14:53' && $time <= '15:20') {
        echo "59.5";
    } else if ($time >= '15:21' && $time <= '15:50') {
        echo "59.1";
    } else if ($time >= '15:51' && $time <= '16:22') {
        echo "58.6";
    } else if ($time >= '16:23' && $time <= '16:57') {
        echo "57.9";
    } else if ($time >= '16:58' && $time <= '17:34') {
        echo "57.0";
    }  else if ($time >= '17:34' && $time <= '18:14') {
        echo "55.8";
    }  else if ($time >= '18:15' && $time <= '18:56') {
        echo "54.2";
    }  else if ($time >= '18:57' && $time <= '19:43') {
        echo "52.1";
    } else if ($time >= '19:44' && $time <= '20:33') {
        echo "49.3";
    } else if ($time >= '20:34' && $time <= '21:28') {
        echo "45.6";
    } else if ($time >= '21:29' && $time <= '22:38') {
        echo "40.8";
    }else {
        echo "0";
    }
}



function malesLess30sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '58') {
        echo "10.0";
    }elseif ($sitUp >= '55') {
        echo "9.5";
    }elseif ($sitUp >= '54') {
        echo "9.4";
    }elseif ($sitUp >= '53') {
        echo "9.2";
    }elseif ($sitUp >= '52') {
        echo "9.0";
    }elseif ($sitUp >= '51') {
        echo "8.8";
    }elseif ($sitUp >= '50') {
        echo "8.7";
    } elseif ($sitUp >= '49') {
        echo "8.5";
    }elseif ($sitUp >= '48') {
        echo "8.3";
    }elseif ($sitUp >= '47') {
        echo "8.0";
    }elseif ($sitUp >= '46') {
        echo "7.5";
    }elseif ($sitUp >= '45') {
        echo "7.0";
    }elseif ($sitUp >= '44') {
        echo "6.5";
    }elseif ($sitUp >= '43') {
        echo "6.3";
    }elseif ($sitUp >= '42') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}
function malesLess40sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '54') {
        echo "10.0";
    }elseif ($sitUp >= '51') {
        echo "9.5";
    }elseif ($sitUp >= '50') {
        echo "9.4";
    }elseif ($sitUp >= '49') {
        echo "9.2";
    }elseif ($sitUp >= '48') {
        echo "9.0";
    }elseif ($sitUp >= '47') {
        echo "8.8";
    }elseif ($sitUp >= '46') {
        echo "8.7";
    } elseif ($sitUp >= '45') {
        echo "8.5";
    }elseif ($sitUp >= '44') {
        echo "8.3";
    }elseif ($sitUp >= '43') {
        echo "8.0";
    }elseif ($sitUp >= '42') {
        echo "7.5";
    }elseif ($sitUp >= '41') {
        echo "7.0";
    }elseif ($sitUp >= '40') {
        echo "6.5";
    }elseif ($sitUp >= '39') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}

function malesLess50sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '50') {
        echo "10.0";
    }elseif ($sitUp >= '47') {
        echo "9.5";
    }elseif ($sitUp >= '46') {
        echo "9.4";
    }elseif ($sitUp >= '45') {
        echo "9.2";
    }elseif ($sitUp >= '44') {
        echo "9.1";
    }elseif ($sitUp >= '43') {
        echo "9.0";
    }elseif ($sitUp >= '42') {
        echo "8.8";
    } elseif ($sitUp >= '41') {
        echo "8.7";
    }elseif ($sitUp >= '40') {
        echo "8.5";
    }elseif ($sitUp >= '39') {
        echo "8.0";
    }elseif ($sitUp >= '38') {
        echo "7.8";
    }elseif ($sitUp >= '37') {
        echo "7.5";
    }elseif ($sitUp >= '36') {
        echo "7.0";
    }elseif ($sitUp >= '35') {
        echo "6.5";
    }elseif ($sitUp >= '34') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}


function malesLess60sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '46') {
        echo "10.0";
    }elseif ($sitUp >= '43') {
        echo "9.5";
    }elseif ($sitUp >= '42') {
        echo "9.4";
    }elseif ($sitUp >= '41') {
        echo "9.2";
    }elseif ($sitUp >= '40') {
        echo "9.1";
    }elseif ($sitUp >= '39') {
        echo "9.0";
    }elseif ($sitUp >= '38') {
        echo "8.8";
    } elseif ($sitUp >= '37') {
        echo "8.7";
    }elseif ($sitUp >= '36') {
        echo "8.5";
    }elseif ($sitUp >= '35') {
        echo "8.0";
    }elseif ($sitUp >= '34') {
        echo "7.8";
    }elseif ($sitUp >= '33') {
        echo "7.5";
    }elseif ($sitUp >= '32') {
        echo "7.3";
    }elseif ($sitUp >= '31') {
        echo '7.0';
    }elseif ($sitUp >= '30') {
        echo "6.5";
    }elseif ($sitUp >= '29') {
        echo "6.3";
    }elseif ($sitUp >= '28') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}


function malesOver60sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '42') {
        echo "10.0";
    }elseif ($sitUp >= '38') {
        echo "9.5";
    }elseif ($sitUp >= '37') {
        echo "9.4";
    }elseif ($sitUp >= '36') {
        echo "9.2";
    }elseif ($sitUp >= '35') {
        echo "9.1";
    }elseif ($sitUp >= '34') {
        echo "9.0";
    }elseif ($sitUp >= '33') {
        echo "8.9";
    } elseif ($sitUp >= '32') {
        echo "8.8";
    }elseif ($sitUp >= '31') {
        echo "8.6";
    }elseif ($sitUp >= '30') {
        echo "8.0";
    }elseif ($sitUp >= '29') {
        echo "7.8";
    }elseif ($sitUp >= '28') {
        echo "7.5";
    }elseif ($sitUp >= '27') {
        echo "7.3";
    }elseif ($sitUp >= '26') {
        echo "7.0";
    }elseif ($sitUp >= '25') {
        echo "6.8";
    }elseif ($sitUp >= '24') {
        echo "6.5";
    }elseif ($sitUp >= '23') {
        echo "6.3";
    }elseif ($sitUp >= '22') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}



function femalesLess30sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '54') {
        echo "10.0";
    }elseif ($sitUp >= '51') {
        echo "9.5";
    }elseif ($sitUp >= '50') {
        echo "9.4";
    }elseif ($sitUp >= '49') {
        echo "9.0";
    }elseif ($sitUp >= '48') {
        echo "8.9";
    }elseif ($sitUp >= '47') {
        echo "8.8";
    }elseif ($sitUp >= '46') {
        echo "8.6";
    } elseif ($sitUp >= '45') {
        echo "8.5";
    }elseif ($sitUp >= '44') {
        echo "8.0";
    }elseif ($sitUp >= '43') {
        echo "7.8";
    }elseif ($sitUp >= '42') {
        echo "7.5";
    }elseif ($sitUp >= '41') {
        echo "7.0";
    }elseif ($sitUp >= '40') {
        echo "6.8";
    }elseif ($sitUp >= '39') {
        echo "6.5";
    }elseif ($sitUp >= '38') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}
function femalesLess40sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '45') {
        echo "10.0";
    }elseif ($sitUp >= '42') {
        echo "9.5";
    }elseif ($sitUp >= '41') {
        echo "9.4";
    }elseif ($sitUp >= '40') {
        echo "9.0";
    }elseif ($sitUp >= '39') {
        echo "8.8";
    }elseif ($sitUp >= '38') {
        echo "8.5";
    }elseif ($sitUp >= '37') {
        echo "8.3";
    } elseif ($sitUp >= '36') {
        echo "8.2";
    }elseif ($sitUp >= '35') {
        echo "8.0";
    }elseif ($sitUp >= '34') {
        echo "7.8";
    }elseif ($sitUp >= '33') {
        echo "7.5";
    }elseif ($sitUp >= '32') {
        echo "7.0";
    }elseif ($sitUp >= '31') {
        echo "6.8";
    }elseif ($sitUp >= '30') {
        echo "6.5";
    }elseif ($sitUp >= '29') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}

function femalesLess50sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '41') {
        echo "10.0";
    }elseif ($sitUp >= '38') {
        echo "9.5";
    }elseif ($sitUp >= '37') {
        echo "9.4";
    }elseif ($sitUp >= '36') {
        echo "9.2";
    }elseif ($sitUp >= '35') {
        echo "9.1";
    }elseif ($sitUp >= '34') {
        echo "9.0";
    }elseif ($sitUp >= '33') {
        echo "8.8";
    } elseif ($sitUp >= '32') {
        echo "8.5";
    }elseif ($sitUp >= '31') {
        echo "8.3";
    }elseif ($sitUp >= '30') {
        echo "8.2";
    }elseif ($sitUp >= '29') {
        echo "8.0";
    }elseif ($sitUp >= '28') {
        echo "7.5";
    }elseif ($sitUp >= '27') {
        echo "7.0";
    }elseif ($sitUp >= '26') {
        echo "6.8";
    }elseif ($sitUp >= '25') {
        echo "6.4";
    }elseif ($sitUp >= '24') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}


function femalesLess60sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '32') {
        echo "10.0";
    }elseif ($sitUp >= '30') {
        echo "9.5";
    }elseif ($sitUp >= '29') {
        echo "9.0";
    }elseif ($sitUp >= '28') {
        echo "8.9";
    }elseif ($sitUp >= '27') {
        echo "8.8";
    }elseif ($sitUp >= '26') {
        echo "8.6";
    }elseif ($sitUp >= '25') {
        echo "8.5";
    } elseif ($sitUp >= '24') {
        echo "8.0";
    }elseif ($sitUp >= '23') {
        echo "7.5";
    }elseif ($sitUp >= '22') {
        echo "7..0";
    }elseif ($sitUp >= '21') {
        echo "6.5";
    }elseif ($sitUp >= '20') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}


function femalesOver60sitUps($sitUp)

{

//string value of score add to other componets
    if ($sitUp == 'Exempt') {
        echo "Exempt";
    }elseif ($sitUp == '0' OR '') {
        echo '';
    }elseif ($sitUp >= '31') {
        echo "10.0";
    }elseif ($sitUp >= '28') {
        echo "9.5";
    }elseif ($sitUp >= '27') {
        echo "9.4";
    }elseif ($sitUp >= '26') {
        echo "9.0";
    }elseif ($sitUp >= '25') {
        echo "8.9";
    }elseif ($sitUp >= '24') {
        echo "8.8";
    }elseif ($sitUp >= '23') {
        echo "8.7";
    } elseif ($sitUp >= '22') {
        echo "8.6";
    }elseif ($sitUp >= '21') {
        echo "8.5";
    }elseif ($sitUp >= '20') {
        echo "8.4";
    }elseif ($sitUp >= '19') {
        echo "8.3";
    }elseif ($sitUp >= '18') {
        echo "8.2";
    }elseif ($sitUp >= '17') {
        echo "8.0";
    }elseif ($sitUp >= '16') {
        echo "7.8";
    }elseif ($sitUp >= '15') {
        echo "7.5";
    }elseif ($sitUp >= '14') {
        echo "7.3";
    }elseif ($sitUp >= '13') {
        echo "7.0";
    }elseif ($sitUp >= '12') {
        echo "6.5";
    }elseif ($sitUp >= '11') {
        echo "6.0";
    }
    else {

        echo "0";

    }
}