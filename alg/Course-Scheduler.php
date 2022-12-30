<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Algorithm</title>
  <link rel="stylesheet" href="/FALL-2022-CSP/css/styles.css">
  <?php include $_SERVER['DOCUMENT_ROOT'] . "/FALL-2022-CSP/views/navbar.php"; ?>

  <style>
  body {
    background-image: url('/FALL-2022-CSP/views/background.png');
  }
</style>
</head>

<body>
  <div class="container" id="algo-output">
    <?php
    include $_SERVER['DOCUMENT_ROOT'] . "/Fall-2022-CSP/alg/algo1.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Fall-2022-CSP/alg/Models.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/Fall-2022-CSP/alg/DBconnection.php";
    // This will be the main driver program, 
    // and will call all of the functions that are run to make the algorithm work

    //Database connection
    $db = new DB();

    /* 
      handles post requests
      if debug is true, then the algo will print out the debug messages and show
      errors and warnings
    */
    if ($_POST) {
      $debug = isset($_POST['debug']);
    } else {
      $debug = false;
    }

    if ($debug) {
      error_reporting(E_ALL);
    } else {
      error_reporting(0);
    }
    //This is the array that stores all of the courses that are either locked and conflict, or unlocked and cannot be scheduled.
    $conflictingCourses = [];


    /*
    These functions return a map of all courses with their SCID as the key and their groups as the value.
  
    The lab portion uses the LID as the key and the groups as the value.
    */
    $courseGroupMap = algo1();
    $labGroupMap = algo1_lab();

    /*
    This parses the cousrses and labs into a single array of Course objects.
    They are stored as a map with the SCID as the key and the Course object as the value.
    For the labs, they are stored as L . $LID as the key.
    */
    $courseList = parseCourses(get_courses(), get_labs());

    /*
    This array stores all of the available times for the courses to be scheduled.
    It starts at 8:00 AM and ends at 6:30 PM.

    To change the available start times for courses, this is the only place that needs to be changed.
    */
    $courseTimes = [
      480, 570, 660, 750, 840, 930, 1020, 1110 //incremented by 1:30
    ];

    /*
      This is creates an array of all of the days of the week.
      The days available to the course is retrieved by $days[days_per_week - 1].

      To change the available days for courses, this is the only place that needs to be changed.
      There can also be more added, for example, if a course meets 4 times a week, then add another element to the array with its corrospoinding days.
    */
    $oneDay = ["m", "t", "w", "r", "f"];
    $twoDays = ["mr", "tf"];
    $threeDays = ["mwf", "twtf"];
    $days = [$oneDay, $twoDays, $threeDays];

    //Finds the number of groups that have been assigned to courses.
    $maxGroup = 0;
    foreach ($courseGroupMap as $course => $courseGroups) {
      foreach ($courseGroups as $courseGroup) {
        if ($courseGroup > $maxGroup) {
          $maxGroup = $courseGroup;
        }
      }
    }
    foreach ($labGroupMap as $lab => $labGroups) {
      foreach ($labGroups as $labGroup) {
        if ($labGroup > $maxGroup) {
          $maxGroup = $labGroup;
        }
      }
    }

    /*
      This adds the groups and courses to the Schedule object.
      The groups go from 0 to the maxGroup, and each groups id is the index of the array.
      The courses are stored, and then added to the groups.
    */
    $schedule = new Schedule($maxGroup, $courseList);

    // Schedules the courses
    scheduleCourses();

    if ($debug) {
      printSchedule($schedule);
    }



    /*
      This is the main funciton that schedules the courses.
      It loops through all of the courses and labs and schedules them.
      It also handles the conflicts and locked courses.
      It needs to be called after the schedule object has been created.
    */
    function scheduleCourses()
    {
      global $schedule;
      global $courseTimes;
      global $days;
      global $conflictingCourses;


      /*
    This conflict checks the Locked courses.
    If a course conflicts with another locked course, then it is added to the conflictingCourses array.
    */
      foreach ($schedule->courseList as $courseID => $course) {
        if ($course->isLocked()) {
          //Must conflict check each group that is assosciated with the course
          foreach ($course->getGroupIDs() as $groupID) {
            $intersection = $schedule->groups[$groupID]->intersect($schedule->courseList, $courseID);
            //$intersection[0] is true or false if there is a conflict
            //$intersection[1] is the course that is conflicting
            if ($intersection[0]) {
              //This adds the confliction course to the conflictingCourses array if it is not already in it.
              //If it is, then it adds it to the spot it is in the array.
              if (isset($conflictingCourses[$courseID])) {
                $conflictingCourses[$courseID] = $conflictingCourses[$courseID] . ', ' . $intersection[1];
              } else {
                $conflictingCourses[$courseID] = $intersection[1];
              }
            }
          }
        } else {
          //If course is not locked, then make sure it is not assigned a time.
          $schedule->courseList[$courseID]->setTime(null, null, null);
        }
      }
      echo "<p><b>Locked Courses?:</b> Yes</p>";

      //This schedules the courses that are not locked.


      //This shuffles the courses in the groups, so that the courses are not scheduled in the same order every time.
      foreach ($schedule->groups as $groupID => $group) {
        $schedule->groups[$groupID]->shuffleCourses();
      }

      //This sorts the groups by the number of courses in them, high to low.
      $sortedGroups = $schedule->groups;
      usort($sortedGroups, function ($a, $b) {
        return count($a->getCourseIDs()) <=> count($b->getCourseIDs());
      });
      $sortedGroups = array_reverse($sortedGroups);

      /*
    This loops through the groups with the most courses to the ones with the least.
    In each group, it loops through the courses and schedules them.
    */

      foreach ($sortedGroups as $group) {
        $courseIDs = $group->getCourseIDs();
        foreach ($courseIDs as $courseID) {
          $course = $schedule->courseList[$courseID];
          if ($course->isScheduled()) {
            //If the course is already scheduled, then skip it.
            //This can happen if the course is locked or if it is in a group that is already scheduled.
            continue;
          }

          foreach ($courseTimes as $time) { //Loops through all of the available times
            foreach ($days[$course->getDaysPerWeek() - 1] as $day) { //loops through all of the available days
              if ($schedule->scheduleCourse($courseID, $time, $day)) { //if the course is sucessfully scheduled, then breaks out of the loop
                break 2;
              }
            }
          }

          //updates the local variable to be the same as what is in the schedule object
          $course = $schedule->courseList[$courseID];
          //If the course is not scheduled, then it is added to the conflictingCourses array.
          if (!$course->isScheduled()) {
            $conflictingCourses[$courseID] = "No time slot available";
          }
        }
      }

      echo '<script>alert("Courses Scheduled And Saved.");</script>';
      saveSchedule($schedule);
      printErrors();
      //end of scheduling algorithm
    }

    //helper functions

    /*
      This function parses the tables from the database and creates the course objects.
      It also adds all of the groups from the Maps to the course objects.
      The array that it returns is an array of course objects, structured as SCID => course for courses, and L . LID => course for the labs.
    */
    function parseCourses($courseTable, $labsTable)
    {
      global $courseGroupMap;
      global $labGroupMap;

      $courseList = array();
      foreach ($courseTable as $row) {
        $courseGroups = $courseGroupMap[$row['SCID']];
        if ($row['days']) {
          $row['days'] = strtolower($row['days']);
        }

        $course = new Course($row['start_time'], $row['end_time'], $row['days'], $row['days_per_week'], $row['duration'], $row['locked'], $courseGroups);
        $SCID = $row['SCID'];
        $courseList[$SCID] = $course;
      }

      foreach ($labsTable as $row) {
        $labGroups = $labGroupMap[$row['LID']];

        if ($row['days']) {
          $row['days'] = strtolower($row['days']);
        }

        $lab = new Course($row['start_time'], $row['end_time'], $row['days'], $row['days_per_week'], $row['duration'], $row['locked'], $labGroups);
        $courseList["L" . $row["LID"]] = $lab;
      }

      return $courseList;
    }

    function printErrors()
    {
      global $conflictingCourses;
      echo "<p><b>Conflicting Courses?:</b>";
      if (count($conflictingCourses) == 0) {
        echo " None<br></p>";
      }

      foreach ($conflictingCourses as $courseName => $conflict) {
        if ($conflict == "No time slot available") {
          echo $courseName . " " . $conflict . "<br>";
        } else {
          echo $courseName . " conflicts with " . $conflict . "<br>";
        }
      }
    }


    function saveSchedule($schedule)
    {
      global $db;
      //saves the schedule to database
      foreach ($schedule->courseList as $ID => $course) {

        if (substr($ID, 0, 1) == "L") { //checks if the course is a lab
          $sql = "UPDATE lab SET start_time = '" . $course->getStartTime() .
            "', end_time = '" . $course->getEndTime() .
            "', days = '" . $course->getDays() .
            "' WHERE LID = " . substr($ID, 1);
        } else {
          $sql = "UPDATE scheduler SET start_time = '" .
            $course->getStartTime() . "', end_time = '" .
            $course->getEndTime() . "', days = '" .
            $course->getDays() . "' WHERE SCID = " . $ID;
        }
        $db->query($sql);
      }
    }

    function printSchedule($schedule)
    {
      foreach ($schedule->groups as $groupID => $group) {
        printGroup($schedule->courseList, $group, $groupID);
      }
    }

    function printGroup($courseList, $group, $groupID)
    {
      global $db;

      echo "Group: " . $groupID . " <br>";
      $courseIDs = $group->getCourseIDs();
      usort($courseIDs, function ($a, $b) use ($courseList) {
        return $courseList[$a]->getStartTime() <=> $courseList[$b]->getStartTime();
      });
      $group->setCourseIDs($courseIDs);
      foreach ($group->getCourseIDs() as $courseID) {
        $course = $courseList[$courseID];
        $courseName = "";
        if (substr($courseID, 0, 1) == "L") {
          $LID = substr($courseID, 1);
          $labInfo = $db->getLabInfo($LID);
          $courseName = $labInfo['short_name'] . " " . $labInfo['section'] . " LabID_" . $LID;
        } else {
          $courseInfo = $db->getCourseInfo($courseID);
          $courseName = $courseInfo['short_name'] . " " . $courseInfo['section'];
        }

        echo $courseName . " ";

        $locked = showLocked($course->isLocked()) ?: "Unlocked";
        echo minTo24h($course->getStartTime()) . " " . minTo24h($course->getEndTime()) . " " . $course->getDays() . $locked . " <br>";
      }
    }
    function showLocked($locked)
    {
      if ($locked) {
        return "Locked";
      } else {
        return "";
      }
    }
    function minTo24h($min)
    {
      $hour = floor($min / 60);
      $min = $min % 60;
      return sprintf("%02d:%02d", $hour, $min);
    }
    ?>
      <form action="/Fall-2022-CSP/views/calendar.php">
      <button type="submit" value="Go to Calendar">View Calendar</button>
    </form>
    <br>
  </div>
</body>

</html>