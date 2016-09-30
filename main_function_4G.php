<?php
    
function returnStats4G($pp, $selection, $startDate, $endDate){

    if (isset($pp, $selection, $startDate, $endDate)) {
      //include getRevenueFigures();
      //$data_cost =  $getRevenueFigures['data'];

      set_time_limit(360);

      //=============================
      // database connection
      //=============================  

      $servername = "172.21.200.37";
      $username = "patrickurlich";
      $password = "forPUonly";
      $dbname = "ranPU";
      $table = "Acceptance_Stats_4G_daily";

      // Create connection
      $connect = mysqli_connect($servername, $username,$password,$dbname); 
      // Check connection
      if ($connect->connect_error) {
          die("Connection failed: " . $connect->connect_error);
      } 

      
      //var_dump($selection);

      //======================================================
      // BUILD SELECTED CELLS STRING
      //======================================================

      $selectedCells = "";

      foreach ($selection as $selectedCell) {
        $selectedCells .= " Object = '".$selectedCell."' OR ";
      }
      $selectedCells = substr($selectedCells, 0, -3); //remove last "OR" from end of SQL string

      //=====================================================
      // GET FIELD NAMES FROM TABLE
      //=====================================================

      $sql = ("SHOW COLUMNS FROM Acceptance_Stats_4G_daily");

      $result = $connect->query($sql);

      if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
              $KPI_field_array[] = $row;
          }
      } else {
          echo "0 results";
      }

      $size_of_KPI_array =  count($KPI_field_array) - 1;

      //======================================================
      // CREATE SQL QUERRY STRING - FOR CALULATED KPIS
      //======================================================

      $sql_string_first = "";             

      $sql_string_first =  "(sum(`L.RRC.ConnReq.Succ`)/(sum(`L.RRC.ConnReq.Att`))*100)
                           AS 'RRC Setup Success Rate (%)',";

      $sql_string_first .= "(sum(`L.CSFB.PrepSucc`)/(sum(`L.CSFB.PrepAtt`))*100)
                           AS 'CSFB Response Success Rate (%)',";

      $sql_string_first .= "(sum(`L.E-RAB.SuccEst`)/(sum(`L.E-RAB.AttEst`))*100)
                           AS 'E-RAB Setup Success Rate (ALL) (%)',";

      $sql_string_first .= "((sum(`L.IRATHO.E2W.ExecSuccOut`))/((sum(`L.IRATHO.E2W.ExecAttOut`)))*100)
                           AS 'Inter-RAT Handover Out Success Rate (LTE to WCDMA)',";

      $sql_string_first .= "(sum(`L.E-RAB.AbnormRel`)/(sum(`L.E-RAB.NormRel`) + sum(`L.E-RAB.AbnormRel`))*100)
                           AS 'Call Drop Rate (All)(%)',";

      $sql_string_first .= "(((sum(`Cell Traffic Volume_DL(Gbits)`) + sum(`Cell Traffic Volume_UL(Gbits)`)) * 1024) / 8 ) * revenue_figures.data 
                            AS 'Total 4G Revenue ($)',";

      //======================================================
      // CREATE BODY OF SQL STRING
      //======================================================

      $sql_string_main = "";

      for ($x = 1; $x <= $size_of_KPI_array ; $x++) {
        $sql_string_main .= "sum(`".$KPI_field_array[$x]['Field']."`) AS `".$KPI_field_array[$x]['Field']."`,";

        //create KPI name array with just the required KPI is form 18 to 35
        $KPI_name_array[] = $KPI_field_array[$x]['Field'];

      }

      //======================================================
      // BUILD ENTIRE SQL STRING
      //======================================================
      
      $sql_string_select = "SELECT ";

      $sql_string_main = substr($sql_string_main,0,-1);
      //$sql_string_main = "";
    
      $sql_string_end = " FROM ranPU.Acceptance_Stats_4G_daily, ranPU.revenue_figures WHERE (Acceptance_Stats_4G_daily.Date BETWEEN '".$startDate."' AND '".$endDate."') AND (".$selectedCells.")"; 

       $SQL_string =  $sql_string_select.$sql_string_first.$sql_string_main.$sql_string_end;
      
      //echo $SQL_string;

      //======================================================
      // GET RESULT OF QUERY AND PUT INTO ARRAY 
      //======================================================

      $result = $connect->query($SQL_string);


      if ($result->num_rows > 0) {
      // output data of each row
          while($row = $result->fetch_assoc()) {
              $result_array[$pp] = $row;
          }
      } else {
          echo "0 results";
      }

      // CLOSE CONNECTION AND RETURN RESULT

      $connect->close();

      return($result_array);
     }


     // $pp = 'pre';
     // $selection[] = "060-RCTN-L18-1-1";
     // $startDate = "2016-09-12";
     // $endDate = "2016-09-12";

     // returnStats4G($pp, $selection, $startDate, $endDate);
  }
 return null;


?>

