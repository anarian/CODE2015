<?php

	$servername = "localhost";
	$username = "jonabnbb_code";
	$password = "code2015";
	$dbname = "jonabnbb_code";

	$age = $_POST["age"];
	$gender = $_POST["gender"];
	$height = $_POST["height"];
	$weight = $_POST["weight"];
	$self_rate = $_POST["self-rate"];
	$internet_use = $_POST["internet-use"];
	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if($connection->connect_error) {
		die("$connection->connect_errno: $connection->connect_error");
	}
	
	$stmt = $connection->stmt_init();
	if(!$stmt->prepare("SELECT OncePerDay, OncePerWeek, OncePerMonth, LessThanMonth FROM InternetUse WHERE Year = 2009 AND AgeRange_Lower <= ? AND AgeRange_Higher >= ?"))
	{
		print("Failed to prepare statement\n");
	}
    else {
        $stmt->bind_param("ii", intval($age), intval($age));
        $stmt->execute();

        $stmt->bind_result($onceperday, $onceperweek, $oncepermonth, $lessthanmonth);

        while($stmt->fetch()) {
            printf("%s %s %s %s\n", $onceperday, $onceperweek, $oncepermonth, $lessthanmonth);
        }

        $stmt->close();

    }

?>