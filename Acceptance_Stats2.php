

<?php include 'functions.php' ?>
<?php include 'main_function.php' ?>
<?php include 'main_function_4G.php' ?>
<?php include 'getCellList.php' ?>
<?php include 'getCellList4G.php' ?>
<?php include 'getDateList.php' ?>


<?php

  // get date list and and cell list from functions. 
  $dateList = getDateList();
  $cellList = getCellList();
  $cellList4G = getCellList4G();


  set_time_limit(360);


  //=============================
  // helper vars
  //=============================

  $selectedCells_pre = isset($_GET['cell']) ? $_GET['cell'] : null ;
  $selectedCells_post = isset($_GET['cellCluster2']) ? $_GET['cellCluster2'] : null ;

  $selectedCells_4G_pre = isset($_GET['cell4Gpre']) ? $_GET['cell4Gpre'] : null ;
  $selectedCells_4G_post = isset($_GET['cell4Gpost']) ? $_GET['cell4Gpost'] : null ;


  $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null ;
  $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null ;

  $startDate_post = isset($_GET['startDate_post']) ? $_GET['startDate_post'] : null ;
  $endDate_post = isset($_GET['endDate_post']) ? $_GET['endDate_post'] : null ;

  $formComplete = (is_null($selectedCells_pre)  || is_null($startDate) || is_null($endDate)) ? false : true ;


  // $connect->close();

  $stats_pre =  returnStats3G("pre", $selectedCells_pre, $startDate, $endDate);
  $stats_post =  returnStats3G("post", $selectedCells_post, $startDate_post, $endDate_post);

  $stats_4G_pre =  returnStats4G("pre", $selectedCells_4G_pre, $startDate, $endDate);
  $stats_4G_post =  returnStats4G("post", $selectedCells_4G_post, $startDate_post, $endDate_post);

  // var_dump($selectedCells_pre);
  // var_dump($startDate);
  // var_dump($startDate);
  // var_dump($stats_pre);


  // var_dump($selectedCells_post);
  // var_dump($startDate_post);
  // var_dump($endDate_post);
  // var_dump($stats_post);
?>


<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Acceptance Stats</title>
  <link rel="stylesheet" href="docsupport/style.css">
  <link rel="stylesheet" href="docsupport/prism.css">
  <link rel="stylesheet" href="chosen.css">
  <style type="text/css" media="all">
    /* fix rtl for demo */
    .chosen-rtl .chosen-drop { left: -9000px; }
  </style>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



</head>
<body>


<!--     <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="#"> Acceptance Stats </a>
          </div>
    </nav> -->


<!-- <br></br><br></br> -->

    <div class="jumbotron">
      <div class="container">
        <h1>Acceptance Stats</h1>
        <p>Compare performance of a cluster between a range of dates. </p>
      </div>
    </div>


    <form action:"index.php" method: "get">
    <div class="container">

      <div class="row">

        <div class="col-md-3">  
          <h2>Pre Dates</h2>
          <hr>  
            <em>Start time/date:</em>
            <select name="startDate" data-placeholder="Choose a start date..." class="chosen-select" style="width:200px;" tabindex="4">
            <option value=""></option>       
                <?php foreach($dateList as $k => $v) { ?>
                  <option value="<?php echo $dateList[$k] ?>" <?php echo isset($startDate) && $dateList[$k] == $startDate ? ' selected' : '' ?>> <?php echo $dateList[$k]; ?>  </option>                    
                <?php } ?> 
            </select>

            <br/><br/>

            <em>End time/date: </em>
            <select name="endDate" data-placeholder="Choose an end date..." class="chosen-select" style="width:200px;" tabindex="4">
              <option value=""></option>       
                <?php foreach($dateList as $k => $v) { ?>
                  <option value="<?php echo $dateList[$k]?>" <?php echo isset($endDate) && $dateList[$k] == $endDate ? ' selected' : '' ?>> <?php echo $dateList[$k]; ?>                      
                <?php } ?> 
            </select>
        </div>

        <div class="col-md-4">
          <h2>Cells (Pre) 3G</h2>
             <hr>
             <select name="cell[]" data-placeholder="Choose a cell..." class="chosen-select" multiple style="width:300px;" tabindex="4">
                <option value=""></option>       
                    <?php foreach($cellList as $k => $v) { ?>
                        <option value=<?php echo $cellList[$k];?>
                          
                          <?php
                            if (isset($selectedCells_pre)) {
                              foreach ($selectedCells_pre as $key => $selectedCell) {
                                echo isset($selectedCells_pre) && $cellList[$k] == $selectedCell ? ' selected' : '';
                              }
                            }
                          ?>

                          > <!--end of option tag -->

                          <?php echo $cellList[$k]; ?>  

                    <?php } ?> 
              </select>
        </div>

        <div class="col-md-4">
          <h2>Cells (Pre) 4G</h2>
             <hr>
             <select name="cell4Gpre[]" data-placeholder="Choose a cell..." class="chosen-select" multiple style="width:300px;" tabindex="4">
                <option value=""></option>       
                    <?php foreach($cellList4G as $k => $v) { ?>
                        <option value=<?php echo $cellList4G[$k];?>
                          
                          <?php
                            if (isset($selectedCells_4G_pre)) {
                              foreach ($selectedCells_4G_pre as $key => $selectedCell) {
                                echo isset($selectedCells_4G_pre) && $cellList4G[$k] == $selectedCell ? ' selected' : '';
                              }
                            }
                          ?>

                          > <!--end of option tag -->

                          <?php echo $cellList4G[$k]; ?>  

                    <?php } ?> 
              </select>
        </div>




      </div> <!--end first row --> 


      <div class="row">

        <div class="col-md-3">  
          <h2>Post Dates</h2>
          <hr>
            <em>Start time/date:</em>
            <select name="startDate_post" data-placeholder="Choose a start date..." class="chosen-select" style="width:200px;" tabindex="4">
            <option value=""></option>       
                <?php foreach($dateList as $k => $v) { ?>
                  <option value="<?php echo $dateList[$k] ?>" <?php echo isset($startDate_post) && $dateList[$k] == $startDate_post ? ' selected' : '' ?>> <?php echo $dateList[$k]; ?>                      
                <?php } ?> 
            </select>

            <br/><br/>

            <em>End time/date: </em>
            <select name="endDate_post" data-placeholder="Choose an end date..." class="chosen-select" style="width:200px;" tabindex="4">
              <option value=""></option>       
                <?php foreach($dateList as $k => $v) { ?>
                  <option value="<?php echo $dateList[$k] ?>" <?php echo isset($endDate_post) && $dateList[$k] == $endDate_post ? ' selected' : '' ?>> <?php echo $dateList[$k]; ?>                      
                <?php } ?> 
            </select>
        </div>


        <div class="col-md-4">
          <h2>Cells (Post) 3G</h2>
          <hr>
             <select name="cellCluster2[]" data-placeholder="Choose a cell..." class="chosen-select" multiple style="width:300px;" tabindex="4">
                <option value=""></option>       
                    <?php foreach($cellList as $k => $v) { ?>
                        <option value=<?php echo $cellList[$k] ?>
                          
                          <?php
                            if (isset($selectedCells_post)) {
                              foreach ($selectedCells_post as $key => $selectedCell) {
                                echo isset($selectedCells_post) && $cellList[$k] == $selectedCell ? ' selected' : '';
                              }
                            }
                          ?>

                          > <!--end of option tag -->

                          <?php echo $cellList[$k]; ?>

                    <?php } ?> 
              </select>
        </div>

        <div class="col-md-4">
          <h2>Cells (Post) 4G</h2>
             <hr>
             <select name="cell4Gpost[]" data-placeholder="Choose a cell..." class="chosen-select" multiple style="width:300px;" tabindex="4">
                <option value=""></option>       
                    <?php foreach($cellList4G as $k => $v) { ?>
                        <option value=<?php echo $cellList4G[$k];?>
                          
                          <?php
                            if (isset($selectedCells_4G_post)) {
                              foreach ($selectedCells_4G_post as $key => $selectedCell) {
                                echo isset($selectedCells_4G_post) && $cellList4G[$k] == $selectedCell ? ' selected' : '';
                              }
                            }
                          ?>

                          > <!--end of option tag -->

                          <?php echo $cellList4G[$k]; ?>  

                    <?php } ?> 
              </select>
        </div>


    </div> <!--end second row --> 



    <div class="row">
      <div class="col-md-12">
        <hr>
        <input type="submit" value="Show" class="btn btn-primary">
      </div>
    </div> <!--end of third row --> 

</form> <!-- end of form --> 

      
      <div class="row">
        <div class="col-md-6">
          <h2>3G Performance Summary</h2>

          <table class="table table-hover table-inverse table-sm" >
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

          foreach ($stats_pre['pre'][0] as $key => $value) {
            //only display the first four KPI's
            if($key == 'Total Revenue ($)')break; 

            $KPI = $key;
            $pre = number_format($value,2);
            $post = number_format($stats_post['post'][0][$key],2);
            $delta = number_format(($post - $pre),2);

            if ($delta > 0){
              $arrow = "up";
              $arrow_color = "green"; 
            };

            if ($delta < 0){
              $arrow = "down";
              $arrow_color = "red"; 
            };

            if ($delta == 0){
              $arrow = "right";
              $arrow_color = "blue"; 
            };

            $glyph = " <span class='glyphicon glyphicon-arrow-".$arrow."' style='color:".$arrow_color."'></span>";
        
            echo "<tr>";
              echo "<th>".$KPI."</th>";
              echo "<td>".$pre."</th>";        
              echo "<td>".$post."</th>"; 
              echo "<td>".$delta.$glyph."</th>";        
            echo "</tr>";
          }
      ?>

      </tbody>
            </table>

        </div>


      <div class="col-md-6">
        <h2>4G Performance Summary</h2>

          <table class="table table-hover table-inverse table-sm" >
                <thead>
                  <tr>
                    <th></th>
                    <th>Pre</th>
                    <th>Post</th>
                    <th>Delta</th>
                  </tr>
                </thead>

                <tbody>
                  <tr>
                    <th scope="row"><?php ?></th>
                    <td><?php ?></td>
                    <td><?php ?></td>
                    <td><?php ?></td>                  
                  </tr>
                
                </tbody>
            </table>



      </div>
    </div>


      <div class="row">
        <div class="col-md-6">
          <h2>3G Performance Detailed </h2>

          <table class="table table-hover table-inverse table-sm" >
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

          foreach ($stats_pre['pre'][0] as $key => $value) {
            if ($key == 'UMTS_CS_Acc (%)') continue;
            if ($key == 'UMTS_CS_Ret (%)') continue;
            if ($key == 'UMTS_PS_Acc (%)') continue;
            if ($key == 'UMTS_PS_Ret (%)') continue;

            $KPI = $key;
            $pre = $value;
            $post = $stats_post['post'][0][$key];
            $delta = ($post - $pre);

            if ($delta > 0){
              $arrow = "up";
              $arrow_color = "red"; 
            };

            if ($delta < 0){
              $arrow = "down";
              $arrow_color = "green"; 
            };

            if ($delta == 0){
              $arrow = "right";
              $arrow_color = "blue"; 
            };

            $glyph = " <span class='glyphicon glyphicon-arrow-".$arrow."' style='color:".$arrow_color."'></span>";
        
            echo "<tr>";
              echo "<th>".$KPI."</th>";
              echo "<td>".number_format($pre,0)."</th>";        
              echo "<td>".number_format($post,0)."</th>"; 
              echo "<td>".number_format($delta,0).$glyph."</th>";        
            echo "</tr>";
          }
      ?>

      </tbody>
            </table>

        </div>


 <div class="row">
        <div class="col-md-6">
          <h2>4G Performance Detailed </h2>

          <table class="table table-hover table-inverse table-sm" >
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

          foreach ($stats_4G_pre['pre'] as $key => $value) {

            $KPI = $key;
            $pre = $value;
            $post = $stats_4G_post['post'][$key];
            $delta = ($post - $pre);

            if ($delta > 0){
              $arrow = "up";
              $arrow_color = "red"; 
            };

            if ($delta < 0){
              $arrow = "down";
              $arrow_color = "green"; 
            };

            if ($delta == 0){
              $arrow = "right";
              $arrow_color = "blue"; 
            };

            $glyph = " <span class='glyphicon glyphicon-arrow-".$arrow."' style='color:".$arrow_color."'></span>";
        
            echo "<tr>";
              echo "<th>".$KPI."</th>";
              echo "<td>".number_format($pre,0)."</th>";        
              echo "<td>".number_format($post,0)."</th>"; 
              echo "<td>".number_format($delta,0).$glyph."</th>";        
            echo "</tr>";
          }
      ?>

      </tbody>
      </table>

        </div>

    </div>


      <hr>

    <div class="row">
      <div class="col-md-12">
      <h2>3G Cells Results</h2>
        <hr>      
      </div>
    </div> <!--end of fourth row --> 


    <div class="row">
      <div class="col-md-12">
      <h2>4G Cells Results</h2>
        <hr>      
      </div>
    </div> <!--end of fifth row --> 

        <div class="row">
      <div class="col-md-12">
      <h2>Charts</h2>
        <hr>      
      </div>
    </div> <!--end of sixth row --> 


    </div> <!-- end of container -->

</body>


<footer>

<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
 -->
<script src="jquery-3.1.0.min.js" type="text/javascript"></script>

<script src="chosen.jquery.js" type="text/javascript"></script>
<script src="docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
  var config = {
    '.chosen-select'           : {},
    '.chosen-select-deselect'  : {allow_single_deselect:true},
    '.chosen-select-no-single' : {disable_search_threshold:10},
    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
    '.chosen-select-width'     : {width:"95%"}
  }
  for (var selector in config) {
    $(selector).chosen(config[selector]);
  }
</script>


  </footer>

</html>
