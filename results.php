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
	if(!$stmt->prepare("SELECT * FROM `InternetUse` WHERE `Year` = 2009 AND `AgeRange_Lower`<= ? AND `AgeRange_Higher`>= ?"))
	{
		print("Failed to prepare statement\n");
	}
	$stmt->bind_param("ss", $age, $age);
	$stmt->execute();
	
	echo "Success!";
	
	$result = $stmt->get_result();
	
	while ($row = $result->fetch_array(MYSQLI_NUM))
        {
            foreach ($row as $r)
            {
                print "$r ";
            }
            print "\n";
        }
?>