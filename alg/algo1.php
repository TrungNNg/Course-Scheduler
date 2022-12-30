<?php

    // Part 1 of scheduler algo
    // the algo will take all lectures and labs from the database, put them in correct group
    // and give them to part two

    // A map which key is (SCID) in scheduler table and value is groups that the lecture belong to 
    $lecture_group = array();

    // A map which key is (LID) in lab table and value is groups that the lab belong to 
    $lab_group = array();

    ##########################
    ## functions for part 2 ##
    ##########################

    /* @return lecture_group
    *  
    *  This function will build the prereq tree using requisite table in DB, it will accomplish
    *  it by using associative array, every lecture or lab that should not be schedule at
    *  the same time will be in the same group
    */
    function algo1() {
        // turn on for debug info
        $debug = false;

        // data needed to build group list
        $is_in_department = array();
        $preq = array();
        $reverse_preq = array();
        $coreq = array();

        // get connection to database
        $conn = get_connection();

        // select all courses in course table
        $course_sql = 'SELECT CID, short_name, long_name FROM course';
        
        //check if DB is successful connected
        if ($debug) {
            print($_SERVER['DOCUMENT_ROOT']);
            echo "<br>";
            if ($conn->connect_error) {
                die('connection failed');
            } else {
                print("CONNECTED");
                echo "<br>";
                print_r($conn);
            }
        }

        // course_list is all row in course table
        $result = mysqli_query($conn, $course_sql);
        $course_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // build is_in_department
        foreach ($course_list as $c) {
            if (substr($c["short_name"],0,-3) == "CPS") { // only consider course in CPS department
                $is_in_department[$c["CID"]] = $c["short_name"];
            }
            // MAT320 is special case, a math course that are both a req and require CS course
            if ($c["short_name"] == "MAT320") {
                $is_in_department[$c["CID"]] = $c["short_name"];
            }
        }

        // print map from CID to course name
        if ($debug) {
            echo "is_in_indepartment <br>";
            foreach ($is_in_department as $k => $v) {
                //var_dump($k);
                echo $k . " => " . $v ."<br>" ;
            }
            echo "<br>";
        }

        // a map from course name to id
        $nameToCID = array();
        foreach ($is_in_department as $k => $v) {
            $nameToCID[$v] = $k;
        }

        if ($debug) {
            echo "name to CID <br>";
            foreach ($nameToCID as $k => $v) {
                //var_dump($k);
                echo $k . " => " . $v ."<br>" ;
            }
            echo "<br>";
        }

        // get all from requisite table
        $req_sql = 'SELECT CID, has_preq, has_coreq, REID FROM requisite';
        $result = mysqli_query($conn, $req_sql);
        $requisite_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
        /*
        foreach ($requisite_list as $c) {
            var_dump($c);
            echo "<br>";
        }*/

        // build $preq and $coreq
        foreach ($is_in_department as $k => $v) {
            $preq[$v] = array();
            $coreq[$v] = array();
            foreach ($requisite_list as $r) {
                if ($r["CID"] == $k) {
                    if ($r["has_preq"]) {
                        $preq[$v][] = $is_in_department[$r["REID"]];
                    }
                    if ($r["has_coreq"]) {
                        $coreq[$v][] = $is_in_department[$r["REID"]];
                    }
                }
            } 
        }

        // test coreq
        //$coreq["CPS210"][] = "CPS310";
        //$coreq["CPS310"][] = "CPS210";
    

        // print $preq and $corq
        if ($debug) {
            echo "preq list k need v<br>";
            foreach ($preq as $k => $v) {
                echo $k . " => ";
                //var_dump($v);
                foreach ($v as $i) {
                    echo $i . " ";
                }
                echo "<br>";
            }

            echo "<br> corq list <br>";
            foreach ($coreq as $k => $v) {
                echo $k . " => ";
                //var_dump($v);
                foreach ($v as $i) {
                    echo $i . " ";
                }
                echo "<br>";
            }
        }

        // build reverse_preq, a map which key is a course and value are courses need k as preq
        $reverse_preq = array();
        foreach ($preq as $k => $v) {
            // since this coures does not have any prereq, it's preq (k) is space " "
            // we will use a list of all start courses later.
            if (count($v) == 0) {
                $reverse_preq[" "][] = $k;
                continue;
            }
            foreach ($v as $preq_course) {
                if (!array_key_exists($preq_course, $reverse_preq)) {
                    $reverse_preq[$preq_course] = array($k);
                } else {
                    $reverse_preq[$preq_course][] = $k;
                }
            }
        }

        // print $reverse_preq
        if($debug) {
            echo "<br> k is preq for v (reverse_preq)";
            echo "<br>";
            foreach ($reverse_preq as $p => $c) {
                echo $p . " => ";
                //var_dump($c);
                foreach ($c as $i) {
                    echo $i . " ";
                }
                echo "<br>";
            }
        }

        // we will begin traverse the prereq tree and record level of each course
        // we will traverse from start courses until it hit a course that is not a prereq for any course (an end course)
        // then record the end course into end_courses array to traverse back.
        // the level when traverse top to bottom will be save in m array, bottom to top is in n array 

        $m = array();
        $end_courses = array();
        $start_courses = $reverse_preq[" "]; // start_courses are all courses that have no preq
        foreach ($start_courses as $c) {
            $m[$c] = 0; // all start courses is same level
            link_reverse($c, $m, $reverse_preq, $end_courses);
        }
        
        if ($debug) {
            echo "<br>";
            echo "forward: ";
            echo count($m);
            echo "<br>";
            foreach ($m as $k => $v) {
                echo $k;
                echo " -> ";
                echo $v;
                echo "<br>";
            }
        }

        // now that we have end_courses we can use this to traverse from bottom to top
        // print end coures
        $end_courses = array_unique($end_courses);

        if ($debug) {
            echo "<br> end courses list <br>";
            foreach ($end_courses as $c) {
                echo $c;
                echo "<br>";
            }
        }

        // Same recursive algo like for m array, different function
        // reverse group assign
        $n = array();
        foreach ($end_courses as $c) {
            $n[$c] = 0;
            link_preq($c, $n, $preq);
        }

        // print n  
        if ($debug) {
            echo "<br>";
            echo "backward: ";
            echo count($n);
            echo "<br>";
            foreach ($n as $k => $v) {
                echo $k;
                echo " -> ";
                echo $v;
                echo "<br>";
            }
        }

        // a map for coreq courses
        // courses that are coreq will be same corq counter
        $l = array();
        $corq_counter = 0;
        foreach ($coreq as $k => $v) {
            $l[$k] = null;
            $change = false;
            foreach ($v as $co) {
                $l[$k] = $corq_counter;
                $l[$co] = $corq_counter;
                $change = true;
            }
            if ($change) {
                $corq_counter += 1;
            }
        }

        if ($debug) {
            echo "<br> l for coreq group <br>";
            foreach ($l as $k => $v) {
                echo $k . " -> " . $v . "<br>";
            }
        }

        // get data from scheduler table which store lecture section of all courses that need
        // to be scheduled, every row is a lecture
        $scheduler_sql = 'SELECT SCID, CID, FID, ROID from scheduler';
        $result = mysqli_query($conn, $scheduler_sql);
        $scheduler_list = mysqli_fetch_all($result, MYSQLI_ASSOC);        

        if ($debug) {
            echo "<br> SCID and CID from scheduler table <br>";
            foreach ($scheduler_list as $row) {
                var_dump($row);
                echo "<br>";
            }
        }

        // get data from lab table, each row is a lab need to be scheduled
        $lab_sql = 'SELECT LID, SCID, FID, ROID from lab';
        $result = mysqli_query($conn, $lab_sql);
        $lab_list = mysqli_fetch_all($result, MYSQLI_ASSOC);        

        if ($debug) {
            echo "<br> LID and SCID from lab table <br>";
            foreach ($lab_list as $row) {
                var_dump($row);
                echo "<br>";
            }
        }

        global $lecture_group, $lab_group;

        $group = 0; // keep track of unique group.
        foreach ($scheduler_list as $c) {
            $lecture_group[$c['SCID']] = array();
        }
        foreach ($lab_list as $c) {
            $lab_group[$c['LID']] = array();
        }

        // assign prereq for lecture group
        assign_preq($m, $scheduler_list, $group, $lecture_group, $is_in_department);
        assign_preq($n, $scheduler_list, $group, $lecture_group, $is_in_department);

        // handle coreq
        assign_corq($l, $scheduler_list, $group, $lecture_group, $is_in_department);

        // lab with same lecture will be same group as lecture
        foreach ($lab_list as $c) {
            $lab_group[$c['LID']] = $lecture_group[$c['SCID']];
        }

        if ($debug) {
            echo "<br> lecture group <br>";
            foreach ($lecture_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
    
            echo "<br> lab group <br>";
            foreach ($lab_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
        }

        // handle special case for CPS104 and CPS110, don't need to care about conflict for 
        // these two class because they don't count for student degree completion
        foreach ($scheduler_list as $c) {
            if ($is_in_department[$c['CID']] == "CPS104" || $is_in_department[$c['CID']] == "CPS110"){
                $lecture_group[$c['SCID']][0] = $group;
                $lecture_group[$c['SCID']][1] = $group + 1;
                $group += 2;
            }
        }

        if ($debug) {
            echo "<br> lecture group after handle special case <br>";
            foreach ($lecture_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
        }

        // assign group to all lecture and lab base on faculty and room.
        // create 2 maps for falcuty group and room group,
        // go through each row and assign accordingtly
        // map FID to unique number
        $faculty = array();
        $fa_counter = 0;
        // map ROID to unique number
        $rooms = array();
        $room_counter = 0;
        foreach ($scheduler_list as $r) {
            if (!array_key_exists($r['FID'],$faculty)) {
                $faculty[$r['FID']] = $fa_counter;
                $fa_counter += 1;
            }
        }
        foreach ($scheduler_list as $r) {
            if (!array_key_exists($r['ROID'], $rooms)) {
                $rooms[$r['ROID']] = $room_counter;
                $room_counter += 1;
            }
        }
        foreach ($lab_list as $r) {
            if (!array_key_exists($r['FID'],$faculty)) {
                $faculty[$r['FID']] = $fa_counter;
                $fa_counter += 1;
            }
        }
        foreach ($lab_list as $r) {
            if (!array_key_exists($r['ROID'], $rooms)) {
                $rooms[$r['ROID']] = $room_counter;
                $room_counter += 1;
            }
        }

        if ($debug) {
            echo "<br> faculty list <br>";
            foreach($faculty as $k => $v) {
                echo $k . " -> " . $v . "<br>";
            }
            echo "<br> room list <br>";
            foreach($rooms as $k => $v) {
                echo $k . " -> " . $v . "<br>";
            } 
        }

        // assign group for faculty for lecture group and lab group
        assign_faculty($faculty, $lecture_group, $scheduler_list, $lab_group, $lab_list, $group);
        if ($debug) {
            echo "<br> lecture group after assign faculty <br>";
            foreach ($lecture_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
            echo "<br> lab group after assign faculty <br>";
            foreach ($lab_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
        }

        assign_rooms($rooms, $lecture_group, $scheduler_list, $lab_group, $lab_list, $group);
        if ($debug) {
            echo "<br> lecture group after assign room <br>";
            foreach ($lecture_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
            echo "<br> lab group after assign room <br>";
            foreach ($lab_group as $k => $v) {
                echo $k . " => ";
                foreach ($v as $n) {
                    echo $n . ", ";
                }
                echo "<br>";
            }
        }

        if ($debug) {
            echo "<br> <br> <br>";
        }
        return $lecture_group;
    }

    // return lab_group
    function algo1_lab() {
        global $lab_group;
        return $lab_group;
    }

    // fetch all from scheduler table
    function get_courses() {
        $conn = get_connection();
        $sql = 'SELECT * FROM scheduler';
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // fetch all from lab table
    function get_labs() {
        $conn = get_connection();
        $sql = 'SELECT * FROM lab';
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }


    ######################
    ## helper functions ##
    ######################

    // print how many lecture and lab a group number have
    function maxgroup() {
        global $lecture_group, $lab_group;
        $temp = array();
        foreach ($lecture_group as $k => $v) {
            foreach ($v as $n) {
                if (!array_key_exists($n, $temp)) {
                    $temp[$n] = 1;
                } else {
                    $temp[$n] += 1;
                }
            }
        }
        foreach ($lab_group as $k => $v) {
            foreach ($v as $n) {
                if (!array_key_exists($n, $temp)) {
                    $temp[$n] = 1;
                } else {
                    $temp[$n] += 1;
                }
            }
        }
        foreach ($temp as $k => $v) {
            echo "<br>" . $k . " => " . $v;
        }
    }

    // assign faculty group number to lecture group and lab group
    function assign_faculty($faculty, &$lecture_group, $scheduler_list, &$lab_group, $lab_list, &$group) {
        $max = 0; // to update group
        foreach ($faculty as $k => $v) {
            if ($max < $v) {
                $max = $v;
            }
        }
        foreach ($scheduler_list as $r) {
            $lecture_group[$r['SCID']][] = $group + $faculty[$r['FID']];
        }
        foreach ($lab_list as $r) {
            $lab_group[$r['LID']][] = $group + $faculty[$r['FID']];
        }
        $group += $max + 1;
    }

    // assign room group number to lecture group and lab group
    function assign_rooms($rooms, &$lecture_group, $scheduler_list, &$lab_group, $lab_list, &$group) {
        $max = 0; // to update group
        foreach ($rooms as $k => $v) {
            if ($max < $v) {
                $max = $v;
            }
        }
        foreach ($scheduler_list as $r) {
            $lecture_group[$r['SCID']][] = $group + $rooms[$r['ROID']];
        }
        foreach ($lab_list as $r) {
            $lab_group[$r['LID']][] = $group + $rooms[$r['ROID']];
        }
        $group += $max + 1;
    }

    // assign coreq group number to lecture groups
    function assign_corq($m, $scheduler_list, &$group, &$lecture_group, $is_in_department) {
        $max = 0; // to update the group
        foreach ($scheduler_list as $c) {
            if ($max < $m[$is_in_department[$c['CID']]]) {
                $max = $m[$is_in_department[$c['CID']]];
            }
        }
        $change = false;
        foreach ($scheduler_list as $c) {
            if ($m[$is_in_department[$c['CID']]]) {
                $lecture_group[$c['SCID']][] = $m[$is_in_department[$c['CID']]] + $group;
                $change = true;
            }
        }
        if ($change) {
            $group += $max + 1;
        }
    }
    
    // assign prereq to lecture groups
    function assign_preq($m, $scheduler_list, &$group, &$lecture_group, $is_in_department){
        $max = 0; // to update the group
        foreach ($scheduler_list as $c) {
            if ($max < $m[$is_in_department[$c['CID']]]) {
                $max = $m[$is_in_department[$c['CID']]];
            }
        }
        foreach ($scheduler_list as $c) {
            $lecture_group[$c['SCID']][] = $m[$is_in_department[$c['CID']]] + $group;
        }
        $group += $max + 1;
    }

    // get connection from 2022-scheduler DB
    function get_connection() {
        $host = "localhost";
        $db_name = "2022-scheduler";
        $username = "root";
        $password = "";
        $conn = new mysqli($host,$username,$password,$db_name);
        return $conn;
    }

    // build level number from bottom to top
    function link_preq($c, &$n, $preq) {
        if (!count($preq[$c])) { // if $c does not have any preq 
            return;
        }
        foreach ($preq[$c] as $course) {
            if (!array_key_exists($course, $n)) {
                $n[$course] = $n[$c] + 1;
            } else {
                if ($n[$course] < $n[$c] + 1) {
                    $n[$course] = $n[$c] + 1;
                }
            }
            link_preq($course, $n, $preq);
        }
    }
    
    // this recursive function will traverse and record the level of courses from top to bottom to m,
    // save end courses to end_courses array
    function link_reverse($c, &$m, $reverse_preq, &$end_courses) {
        if (!array_key_exists($c, $reverse_preq)) { // if this course is not a preq to anything, save and return
            $end_courses[] = $c;
            return;
        }
        foreach($reverse_preq[$c] as $course) { // for all course that has $c as preq
            if (!array_key_exists($course, $m)) {
                $m[$course] = $m[$c] + 1;
            } else {
                if ($m[$course] < $m[$c] + 1) {
                    $m[$course] = $m[$c] + 1;
                }
            }
            link_reverse($course, $m, $reverse_preq, $end_courses);
        }
    }
?>