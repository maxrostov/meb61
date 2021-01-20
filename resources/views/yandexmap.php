<?php
// получение точной широты и долготы по адресу, записываем в базу
// вывода на сайте карты с ""примерными" координатами (вносим случайные помехи)
include '../php/_connect.php';
include '../php/utils.php';

  $q = "SELECT object_id, city, region_id, street_id, dom_num
FROM object
LEFT JOIN spr_city ON object.city_id=spr_city.city_id
 WHERE coord IS NULL
ORDER BY object_id DESC
LIMIT 100";

//echo $result = myq($q);
	$result = mysqli_query($dbh,$q) or die($q.'~~'.mysqli_error($dbh));
print_r($result);

// собственно вывод
while($arr = mysqli_fetch_array($result)){

echo $addr = "${arr[city]}, ${arr[street_id]}, ${arr[dom_num]}";
//echo $url = "https://geocode-maps.yandex.ru/1.x/?geocode=$addr";
$url = "http://search.maps.sputnik.ru/search?q=$addr";

$responce = file_get_contents($url);
$pattern = '/<pos>(.+)<\/pos>/';
preg_match($pattern, $responce, $matches);
echo $coord = $matches[1];

echo $q = "UPDATE object SET coord='$coord' WHERE object_id=${arr[object_id]}";
echo '<br>';
$result2 = myq($q);

}
