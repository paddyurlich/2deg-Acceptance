<?php

function getDateList(){
	
	$servername = "172.21.200.37";
    $username = "patrickurlich";
    $password = "forPUonly";
    $dbname = "ranPU";
    $table = "Acceptance_Stats_3G_daily";

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

    $sql = "SELECT Date from `ranPU`.`".$table."`"." ORDER BY $table.Date ASC";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $result_array[] = $row;

        }
    } else {
        echo "ERROR: problem with getDateList function !!";
    }

     foreach($result_array as $k => $v) {
          //$dateList_array[] =  substr($result_array[$k]['Date'],0,-9);
          $dateList_array[] = $result_array[$k]['Date'];
     }

      	$dateList_array = array_unique($dateList_array);

      $connect->close();

   		return $dateList_array;

}

?>
