<?php
$jsonurl = "http://dev.virtualearth.net/REST/v1/Locations/43.6504473,-79.38392619999999?includeEntityTypes=Postcode1&includeNeighborhood=0&include=includeValue&key=AtTgMeGeeWAzAa0pjP1Qu32IdYVz8nhogrKzXH7gCZnIhZpiSvhDVcWvUKwH_FfT";
$json = file_get_contents($jsonurl);
var_dump(json_decode($json));
?>