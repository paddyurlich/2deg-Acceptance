<?php 

function getCellList4G(){

  	$servername = "172.21.200.37";
    $username = "patrickurlich";
    $password = "forPUonly";
    $dbname = "ranPU";
    $table = "Acceptance_Stats_4G_daily";

    // Create connection
    //$connect = new mysqli($servername, $username, $password, $dbname);
     $connect = mysqli_connect($servername, $username,$password,$dbname); 
    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }     

    //==========================================
    //get list of cells from Acceptance Stats table
    //==========================================

    $sql = "SELECT Object from `ranPU`.`".$table."`"." ORDER BY $table.Object ASC";

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $result_array[] = $row;
        }
    } else {
        echo "WARNING: error with getCellList function";
    }


     foreach($result_array as $k => $v) {
         $cellList_array[] =  $result_array[$k]['Object'];
     }

      $cellList_array = array_unique($cellList_array);

      $connect->close();

      return $cellList_array;
}



?>