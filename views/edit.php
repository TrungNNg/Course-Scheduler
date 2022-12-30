<?php
// session_start();
//This all works now, uncomment at the end?
// //Checks to see if the user is logged in
// if($_SESSION['logged_in']) {
// 	if($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) {
// 		$_SESSION['timed_out'] = true;
// 		header("Location:/Fall-2022-CSP/old/login.php");
// 	}
// 	else {
// 		$_SESSION['last_activity'] = time();
// 	}
// }

// //Else we redirect the user to the login page
// else {
// 	header("Location:/Fall-2022-CSP/old/login.php");
// 	$_SESSION['message'] = "Please log in first to access this page.";
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Edit</title>
</head>

<body>
    <div class="page-wrap">
        <div>
			<link rel="stylesheet" href="/css/styles.css">
			<?php include "navbar.php"; ?>
		</div>
        <main class="page-main">


        </main>
        <script src="./js/dist/edit.js"></script>
    </div>

</body>

</html>