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

    function getInternetUse($connection, $age)
    {
        $InternetDataStmt = $connection->stmt_init();
        $InternetDataStmt->prepare("SELECT OncePerDay, OncePerWeek, OncePerMonth, LessThanMonth, NotSpecified
                                        FROM InternetUse
                                        WHERE Year = 2009
                                          AND AgeRange_Lower <= ?
                                          AND AgeRange_Higher >= ?
                                          AND AgeRange_Higher != 100");

        $InternetDataStmt->bind_param("ii", intval($age), intval($age));
        $InternetDataStmt->execute();

        $OncePerDayResult = 0;
        $OncePerWeekResult = 0;
        $OncePerMonthResult = 0;
        $LessThanMonthResult = 0;
        $NotSpecified = 0;

        $InternetDataStmt->bind_result($OncePerDayResult, $OncePerWeekResult, $OncePerMonthResult, $LessThanMonthResult, $NotSpecified);
        $InternetDataStmt->fetch();

        $InternetDataStmt->close();

        return array ($OncePerDayResult,$OncePerMonthResult, $OncePerWeekResult, $LessThanMonthResult, $NotSpecified);
    }

    function getSelfHealthData($connection, $age, $gender)
    {
        $sex = $gender == "Male" ? 'M' : 'F';
        $SelfHealthStmt = $connection->stmt_init();
        $SelfHealthStmt->prepare("SELECT ExcelPerc,VGPerc,GoodPerc,ForPPerc
                                  FROM SelfHealth
                                  WHERE Sex = ?
                                    AND AgeRangeLow <= ?
                                    AND AgeRangeHigh >= ?
                                    AND AgeRangeHigh != 100
                                    AND Location = 'Canada'
                                    ORDER BY AgeRangeLow DESC");

        $SelfHealthStmt->bind_param("sii", $sex, intval($age), intval($age));
        $SelfHealthStmt->execute();

        $ExcellentResult = 0;
        $VeryGoodResult = 0;
        $GoodResult = 0;
        $FairResult = 0;

        $SelfHealthStmt->bind_result($ExcellentResult, $VeryGoodResult, $GoodResult, $FairResult);
        $SelfHealthStmt->fetch();
        $SelfHealthStmt->close();

        return array ($ExcellentResult, $VeryGoodResult, $GoodResult, $FairResult);
    }

    function getBMIData($connection, $age, $gender)
    {
        $sex = $gender == "Male" ? "M" : "F";
        $BMIStmt = $connection->stmt_init();
        $BMIStmt->prepare("SELECT UnderPerc,NormalPerc,SomePerc,OverPerc,NotPerc
                                  FROM AdultBMI
                                  WHERE Sex = ?
                                    AND AgeRangeLow <= ?
                                    AND AgeRangeHigh >= ?
                                    AND AgeRangeHigh != 100
                                    AND Location = 'Canada'
                                    ORDER BY TotalNum");

        $BMIStmt->bind_param("sii", $sex, intval($age), intval($age));
        $BMIStmt->execute();

        $UnderNum = 0;
        $NormalNum = 0;
        $SomeNum = 0;
        $OverNum = 0;
        $NotNum = 0;

        $BMIStmt->bind_result($UnderNum, $NormalNum, $SomeNum, $OverNum, $NotNum);
        $BMIStmt->fetch();
        $BMIStmt->close();

        return array ($UnderNum, $NormalNum, $SomeNum, $OverNum, $NotNum);
    }


    function getInternetUseValue($internet_use, $data)
    {

        switch($internet_use)
        {
            case "once-per-day":
                return $data[0];
            case "once-per-week":
                return $data[1];
            case "once-per-month":
                return $data[2];
            case "less-per-month":
                return $data[3];
        }
    }

    function getSelfHealthValue($self_rate, $data)
    {
        switch($self_rate)
        {
            case "Excellent":
                return $data[0];
            case "VGood":
                return $data[1];
            case "Good":
                return $data[2];
            case "PoorFair":
                return $data[3];
        }
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

    function returnBMItype($bmi) {
        switch($bmi)
        {
            case $bmi < 20.0:
                return "underweight";
            case $bmi < 24.9:
                return "a normal weight";
            case $bmi < 27.0:
                return "slightly overweight";
            case $bmi >= 27.0:
                return "overweight";
        }
    }

    function getBMIPercent($bmi, $bmidata) {
        switch($bmi)
        {
            case $bmi < 20.0:
                return $bmidata[0];
            case $bmi < 24.9:
                return $bmidata[1];
            case $bmi < 27.0:
                return $bmidata[2];
            case $bmi >= 27.0:
                return $bmidata[3];
        }
    }

$internet_use_data = getInternetUse($connection, $age);
$self_health_data = getSelfHealthData($connection, $age, $gender);
$bmi_data = getBMIData($connection, $age, $gender);

?>

<!doctype html>
<html>
    <head>
        <?php include("head.php"); ?>
        <title>Results - CanLife</title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawInternetChart);
            google.setOnLoadCallback(drawBMIChart);
            google.setOnLoadCallback(drawSelfHealthChart);
            function drawBMIChart() {
                var data = google.visualization.arrayToDataTable([
                    <?php
                        printf("
                            ['BMI', 'Percent'],
                            ['Underweight', %s],
                            ['Normal weight', %s],
                            ['Slightly overweight', %s],
                            ['Overweight', %s]
                        ", $bmi_data[0], $bmi_data[1], $bmi_data[2], $bmi_data[3]);
                    ?>
                ]);

                var options = {
                    title: 'BMI Across Canada',
                    pieHole: 0.4,
                    chartArea: {
                        width: 375,
                        height: 375,
                        top: 25
                    }
            };

            var chart = new google.visualization.PieChart(document.getElementById('BMIDonut'));
            chart.draw(data,options);
            }

            function drawInternetChart() {
                var data = google.visualization.arrayToDataTable([
                    <?php
                        printf("
                            ['Frequency', 'Percent'],
                            ['At least once per day', %s],
                            ['At least once per week', %s],
                            ['At least once per month', %s],
                            ['Less than once a month', %s],
                            ['Not specified', %s]
                        ", $internet_use_data[0], $internet_use_data[1], $internet_use_data[2], $internet_use_data[3], $internet_use_data[4]);
                     ?>
                ]);

                var options = {
                    title: 'Internet Use Across Canada',
                    pieHole: 0.4,
                    chartArea: {
                        width: 375,
                        height: 375,
                        top: 25
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('InternetDonut'));
                chart.draw(data,options);
            }

            function drawSelfHealthChart() {
                var data = google.visualization.arrayToDataTable([
                    <?php
                        printf("
                            ['Rating', 'Percent'],
                            ['Excellent', %s],
                            ['Very Good', %s],
                            ['Good', %s],
                            ['Fair or Poor', %s],
                        ", $self_health_data[0], $self_health_data[1], $self_health_data[2], $self_health_data[3]);
                     ?>
                ]);

                var options = {
                    title: 'Self-Rated Health Across Canada',
                    pieHole: 0.4,
                    chartArea: {
                        width: 375,
                        height: 375,
                        top: 25
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('SelfHealthDonut'));
                chart.draw(data,options);
            }

        </script>
    </head>
    <body>
        <?php include("header.php"); ?>

        <div id="content">
            <section class="intro">
                <br />
                <p>You are a <?=$age?> year old <?=parseGender($gender)?>.</p>
                <?php if($height != "" && $weight != "") {
                    $bmi = returnBMI($height, $weight);
                    echo "<section class='row'>
                        <div class='col'>
                            <p>From your data, your BMI is "
                        . number_format($bmi, 2) .
                        ", which is " . returnBMItype($bmi) . ". " . getBMIPercent($bmi, $bmi_data) ."% of
                        Canadians are also " . returnBMItype($bmi) . ". </p>
                        </div>
                        <div class='col'>
                            <div id='BMIDonut' style='width:400px; height:400px;'></div>
                        </div>
                    </section>";
                    }
                ?>
                <?php if($self_rate != "") {
                    echo "
                    <section class='row'>
                        <div class='col'>
                            <p>You rated your health as being " .
                        getSelfHealth($self_rate) .
                        ". This is the same as " . getSelfHealthValue($self_rate, $self_health_data) .
                        "% of the population.</p>
                        </div>
                        <div class='col'>
                            <div id='SelfHealthDonut' style='width=400px; height=400px;'></div>
                        </div>
                    </section>";
                }
                ?>
                <?php if($internet_use != "") {
                    echo "
                    <section class='row'>
                        <div class='col'>
                            <p>Your internet use is " .
                        internetUseText($internet_use) . " which is similar to " .
                        number_format(getInternetUseValue($internet_use, $internet_use_data)) .
                        "% of Canadians around your age. </p>
                        </div>
                        <div class='col'>
                            <div id='InternetDonut' style='width:400px; height:400px;'></div>
                        </div>
                    </section>";
                    }
                ?>
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