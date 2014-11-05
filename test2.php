<!DOCTYPE html>
<html>
<head>


</head>



<body>

   <p style ="padding-bottom:30px;"> <font size="5">
   Search results through NutritionIX API:
   </font>

   </p>

<?php


$product = $_POST["product"]; //pulls value from input field named “product” in mpage.php 

echo("Results for search on: $product <br><br>");
$data = array("appId" => "d12a57b3",
   "appKey" => "bceef6d810bc035aaad8d4bd349f02b5",
   "query" => "$product",
   "fields" => ["item_name","brand_name", "score", "nf_calories", "item_type"],
   "sort" => ["field" => "_score",
               "order"=> "desc"],
   "filters" => ["item_type"=> "3"]);




$data_string = json_encode($data);

$ch = curl_init('http://api.nutritionix.com/v1_1/search');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
       'Content-Type: application/json',
       'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);
curl_close($ch);
#var_dump(json_decode($result, true));
$x = json_decode($result, true);
foreach( $x["hits"] as $name)
{
   echo($name["fields"]["item_name"]."<br>");
   echo($name["fields"]["brand_name"]."<br>");
   echo( $name["fields"]["nf_calories"]." Calories"."<br>"."<br>");
}



?>

</body>
</html>