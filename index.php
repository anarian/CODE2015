<!doctype html>
<html>
<head>
	<?php include("head.php"); ?>

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
                            <input type="number" name="age" required/>
                            <br />
                            <label for="gender">Gender: </label>
                            <label><input type="radio" name="gender" value="Male" required>Male</label>
                            <label><input type="radio" name="gender" value="Female">Female</label>
                        </div>
                        <div class="col">
                            <label for="height" >Height (m): </label>
                            <input type="number" step="any" name="height"/>
                            <br />
                            <label for="weight">Weight (kg): </label>
                            <input type="number" step="any" name="weight"/>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col-full">
                            <label for="self-rate">How do you feel about your current health?<br /></label>
                            <label><input type="radio" name="self-rate" value="PoorFair">&nbsp;Poor or Fair</label>
                            <label><input type="radio" name="self-rate" value="Good">&nbsp;Good</label>
                            <label><input type="radio" name="self-rate" value="VGood">&nbsp;Very Good</label>
                            <label><input type="radio" name="self-rate" value="Excellent">&nbsp;Excellent</label>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col-full">
                            <label for="internet-use">How often do you use the internet?</label>
                            <label><input type="radio" name="internet-use" value="once-per-day">&nbsp;At least once per day</label>
                            <label><input type="radio" name="internet-use" value="once-per-week">&nbsp;At least once per week</label>
                            <label><input type="radio" name="internet-use" value="once-per-month">&nbsp;At least once per month</label>
                            <label><input type="radio" name="internet-use" value="less-per-month">&nbsp;Less than once per month</label>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col-full">
                            <label for="smoking">How often do you smoke?</label>
                            <label><input type="radio" name="smoking" value="never">&nbsp;Never</label>
                            <label><input type="radio" name="smoking" value="former">&nbsp;Former</label>
                            <label><input type="radio" name="smoking" value="occasional">&nbsp;Occasional</label>
                            <label><input type="radio" name="smoking" value="daily = ">&nbsp;Daily</label>
                        </div>
                    </section>
                    <section class="row">
                        <div class="col-full"><input type="submit" /></div>
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

