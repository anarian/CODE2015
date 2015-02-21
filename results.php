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

    function getInternetUse($connection, $age, $internet_use)
    {
        $stmt = $connection->stmt_init();

        switch($internet_use) {
            case "once-per-day":
                $stmt->prepare("SELECT OncePerDay
                                FROM InternetUse
                                WHERE Year = 2009
                                  AND AgeRange_Lower <= ?
                                  AND AgeRange_Higher >= ?
                                  AND AgeRange_Higher != 100");
                break;
            case "once-per-week":
                $stmt->prepare("SELECT OncePerWeek
                                FROM InternetUse
                                WHERE Year = 2009
                                  AND AgeRange_Lower <= ?
                                  AND AgeRange_Higher >= ?
                                  AND AgeRange_Higher != 100");
                break;
            case "once-per-month":
                $stmt->prepare("SELECT OncePerMonth
                                FROM InternetUse
                                WHERE Year = 2009
                                  AND AgeRange_Lower <= ?
                                  AND AgeRange_Higher >= ?
                                  AND AgeRange_Higher != 100");
                break;
            case "less-than-month":
                $stmt->prepare("SELECT LessThanMonth
                                FROM InternetUse
                                WHERE Year = 2009
                                  AND AgeRange_Lower <= ?
                                  AND AgeRange_Higher >= ?
                                  AND AgeRange_Higher != 100");
                break;
        }

        $stmt->bind_param("ii", intval($age), intval($age));
        $stmt->execute();

        $result = -1.0;
        $stmt->bind_result($result);
        $stmt->fetch();

        $stmt->close();
        return floatval($result);
    }

    function returnBMI($height, $weight) {
        return $weight/($height * $height);
    }

    function internetUseText($internet_use) {
        switch($internet_use) {
            case "once-per-day":
                return "at least once per day";
            case "once-per-week":
                return "at least once per week";
            case "once-per-month":
                return "at least once per month";
            case "less-per-month":
                return "less than once per month";
        }
    }

    function parseGender($gender) {
        return $gender == "Male" ? "male" : "female";
    }

    function getSelfHealth($self_rate) {
        switch($self_rate) {
            case "PoorFair":
                return "poor or fair";
            case "Good":
                return "good";
            case "VGood":
                return "very good";
            case "Excellent":
                return "excellent";
        }
    }

?>

<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?>
    </head>
    <body>
        <?php include("header.php"); ?>

        <div id="content">
            <section class="intro">
                <br />
                <p>You are a <?=$age?> year old <?=parseGender($gender)?>.</p>
                <?php if($height != "" && $weight != "") echo "<p>From your data, your BMI is "
                    . number_format(returnBMI($height, $weight),2) . ", which is //TODO: Get stat here//.</p>" ?>
                <?php if($self_rate != "") echo "<p>You rated your health as being " .
                    getSelfHealth($self_rate) . ". This is the same as //TODO: Get stat here//.</p>" ?>
                <?php if($internet_use != "") echo "<p>Your internet use is " .
                    internetUseText($internet_use) . " which is similar to " .
                    number_format(getInternetUse($connection, $age, $internet_use),1) .
                    "% of Canadians around your age. </p>" ?>
                <?php if($height == "" && $self_rate == "" && $weight == "" && $internet_use == "")
                    echo "You haven't provided any other information. If you're concerned about your data privacy,
                    this website does not store any data that is provided.\n";
                    echo "<a href='/'>Go back</a>";
                ?>
            </section>
        </div>

        <?php include("footer.php");?>

    </body>

</html>