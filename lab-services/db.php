<?php
function getSampleDataFromDB()
{

  // Verify that mysqli has been enabled
    if (function_exists('mysqli_connect') == false) {
        echo "need to enable mysqli!" ;
        error_log("need to enable mysqli!", 0);
        return;
    }

  // Connect with hard-coded connection info- look under VCAP_SERVICES
    $dbname = "YOUR INFO HERE";  //under 'name' and something like: ad_a4fffdc3d80e473
    $hostname = "YOUR INFO HERE"; // something like us-cdbr-iron-east-02.cleardb.net
    $username = 'YOUR INFO HERE'; // something like bdfe1eb555af52
    $password = "YOUR INFO HERE"; // something like 348d05d5

  // Connect to the database
    $mysql = mysqli_connect($hostname, $username, $password, $dbname );
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        error_log("Failed to connect to MySQL: " . mysqli_connect_error());
        return;
    } else {
        echo "Success connecting to the db!";
    }
}
?>

