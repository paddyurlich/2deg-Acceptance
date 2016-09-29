<?php




//===========COMMENTS=====================
// create a full sql SELECT string which loops through each of the "Fields"/headings in the Acceptance_Stats_3G_daily tables
// note that the loop starts at 18 beccuase the first 18 are the counters used to calculate the main 4 KPI's
// http://localhost/Acceptance/create_full_sql_string.php?startDate=2016-08-25+00%3A00%3A00&endDate=2016-08-25+00%3A00%3A00&cell%5B%5D=060-RCTN-U09-1-1&startDate_post=2016-09-07+00%3A00%3A00&endDate_post=2016-09-07+00%3A00%3A00&cellCluster2%5B%5D=060-RCTN-U09-1-1
//========================================
    

function getFullSQL(){

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


      


      $selection = isset($_GET['cell']) ? $_GET['cell'] : null ;      
      $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null ;
      $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null ;
      $formComplete = (is_null($selection)  || is_null($startDate) || is_null($endDate)) ? false : true ;


        //======================================================
        // BUILD SELECTED CELLS STRING
        //======================================================


        if (isset($_GET['cell'])){

          $selectedCells = "";

          foreach ($selection as $selectedCell) {
            $selectedCells .= " CELLNAME = '".$selectedCell."' OR ";
          }
          $selectedCells = substr($selectedCells, 0, -3); //remove last "OR" from end of SQL string


        //=====================================================



        //$startDate = "2016-08-25 00:00:00";
        //$endDate = "2016-08-25 00:00:00";
        //$selectedCells = "CELLNAME = '060-RCTN-U09-1-1'";

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
          //echo $KPI_field_array[34]['Field'];


          $size_of_KPI_array =  count($KPI_field_array) - 1;

          //$size_of_KPI_array = 34;

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

          //======================================================

          $fullSQL_string =  $sql_string_select.$sql_string_main.$sql_string_end;

          echo $fullSQL_string;
        } else {
          echo "Form not complete";
        }

     }

//getFullSQL();

?>