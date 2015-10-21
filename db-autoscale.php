<?php
function getSampleDataFromDB()
{
    //verify that mysqli has been enabled
    if (function_exists('mysqli_connect') == false) {
        echo "need to enable mysqli!" ;
        error_log("need to enable mysqli!", 0);
        return;
    }

    //connect with connection info from environment variables
    $json = getenv('VCAP_SERVICES');
    $arr = json_decode($json, true);
    $hostname = $arr['p-mysql'][0]['credentials']['hostname'];
    $username = $arr['p-mysql'][0]['credentials']['username'];
    $password = $arr['p-mysql'][0]['credentials']['password'];
    $dbname = $arr['p-mysql'][0]['credentials']['name'];

    //connect to the database
    $mysql = mysqli_connect($hostname, $username, $password, $dbname );
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        return;
    }

    //check if testtable has been created, if not then create it
  	$sql = "select num_total from testtable";
  	$result = mysqli_query($mysql, $sql);
  	if (empty($result)) {
  	    echo "testtable is empty!" ;
  	    // sql to create table
  	     $sql = "CREATE TABLE testtable (
  	        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  	        num_total VARCHAR(30) NOT NULL
  	        )";
  	     if (mysqli_query($mysql, $sql)) {
  	        echo "Table created successfully" ;
            return;
  	     } else {
  	         echo "Error creating table: " . mysqli_error($mysql);
             error_log("Error creating table: " . mysqli_error( $mysql));
  	         return;
  	     }
  	}
    $anArray = mysqli_fetch_assoc($result);
    if (empty($anArray)){
        $sql = "INSERT INTO testtable (num_total) VALUES (6)";
        if (mysqli_query($mysql, $sql)) {
            echo "num_total value added successfully";
        } else {
            echo "Error adding num_total value: " . mysqli_error( $mysql);
            error_log("Error adding num_total value: " . mysqli_error( $mysql));
        }
    }

    //get and return sample data from the database
    $sql = "select num_total from testtable" ;
    $result = mysqli_query($mysql, $sql);
    if (empty($result)){
      return "result is empty";
      error_log("result is empty");
    }
    if ((empty($anArray)) or (empty($anArray[ "num_total" ]))) {
        echo "error: return value not set" ;
        error_log("error: return value not set");
        return;
    } else {
        return $anArray ["num_total"];
    }
}
?>
