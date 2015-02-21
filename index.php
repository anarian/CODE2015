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
            <table id="form">
            	<form action="results.php" method="post">
                	<tr>
                		<td><label for="age">Age:</label></td>
                        <td><input type="number" name="age" required/></td>
                    </tr>
                    <tr>
                    	<td><label for="gender">Gender: </label></td>
                        <td style="width:300px"><label><input type="radio" name="gender" value="Male" required>Male</label>
                        <label><input type="radio" name="gender" value="Female">Female</label>
                    </tr>
                    <tr>
                    	<td><label for="height" >Height (m): </label></td>
                        <td style="width:300px"><input type="number" step="any" name="height"/></td>
                    </tr>
                    <tr>
                    	<td><label for="weight">Weight (kg): </label></td>
                        <td style="width:300px"><input type="number" step="any" name="weight"/></td>
                    </tr>
                    <tr>
                    	<td><label for="self-rate">How do you feel about your current health?</label></td>
                    </tr>
                    <tr>
                    	<td><label><input type="radio" name="self-rate" value="PoorFair">&nbsp;Poor or Fair</label>
                        <label><input type="radio" name="self-rate" value="Good">&nbsp;Good</label>
                        <label><input type="radio" name="self-rate" value="VGood">&nbsp;Very Good</label>
                        <label><input type="radio" name="self-rate" value="Excellent">&nbsp;Excellent</label></td>
                        <td style="width:0;"></td>
                    </tr>
                    <tr>
                    	<td><label for="internet-use">How often do you use the internet?</label></td>
                    </tr>
                    <tr>
						<td><label><input type="radio" name="internet-use" value="once-per-day">&nbsp;At least once per day</label>
                        <label><input type="radio" name="internet-use" value="once-per-week">&nbsp;At least once per week</label>
                        <label><input type="radio" name="internet-use" value="once-per-month">&nbsp;At least once per month</label>
                        <label><input type="radio" name="internet-use" value="less-per-month">&nbsp;Less than once per month</label></td>
                        <td style="width:0;"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" /></td>
                    </tr>
                </form>
            </table>
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

