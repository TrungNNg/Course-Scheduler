<?php
session_start();

//Displays a message set when user tries to access a page without logging in first
if(isset($_SESSION['message'])) {
	print($_SESSION['message']);
	unset($_SESSION['message']);
}

//If the session timed out with destroy session variables and print a message
if(isset($_SESSION['timed_out'])) {
	print("Sorry your session timed out. Please log in again");
	session_unset();
	session_destroy();
}

if(isset($_POST['submit'])){
	include $_SERVER['DOCUMENT_ROOT'] . "/Fall-2022-CSP/old/templates/forms/calls.php";
	$db = DB::scheduler_factory();			
	$date = date("y/m/d");			//Gets our link to the DB

    $sql = "SELECT UFID, user_name, uf_password FROM user_info";  //Selects the fields we'll need: usernames and passwords
	$result = json_decode($db->fetch($sql), true);		//Querys for selected fields and puts them in $result

    foreach ($result as $resultArray) {					//Cycles through result array as other resultArrays
		foreach($resultArray as $values) {				//Cycles through values in array
			$dbusername = $values['user_name'];			//Takes in usernames and passwords from array
			$dbpassword = $values['uf_password'];
			$dbUFID = $values['UFID'];
			if ($dbusername == $_POST['username'] && $dbpassword == $_POST['password']) {
				$_SESSION['logged_in'] = true;              //Use   if($_SESSION['logged_in'])    on other pages to make sure someone can't simple access via URL
				$_SESSION['last_activity'] = time();		//Set the last_activity variable to now
				$_SESSION['expire_time'] = 1800;			//Constant that determines session time period as seconds (30 minutes)
				unset($_SESSION['message']);
				$query = "INSERT INTO user_activity (UFID, is_successful, date_login) VALUES ('$dbUFID', '1', '$date')";
				$db->save($query);
				header("Location:/Fall-2022-CSP/old/forms.php"); //Sends us home after login
				exit;
			}
		}
    }
	$temp = $_POST['username'];
	$query = "INSERT INTO user_activity (UFID, is_successful, date_login) VALUES ('$temp', '0', '$date')";
	$db->save($query);
    print('Sorry we couldn\'t find your Username/Password.');
}
?>

<!DOCTYPE html>
<html lang="en">

<head> 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/Fall-2022-CSP/css/styles.css">
	<title>Login</title>
</head>
<body>

<?php include "navbar.php"; ?>
	
	<form method="POST" action="" class="container">
		<h1 style="color: #f58426; font-size: 45px;">Login</h1>

		<label for="username"><b>Username</b></label><br>
		<input type="text" placeholder="Enter Username" name="username" id="username" required><br>

		<label for="password"><b>Password</b></label><br>
		<input type="password" placeholder="Enter Password" name="password" id="password" required><br>

		<div class="bottom-buttons">
			<button type="reset" style="background-color: red; font-size: 30px;">Clear</button>
			<button type="submit" style="background-color: #00a5d9; font-size: 30px;" name="submit">Login</button>
		</div><br><br>
	</form>

</body>
</html>