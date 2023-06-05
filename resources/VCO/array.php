<?php

$default = array("ESS,GTC,GPC,Fitness,Supply,VCO");
echo is_array($default) ? 'array' : 'is not array';


//defualt list

//current list of access
$array = "ESS,GTC,GPC,Fitness,Supply,VCO,ABC,Other";


$array = explode(',', $array);

//adding access
$addAccess = " ATO; INFOSEC";
$addAccessArray = explode(';', rtrim(ltrim($addAccess)));

//trim data
for ($i=0; $i < count($addAccessArray); $i++) {
  array_push($array, rtrim(ltrim("$addAccessArray[$i]")));
}

//<br>_______Items to remove________<br>";
$removeAccess = "ESS; ATO; ABC; This";

//get all inputs from form and make an array with the data 1 to n.
$removeAccessArray = explode(';', $removeAccess);
$newRemoveArray= array();

for ($i=0; $i < count($removeAccessArray); $i++) {
  array_push($newRemoveArray, rtrim(ltrim("$removeAccessArray[$i]")));
}

foreach ($newRemoveArray as $key => $value) {
  if (in_array($key, $default)) {
    unset($newRemoveArray[$key]);
  }
}
//_______remove permissions________
foreach ($array as $key => $value) {
  if (in_array($value, $newRemoveArray)) {
    unset($array[$key]);
  }
}
echo "<br><br>_______new access listing permissions________<br>";
foreach ($array as $key => $value) {
  echo $value."<br>";
}
