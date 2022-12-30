<?php
/*
  This class is used to store the groups and courses that are needed to create a schedule.
  It also contains the functions that are used to create the schedule.
*/
class Schedule
{
  //groups is an array of Group objects. The Id of each group is the index of the array.
  public $groups = [];
  //courses is an array of Course objects. The Id of each course is the index of the array.
  public $courseList = [];


  /*
    This function creates a new Schedule object.
    $maxGroup is the maximum group ID that is used in the schedule.
    $courseList is an array of Course objects.
    creates all groups and links all of the groups to the courses that they are in.
  */
  function __construct($maxGroup,$courseList)
  {
    for($i = 0; $i <= $maxGroup; $i++)
    {
      $this->groups[$i] = new Group();
    }
    $this->courseList = $courseList;
    foreach ($courseList as $ID => $course) {
      foreach($course->getGroupIDs() as $groupID)
      {
        $this->groups[$groupID]->addCourse($ID);
      }
    }
  }

  /*
    returns true if the course can be scheduled at the given time and day.
    if the course can be scheduled, it is scheduled.
    returns false if the course cannot be scheduled at the given time and day.
  */
  function scheduleCourse($courseID, $time, $day)
  {
    $course = $this->courseList[$courseID];
    $this->courseList[$courseID]->setTime($time, $time + $course->getDuration(), $day);
    foreach ($course->getGroupIDs() as $groupID) {
      if ($this->groups[$groupID]->intersect($this->courseList, $courseID)[0]) {
        $this->courseList[$courseID]->setTime(null, null, null);
        return false;
      }
    }
    
    return true;
  }
}

class Group
{
  private $courseIDs = [];    //array of course IDs that are in the group

  function addCourse($courseID)
  {
    array_push($this->courseIDs, $courseID);
  }
  

  /*
    if the course intersects with any of the courses in the group, returns true and the ID of the intersecting course.
    if the course does not intersect with any of the courses in the group, returns false and null.
  */
  function intersect($courseList = [], $course1ID = 0)
  {
    $course1 = $courseList[$course1ID];
    foreach ($this->courseIDs as $course2ID) {
      $course2 = $courseList[$course2ID];
      if ($course1ID != $course2ID) {
        if (timeIntersect([$course1->getStartTime(), $course1->getEndTime()], [$course2->getStartTime(), $course2->getEndTime()])) {
          if (dayIntersect($course1->getDays(), $course2->getDays())) {
            return [true, $course2ID];
          }
        }
      }
      
    }
    return [false, null];
  }
  function getDays()
  {
    return $this->days;
  }
  function shuffleCourses()
  {
    shuffle($this->courseIDs);
  }
  function getCourseIDs()
  {
    return $this->courseIDs;
  }
  function setCourseIDs($courseIDs)
  {
    $this->courseIDs = $courseIDs;
  }
}

class Course
{
  private $startTime;
  private $endTime;
  private $days;
  private $daysPerWeek;
  private $groupIDs = [];
  private $duration;
  private $locked;

  function __construct(
    $startTime,
    $endTime,
    $days,
    $daysPerWeek,
    $duration,
    $locked = false,
    $groupIDs = [], //stores the groups that the course is in by index in
  ) {
    $this->days = $days;
    $this->daysPerWeek = $daysPerWeek;
    $this->duration = $duration;
    $this->locked = $locked;
    $this->groupIDs = $groupIDs;
    if ($locked) {     //if it is locked set these, otherwise null
      $this->startTime = $startTime;
      $this->endTime = $endTime;
    } else {
      $this->startTime = null;
      $this->endTime = null;
    }
  }
  
  function getStartTime()
  {
    return $this->startTime;
  }
  function getEndTime()
  {
    return $this->endTime;
  }
  function getDays()
  {
    return $this->days;
  }
  function getGroupIDs()
  {
    return $this->groupIDs;
  }
  function isLocked()
  {
    return $this->locked;
  }
  function getDuration()
  {
    return $this->duration;
  }

  function isScheduled()
  {
    return ($this->startTime && $this->endTime);
  }
  function setTime($start, $end, $days)
  {
    $this->startTime = $start;
    $this->endTime = $end;
    $this->days = $days;
  }
  function getDaysPerWeek()
  {
    return $this->daysPerWeek;
  }
}

/*
  returns true if the two times intersect
  returns false if the two times do not intersect
*/
function timeIntersect($time1, $time2)
{
  $starttime1 = $time1[0];
  $endtime1 = $time1[1];
  $starttime2 = $time2[0];
  $endtime2 = $time2[1];

  if ($starttime1 <= $endtime2 && $starttime1 >= $starttime2) {
    return true;
  } else if ($endtime1 <= $endtime2 && $endtime1 >= $starttime2) {
    return true;
  } else if ($starttime2 <= $endtime1 && $starttime2 >= $starttime1) {
    return true;
  } else if ($endtime2 <= $endtime1 && $endtime2 >= $starttime1) {
    return true;
  } else {
    return false;
  }
}

/*
  returns true if the two daysets intersect
  returns false if the two daysets do not intersect
*/
function dayIntersect($days1, $days2)
{
  for ($i = 0; $i < strlen($days1); $i++) {
    for ($j = 0; $j < strlen($days2); $j++) {
      if ($days1[$i] == $days2[$j]) {
        return true;
      }
    }
  }
  return false;
}
?>