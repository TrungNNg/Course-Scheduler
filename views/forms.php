<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/Fall-2022-CSP/css/formsstyles2.css">
  <title>Forms</title>
  
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="tab">
    <button class="tablinks" onclick="openForm(event, 'Course')" id="defaultOpen">Course</button>
    <button class="tablinks" onclick="openForm(event, 'Building')">Building</button>
    <button class="tablinks" onclick="openForm(event, 'Room')">Room</button>
    <button class="tablinks" onclick="openForm(event, 'Staff')">Staff</button>
  </div>

  <div id="Course" class="tabcontent">
    <form method="POST" action="course.php" class="container">
      <br>
      <label for="long_name"><b>Course Title</b></label><br>
      <input type="text" placeholder="Software Engineering" name="long_name" id="long_name" required><br>

      <label for="short_name"><b>Course Number</b></label><br>
      <input type="text" placeholder="CPS353" name="short_name" id="short_name" required><br>

      <label for="credit"><b>Credits</b></label><br>
      <input type="number" placeholder="3" name="credit" id="credit" required><br>

      <label for="is_lab"><b>Does it come with lab or is lab?</b></label><br>
      <select name="is_lab">
        <option value="0">yes</option>
        <option value="1">no</option>
      </select><br><br><br>

      <div class="bottom-buttons">
        <button class="btn" type="reset" style="background-color: red;">Clear</button>
        <button class="btn" type="submit" name="submit">Submit</button>
      </div>

      <?php
        if ($_GET['status'] == 'success') {
          echo '<h1 style="color: yellow">Form Successfully Submitted</h1>';
        } elseif ($_GET['status'] == 'error') {
          echo '<h1 style="color: yellow">Error, please try again.</h1>';
        }
    ?>
    </form>
    
  </div>

  <div id="Building" class="tabcontent">
    <form method="POST" action="building.php" class="container">
      <br>
      <label for="long_name"><b>Long Name</b></label><br>
      <input type="text" placeholder="Science Hall" name="long_name" id="long_name" required><br>

      <label for="short_name"><b>Short Name</b></label><br>
      <input type="text" placeholder="SH" name="short_name" id="short_name" required><br>

    <div class="bottom-buttons">
      <button class="btn" type="reset" style="background-color: red;">Clear</button>
      <button class="btn" type="submit" name="submit">Submit</button>
    </div>
    <?php
        if ($_GET['status'] == 'success') {
          echo '<h1 style="color: yellow">Form Successfully Submitted</h1>';
        } elseif ($_GET['status'] == 'error') {
          echo '<h1 style="color: yellow">Error, please try again.</h1>';
        }
    ?>
    </form>
  </div>

  <div id="Room" class="tabcontent">
    <form method="POST" action="rooms.php" class="container">
      <br>
      <label for="BUID"><b>Building</b></label><br>
      <input type="text" placeholder="SH" name="BUID" id="BUID" required><br>

      <label for="room_num"><b>Room Number</b></label><br>
      <input type="text" placeholder="181" name="room_num" id="room_num" required><br>

      <label for="seats"><b>Seats</b></label><br>
      <input type="text" placeholder="30" name="seats" id="seats" required><br>

      <div class="bottom-buttons">
        <button class="btn" type="reset" style="background-color: red;">Clear</button>
        <button class="btn" type="submit" name="submit">Submit</button>
      </div>
      <?php
        if ($_GET['status'] == 'success') {
          echo '<h1 style="color: yellow">Form Successfully Submitted</h1>';
        } elseif ($_GET['status'] == 'error') {
          echo '<h1 style="color: yellow">Error, please try again.</h1>';
        }
    ?>
    </form>
  </div>

  <div id="Staff" class="tabcontent">
    <form method="POST" action="staff.php" class="container">
      <br>
      <label for="name"><b>First and Last Name</b></label><br>
      <input type="text" placeholder="Moshe Plotkin" name="name" id="name" required><br>

      <label for="email"><b>Email</b></label><br>
      <input type="email" placeholder="plotkinm@newpaltz.edu" name="email" id="email" required><br>

      <label for="password"><b>Password</b></label><br>
      <input type="password" name="password" id="password" required><br>

      <label for="DEID"><b>Department Name</b></label><br>
      <select name="DEID">
        <option value="1">Computer Science</option>
        <option value="2">Mathematic</option>
      </select><br><br>
      
      <label for="role"><b>Department Role</b></label><br>
      <select name="role">
        <option value="2">department chair</option>
        <option value="3">chair assistant</option>
        <option value="4">faculty</option>
      </select><br><br><br>

      <div class="bottom-buttons">
        <button class="btn" type="reset" style="background-color: red;">Clear</button>
        <button class="btn" type="submit" name="submit">Submit</button>
      </div>
      <?php
        if ($_GET['status'] == 'success') {
          echo '<h1 style="color: yellow">Form Successfully Submitted</h1>';
        } elseif ($_GET['status'] == 'error') {
          echo '<h1 style="color: yellow">Error, please try again.</h1>';
        }
    ?>
    </form>
  </div>

</body>
<script>
  function openForm(evt, pageName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(pageName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>
</html>