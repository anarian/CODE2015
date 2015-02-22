<?php
    require('key.php');

    $age = $_POST["age"];
	$gender = $_POST["gender"];
	$height = $_POST["height"];
	$weight = $_POST["weight"];
	$self_rate = $_POST["self-rate"];
	$internet_use = $_POST["internet-use"];
    $smoking = $_POST["smoking"];
    $latitude = $_POST["geoLat"];
    $longitude = $_POST["geoLong"];

    $jsonObject = null;

	$connection = new mysqli($servername, $username, $password, $dbname);

    if($latitude != "" && $longitude != "" && $latitude != 0 && $longitude != 0) {
        $jsonurl = "http://dev.virtualearth.net/REST/v1/Locations/" . $latitude . "," . $longitude . "?includeEntityTypes=Postcode1&includeNeighborhood=0&include=includeValue&key=AtTgMeGeeWAzAa0pjP1Qu32IdYVz8nhogrKzXH7gCZnIhZpiSvhDVcWvUKwH_FfT";
        $json = file_get_contents($jsonurl);

        $jsonObject = json_decode($json);
    }


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

    function getSmokeData($connection, $age, $gender)
    {
        $sex = $gender == "Male" ? "M" : "F";
        $BMIStmt = $connection->stmt_init();
        $BMIStmt->prepare("SELECT DailyPerc,OccPerc,FormerPerc,NeverPerc,NotPerc
                                      FROM Smoking
                                      WHERE Sex = ?
                                        AND AgeRangeLow <= ?
                                        AND AgeRangeHigh >= ?
                                        AND AgeRangeHigh != 100
                                        AND Location = 'Canada'
                                        ORDER BY TotalNum");

        $BMIStmt->bind_param("sii", $sex, intval($age), intval($age));
        $BMIStmt->execute();

        $UnderNum = 0;
        $DailyNum = 0;
        $OccasionalNum = 0;
        $NeverNum = 0;
        $NotNum = 0;

        $BMIStmt->bind_result($UnderNum, $DailyNum, $OccasionalNum, $NeverNum, $NotNum);
        $BMIStmt->fetch();
        $BMIStmt->close();

        return array ($UnderNum, $DailyNum, $OccasionalNum, $NeverNum, $NotNum);
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

    function getSmokeText($smoke) {
        switch($smoke) {
            case "never" :
                return "have never smoked";
            case "former":
                return "used to smoke";
            case "occasional":
                return "occasionally smoke";
            case "daily":
                return "smoke everyday";
        }
    }

    function getSmokePercent($smoke, $smoke_data) {
        switch($smoke) {
            case "never" :
                return $smoke_data[0];
            case "former":
                return $smoke_data[1];
            case "occasional":
                return $smoke_data[2];
            case "daily":
                return $smoke_data[3];
        }
    }

    function get_activity() {
	$tasks = array(array("outdoor+parks", "visiting a park"), 
			array("pools","swimming"), 
			array("skating+rinks", "skating"), 
			array("gyms", "working out"), 
			array("provincial+parks", "camping"), 
			array("soccer+field", "playing soccer"), 
			array("hiking", "hiking"), 
			array("recreation+centre", "joining a community centre"));
        $rand_key = array_rand($tasks);
	return $tasks[$rand_key];
    }

$task_data = get_activity();
$internet_use_data = getInternetUse($connection, $age);
$self_health_data = getSelfHealthData($connection, $age, $gender);
$bmi_data = getBMIData($connection, $age, $gender);
$smoke_data = getSmokeData($connection, $age, $gender);

    function getQuote() {
        $items = array (
            "Egg whites are a great source of protein!",
            "Did you know all of an egg's fat is in the yolk?",
            "2 fried eggs for breakfast provides 12 grams of protein!",
            "Hard boiled eggs are low-fat source of protein.",
            "Enjoy these on toast for a healthy breakfast!",
            "Eggs benedict with a side of bacon... Mmmm...",
            "Omelets are a delicious way to enjoy eggs.",
            "Cheese omelet, or Omelet du Fromage, is a great way to impress the ladies",
            "Is butter a carb? I think Health Canada can safely say no to that.",
            "Margarine has more unsaturated fats than butter!",
            "Canola oil is a healthy oil to use for cooking.",
            "Peanuts are great (unless you're allergic, in which case stay away).",
            "Sesame seeds are tasty!",
            "Sunflower oil is a great choice for cooking!",
            "Bacon grease can definitely increase your chace of a heart attack!",
            "Baked potato chips are a slightly healthier option compared to regular chips.",
            "Beef jerky has 7g of protein in a 20g package!!!",
            "Banana chips are a healthy, and tasty snack!",
            "Baked beans are very high in carbs! Stay away (unless you're on an all-carb diet).",
            "Peanuts, almonds, and cashews are a great source of healthy fats",
        );
        $rand_key = array_rand($items, 1);
        return $items[$rand_key];
    }

    function smokingInfo($smoking, $smoke_data, $age, $gender, $json, $googlemapskey)
    {
        $parseGender = $gender == "M" ? "men" : "women";
        $percent = getSmokePercent($smoking, $smoke_data);
        if ($smoking == "never") {
            return "<a href=\"https://twitter.com/intent/tweet?button_hashtag=CODE2015%2CCanLife&text=I'm%20a%20part%20of%20the%20" . $percent . "%25%20of%20" . $age . "%20year%20old%20" . $parseGender . "%20of%20Canada%20who%20have%20never%20smoked!\" class=\"twitter-hashtag-button\">Tweet #CODE2015%2CCanLife</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        }";
        }
        else if($smoking == "former") {
            return "<a href=\"https://twitter.com/intent/tweet?button_hashtag=CODE2015%2CCanLife&text=I'm%20a%20part%20of%20the%20" . $percent . "%25%20of%20" . $age . "%20year%20old%20" . $parseGender . "%20of%20Canada%20who%20have%20successfully%20quit%20smoking!\" class=\"twitter-hashtag-button\">Tweet #CODE2015%2CCanLife</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        }";
        }
        else {
            return "<iframe width='550' height='300'
                          frameborder='0' style='border:0'
                          src='https://www.google.com/maps/embed/v1/search?key=" . $googlemapskey . "
                            &q=smoking+clinics+near+M5G'>
                        </iframe>";
        }
    }
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
            google.setOnLoadCallback(drawSmokeChart);
            function drawBMIChart() {
                var data = google.visualization.arrayToDataTable([
                    <?php
                        printf("
                            ['BMI', 'Percent'],
                            ['Underweight', %s],
                            ['Normal weight', %s],
                            ['Slightly overweight', %s],
                            ['Overweight', %s],
                            ['Not specified', %s]
                        ", $bmi_data[0], $bmi_data[1], $bmi_data[2], $bmi_data[3], $bmi_data[4]);
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

            function drawSmokeChart() {
                var data = google.visualization.arrayToDataTable([
                    <?php
                        printf("
                            ['Frequency', 'Percent'],
                            ['Never', %s],
                            ['Former', %s],
                            ['Occasional', %s],
                            ['Everyday', %s],
                            ['Not Specified', %s]
                        ", $smoke_data[0], $smoke_data[1], $smoke_data[2], $smoke_data[3], $smoke_data[4]);
                     ?>
                ]);

                var options = {
                    title: 'Smoking Statistics Across Canada',
                    pieHole: 0.4,
                    chartArea: {
                        width: 375,
                        height: 375,
                        top: 25
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('SmokeDonut'));
                chart.draw(data,options);
            }

        </script>
        <!--<script type="text/javascript">
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
            var lat = position.coords.latitude;
            var long = position.coords.longitude;
            }

        </script>-->
    </head>
    <body>
        <?php include("header.php"); ?>

        <div id="content">
            <section class="intro">
                <br />
                <p>You are a <?=$age?> year old <?=parseGender($gender)?>.</p>
                <?php
                $randPhrases = array_rand(items, 1);
                if($height != "" && $weight != "") {
                    $bmi = returnBMI($height, $weight);
                    echo "<h3>Body Mass Index</h3>
                    <section class='row'>
                        <div class='col'>
                            <p>From your data, your BMI is "
                        . number_format($bmi, 2) .
                        ", which is " . returnBMItype($bmi) . ". " . getBMIPercent($bmi, $bmi_data) ."% of
                        Canadians are also " . returnBMItype($bmi) . ". </p>
                        <h4>Health Tidbit</h4>
                        <blockquote>
                            " . getQuote() . "
                        </blockquote>
                        </div>
                        <div class='col'>
                            <div id='BMIDonut' style='width:400px; height:350px;'></div>
                        </div>
                    </section>";
                    }
                ?>
                <?php if($self_rate != "") {
                    echo "<h3>Self-Rated Health</h3>
                    <section class='row'>
                        <div class='col'>
                            <p>You rated your health as being " .
                        getSelfHealth($self_rate) .
                        ". This is the same as " . getSelfHealthValue($self_rate, $self_health_data) .
                        "% of the population.</p>
			<h4>Why don't you try " . $task_data[1] . " to keep fit? We found some places close to you!</h4>
                        <iframe width='550' height='300'
                          frameborder='0' style='border:0'
                          src='https://www.google.com/maps/embed/v1/search?key=" . $googlemapskey . "
                            &q=" . $task_data[0]  . "+near+M5G'>
                        </iframe>
                        // . $jsonObject->resourceSets[0]->resources[0]->address->postalCode .
                        </div>
                        <div class='col'>
                            <div id='SelfHealthDonut' style='width=400px; height=350px;'></div>
                        </div>
                    </section>";
                }
                ?>
                <?php if($internet_use != "") {
                    echo "<h3>Internet Use</h3>
                    <section class='row'>
                        <div class='col'>
                            <p>Your internet use is " .
                        internetUseText($internet_use) . " which is similar to " .
                        number_format(getInternetUseValue($internet_use, $internet_use_data)) .
                        "% of Canadians around your age. </p>
                        </div>
                        <div class='col'>
                            <div id='InternetDonut' style='width:400px; height:350px;'></div>
                        </div>
                    </section>";
                    }
                ?>
                <?php if($smoking != "") {
                    echo "<h3>Smoking</h3>
                    <section class='row'>
                        <div class='col'>
                            <p>You " . getSmokeText($smoking) . ". "
                        . getSmokePercent($smoking, $smoke_data) .
                    "% of other Canadians also " . getSmokeText($smoking) . "</p>"
                        . smokingInfo($smoking, $smoke_data, $age, $gender, $jsonObject->resourceSets[0]->resources[0]->address->postalCode, $googlemapskey) .
                        "</div>
                        <div class='col'>
                            <div id='SmokeDonut' style='width:400px; height:350px;'></div>
                        </div>
                    </section>
                    ";
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
