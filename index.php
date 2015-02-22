<!doctype html>
<html>
<head>
	<?php include("head.php"); ?>
    <script>
        function getPosition() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }
        function showPosition(position)
        {
            document.getElementById('geoLat').value = position.coords.latitude;
            document.getElementById('geoLong').value = position.coords.longitude;
        }
    </script>
	<title>CanLife</title>

</head>
<body>
    <?php include("header.php"); ?>

	<div id="content">

		<section class="intro">
        	<br />
			<h2 style="font-family:Proxima">Compare your health to the rest of Canada</h2>
            	<form action="results.php" method="post">
                	<section class="row">
                		<div class="col">
                            <label for="age">Age:</label>
                            <br />
                            <input type="number" name="age" required value="hello" onclick="getPosition()" id="age" />
                            <br />
                            <br />
                            <label for="gender">Gender: </label>
                            <br />
                            <input type="radio" id="gender1" name="gender" value="Male" required>
                            <label for="gender1">Male</label>
                            <input type="radio" id="gender2" name="gender" value="Female">
                            <label for="gender2">Female</label>
                        </div>
                        <div class="col">
                            <label for="height" >Height (m): </label><br />
                            <input type="number" step="any" name="height" id="height"/><br />
                            <br />
                            <label for="weight">Weight (kg): </label><br />
                            <input type="number" step="any" name="weight" id="weight"/>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col">
                            <label for="self-rate">How do you feel about your current health?<br /></label>
                            <input type="radio" id="self-rate1" name="self-rate" value="PoorFair" /><label for="self-rate1">Poor or Fair</label>
                            <input type="radio" id="self-rate2" name="self-rate" value="Good" /><label for="self-rate2">Good</label>
                            <input type="radio" id="self-rate3" name="self-rate" value="VGood" /><label for="self-rate3">Very Good</label>
                            <input type="radio" id="self-rate4" name="self-rate" value="Excellent" /><label for="self-rate4">Excellent</label>
                        </div>
                        <div class="col">
                            <label for="internet-use">How often do you use the internet?<br /></label>
                            <input type="radio" id="internetuse1" name="internet-use" value="once-per-day"><label for="internetuse1">At least once per day</label>
                            <input type="radio" id="internetuse2" name="internet-use" value="once-per-week"><label for="internetuse2">At least once per week</label>
                            <input type="radio" id="internetuse3" name="internet-use" value="once-per-month"><label for="internetuse3">At least once per month</label>
                            <input type="radio" id="internetuse4" name="internet-use" value="less-per-month"><label for="internetuse4">Less than once per month</label>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col">
                            <label for="smoking">How often do you smoke?<br /></label>
                            <input type="radio" id="smoking1" name="smoking" value="never"><label for="smoking1">Never</label>
                            <input type="radio" id="smoking2" name="smoking" value="former"><label for="smoking2">Former</label>
                            <input type="radio" id="smoking3" name="smoking" value="occasional"><label for="smoking3">Occasional</label>
                            <input type="radio" id="smoking4" name="smoking" value="daily"><label for="smoking4">Daily</label>
                        </div>
                        <div class="col">
                            <input type="text" id="geoLat" name="geoLat" hidden="true" value="" />
                            <input type="text" id="geoLong" name="geoLong" hidden="true" value="" />
                            <input type="submit" /></div>
                    </section
                </form>
		</section>

		<!--<section class="row">
			<div class="col-full">
				<h2>Example title</h2>
				<p>
					Gumba is a fictional agency from Amsterdam, The Netherlands. This is the place where you would normally introduce yourself. You can easily change the template to fit your needs by adding text or changing the colors and styles.
				</p>
			</div>
		</section>

		<section class="row">
			<div class="photo-grid">
				<a href="img/example-photo-b.jpg" rel="lightbox" class="col-2"><img src="img/example-photo-b.jpg" alt="Example photo"></a>
				<a href="img/example-photo-c.jpg" rel="lightbox" class="col-2"><img src="img/example-photo-c.jpg" alt="Example photo"></a>
				<a href="img/example-photo-a.jpg" rel="lightbox" class="col-1"><img src="img/example-photo-a.jpg" alt="Example photo"></a>
			</div>
		</section>


		<section class="row">
			<div class="col">
				<h2>Contact</h2>
				<p>
					Want to work with us? Just send us an <a href="mailto:#">email</a>.
				</p>
			</div>
			<div class="col">
				<h2>Follow us</h2>
				<p>
					We are on <a href="http://twitter.com/rickwaalders">Twitter</a>, <a href="http://dribbble.com/rickwaalders">Dribbble</a> and <a href="http://instagram.com/rickwaalders">Instagram</a>.
				</p>
			</div>
		</section>


		<section class="row">
			<div class="col-full">
				<p>
					© 2014 - This is a free website template by <a href="http://www.pixelsbyrick.com">Rick Waalders</a>
				</p>
			</div>
		</section>-->
 
	</div>

    <?php include("footer.php");?>

</body>
</html>

