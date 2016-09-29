<?php
    

function getFullSQL($selection, $startDate, $endDate){

      set_time_limit(360);

      //=============================
      // database connection
      //=============================  

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

      //======================================================
      // BUILD SELECTED CELLS STRING
      //======================================================

      $selectedCells = "";

      foreach ($selection as $selectedCell) {
        $selectedCells .= " CELLNAME = '".$selectedCell."' OR ";
      }
      $selectedCells = substr($selectedCells, 0, -3); //remove last "OR" from end of SQL string

      //=====================================================

      $sql = ("SHOW COLUMNS FROM Acceptance_Stats_3G_daily");

      $result = $connect->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              $KPI_field_array[] = $row;
          }
      } else {
          echo "0 results";
      }

      //var_dump($KPI_field_array);

      $size_of_KPI_array =  count($KPI_field_array) - 1;

      //======================================================
      // BUILD SQL STRING
      //======================================================

      $sql_string_main = "";

      for ($x = 18; $x <= $size_of_KPI_array ; $x++) {
        $sql_string_main .= "sum(".$KPI_field_array[$x]['Field'].") AS ".$KPI_field_array[$x]['Field'].",";
      }
      
      $sql_string_select = "SELECT ";

      $sql_string_main = substr($sql_string_main,0,-1);
    
      $sql_string_end = " FROM `ranPU`.`Acceptance_Stats_3G_daily` WHERE (Date BETWEEN '".$startDate."' AND '".$endDate."') AND ".$selectedCells; 


      $SQL_string =  $sql_string_select.$sql_string_main.$sql_string_end;
      //echo $SQL_string;
      //======================================================
      // GET RESTULT OF QUERY AND PUT INTO ARRAY 
      //======================================================
      $result = $connect->query($SQL_string);


      if ($result->num_rows > 0) {
      // output data of each row
          while($row = $result->fetch_assoc()) {
              $result_array['test'][] = $row;
          }
      } else {
          echo "0 results";
      }

      // CLOSE CONNECTION AND RETURN RESULT

      $connect->close();

      return json_encode($result_array);
      //return $result_array;

     }
?>


<?php

  $selection[] = "060-RCTN-U09-1-1";
  
  $startDate = "2016-08-26 00:00:00";
  $endDate = "2016-08-26 00:00:00";

  $startDate_post = "2016-08-27 00:00:00";
  $endDate_post = "2016-08-27 00:00:00";


  $stats_pre =  getFullSQL($selection, $startDate, $endDate);
  $stats_post =  getFullSQL($selection, $startDate_post, $endDate_post);

  echo $stats_post;

?>

 
<html>
<head>
  <title></title>
</head>
<body>
    <table>
       <thead>
          <tr>
            <th></th>
            <th>Pre</th>
            <th>Post</th>
            <th>Delta</th>
          </tr>
        </thead>

      <tbody>



      <?php 
        foreach ($stats_post[0] as $key => $value) {
        
          echo "<tr>";
            echo "<th>".$key."</th>";
            echo "<td>".$value."</th>";        
            echo "<td>".$value."</th>";        
          echo "</tr>";
        } 
      ?>
      </tbody>
    </table>




</body>
</html>
