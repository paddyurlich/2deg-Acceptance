<?php 

function getFieldType4G(){

  	$servername = "172.21.200.37";
    $username = "patrickurlich";
    $password = "forPUonly";
    $dbname = "ranPU";
    $table = "Acceptance_Stats_4G_field_type";

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

    $sql = "SELECT * from `ranPU`.`".$table."`";
    //echo $sql;

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $result_array[$row['field_name']] = $row;
        }
    } else {
        echo "WARNING: error with getFieldType4G function";
    }


     // foreach($result_array as $k => $v) {
     //     $field_type_3G_array[] =  $result_array[$k]['CELLNAME'];
     // }



      $connect->close();

      return $result_array;
      //var_dump($result_array);
}

//getFieldType_3G();

?>

