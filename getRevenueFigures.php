<?php
function getRevenueFigures(){
	
	$servername = "172.21.200.37";
    $username = "patrickurlich";
    $password = "forPUonly";
    $dbname = "ranPU";
    $table = "revenue_figures";

    // Create connection
    //$connect = new mysqli($servername, $username, $password, $dbname);
     $connect = mysqli_connect($servername, $username,$password,$dbname); 
    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }     

    //==========================================
    //get date list from Acceptance stats table - and use for dropdown menus.
    //==========================================

    $sql = "SELECT * from `ranPU`.`".$table."`";
    $result = $connect->query($sql);

    var_dump($result);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $result_array = $row;

        }
    } else {
        echo "ERROR: problem with getRevenueFigures function !!";
    }


    $connect->close();

   	//var_dump($result_array);

   	return $result_array;
   }

getRevenueFigures();

?>