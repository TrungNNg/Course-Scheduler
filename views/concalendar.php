<!DOCTYPE html>
<html>

<head>
    <title>Connected?</title>

<body>
    <!-- checking connections -->
    <?php
    //Now, lets put this into the myphp my admin database, and start crackin
    
    //require_once "config.php";
    /* Database credentials. */
    /* Make sure to use your own credentials */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', '2022-scheduler');
    /* Attempt to connect to MySQL database */
    $conn = mysqli_connect(
    DB_SERVER,
    DB_USERNAME,
    DB_PASSWORD,
    DB_NAME
    );
    // Check connection
    if ($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    } else {
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $selectOption = trim($_POST['choice']);
        $search = trim($_POST['search']);

        

        $sqk = "SELECT * FROM scheduler WHERE 'days' = m";
        $result = $conn->query($sql);
        $rows = $results->fetch_assoc(); //then print out end of each echo with this data

        //other create connection: $conn = new mysqli($servername, $username, $password, $dbname);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "reached statements";
            while ($row = $result->fetch_assoc()) {
                $color = "c" . $row['CID'];
                $text = $row['days'];
                if (strlen($text) > 1) {
                    $middle = strrpos(substr($text, 0, floor(strlen($text) / 2)), ' ') + 1;
                    $string1 = substr($text, 0, $middle);
                    $string2 = substr($text, $middle);

                    $names = "SELECT * FROM course WHERE CID=\"" . $row["CID"] . "\"";
                    $results2 = $conn->query($names);
                    $row2 = $results2->fetch_assoc(); //then print out end of each echo with this data
    

                    echo '<div class="' . $color . ' slot ' . $string1 . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                    echo '<div class="' . $color . ' slot ' . $string2 . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                } else {
                    $names = "SELECT * FROM course WHERE CID=\"" . $row["CID"] . "\"";
                    $results2 = $conn->query($names);
                    $row2 = $results2->fetch_assoc(); //then print out end of each echo with this data
                    echo '<div class="' . $color . ' slot ' . $row["days"] . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                }
            }
        } else {
            echo "0 results";
        }
    } else
    {
        $sql = "SELECT * FROM scheduler"; //select * or SELECT bookCount, title, author FROM books"; books is the name of the database, everything else is the row names
        //$sql = sprintf("SELECT title FROM books");
            $result = $conn->query($sql);
        
            //other create connection: $conn = new mysqli($servername, $username, $password, $dbname);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    $color = "c" . $row['CID'];
                    $text = $row['days'];
                    if (strlen($text) > 1) {
                        $middle = strrpos(substr($text, 0, floor(strlen($text) / 2)), ' ') + 1;
                        $string1 = substr($text, 0, $middle);
                        $string2 = substr($text, $middle);
        
                        $names = "SELECT * FROM course WHERE CID=\"" . $row["CID"] . "\"";
                        $results2 = $conn->query($names);
                        $row2 = $results2->fetch_assoc(); //then print out end of each echo with this data
            
        
                        echo '<div class="' . $color . ' slot ' . $string1 . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                        echo '<div class="' . $color . ' slot ' . $string2 . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                    } else {
                        $names = "SELECT * FROM course WHERE CID=\"" . $row["CID"] . "\"";
                        $results2 = $conn->query($names);
                        $row2 = $results2->fetch_assoc(); //then print out end of each echo with this data
                        echo '<div class="' . $color . ' slot ' . $row["days"] . ' start' . gmdate("is", $row["start_time"]) . ' duration' . $row["duration"] . '">' . $row2["long_name"] . '<span>' . $row2["short_name"] . '-' . $row["section"] . '</span></div>';
                    }
                }
            } else {
                echo "0 results";
            }
    }


    $conn->close();
    ?>
</body>

</html>