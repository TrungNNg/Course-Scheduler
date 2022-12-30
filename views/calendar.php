<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include "navbar.php"; ?>
	<link rel="stylesheet" href="/Fall-2022-CSP/css/styles.css">
	<link rel="stylesheet" href="/Fall-2022-CSP/css/calendarstyle.css">
	<title>Course Scheduler</title>
</head>


<div style="background-color: white";>
<br>
<aside style="display: inblock-grid;">
			<form action="/Fall-2022-CSP/alg/Course-Scheduler.php" method="POST">
					<div id="output">
					<script src="./js/dist/alg.js" defer></script>
						<button type="submit" id="alg" value="runAlg">Schedule Courses</button>
						<!-- class="button", run algo button -->
						

					</div>
				</form>
				<br>
			<button onclick="window.print();"class="button" style="background-color: gray; margin-bottom: 1rem;">Export</button>
			<button onclick="<script>window.print();</script>" class="button" style="background-color: gray; margin-bottom: 1rem;">Filters</button>

<div class="calendar-container">
	<div class="header">
		<ul class="weekdays">
			<li>Monday</li>
			<li>Tuesday</li>
			<li>Wednesday</li>
			<li>Thuesday</li>
			<li>Friday</li>
		</ul>
		<ul class="daynumbers">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>

	<div class="timeslots-container">
		<ul class="timeslots">
			<li>8<sup>am</sup>
			<li>9<sup>am</sup>
			<li>10<sup>am</sup>
			<li>11<sup>am</sup>
			<li>12<sup>am</sup>
			<li>1<sup>pm</sup>
			<li>2<sup>pm</sup>
			<li>3<sup>pm</sup>
			<li>4<sup>pm</sup>
			<li>5<sup>pm</sup>
			<li>6<sup>pm</sup>
			<li>7<sup>pm</sup>
			<li>8<sup>pm</sup>
			<li>9<sup>pm</sup>
		</ul>
	</div>

	<div class="event-container"> <!-- calendar events go here -->
		<!-- 
		<div class="slot m start830">
				Computer Science 3<span>CPS 330-2</span>
		</div>
		<div class="slot m start400 duration75">
			
				Software Engineering<span>CPS 353-1</span>
		</div>

		<div class="c6 slot m start430">
				Computer Science 3<span>CPS 330-2</span>
		</div> 	-->

		<?php include "concalendar.php"; ?>
	</div>

</div>
<!-- Filter button not working yet
<div>
	<form method="POST" action="config.php" class="container">
		<input type="text" placeholder="Search" name="search" id="search" required>
		<br>
		<select name="choice" id="choice">
			<option value="days">Days</option>
			<option value="faculty">Faculty</option>
			<option value="short_name">Course</option>
		</select>
		<button type="submit">Filter</button> -->
	</form>
</div>
</div>
</html>