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

    $internet_use_result = 0.0;

	
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	if($connection->connect_error) {
		die("$connection->connect_errno: $connection->connect_error");
	}

	$stmt = $connection->stmt_init();
	if(!$stmt->prepare("SELECT OncePerDay, OncePerWeek, OncePerMonth, LessThanMonth FROM InternetUse WHERE Year = 2009 AND AgeRange_Lower <= ? AND AgeRange_Higher >= ? AND AgeRange_Higher != 100"))
	{
		print("Failed to prepare statement\n");
	}
    else {
        $stmt->bind_param("ii", intval($age), intval($age));
        $stmt->execute();

        $stmt->bind_result($onceperday, $onceperweek, $oncepermonth, $lessthanmonth);

        $stmt->fetch();

        switch($internet_use) {
            case "once-per-day":
                $internet_use_result = floatval($onceperday);
                break;
            case "once-per-week":
                $internet_use_result = floatval($onceperweek);
                break;
            case "once-per-month":
                $internet_use_result = floatval($oncepermonth);
                break;
            case "less-per-month":
                $internet_use_result = floatval($lessthanmonth);
                break;
            default:
                $internet_use_result = -1.0;
        }

        echo "You are similar to " . $internet_use_result . "% of Canadians!";

        $stmt->close();

    }

?>