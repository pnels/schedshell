<!-- -->
<!--nav.inc.php contains all the code for navigation buttons like the side bar and the top bar-->
<?php include('nav.inc.php'); ?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<title>Check Course Prerequisites</title>
        <!-- Boostrap/JQuery Includes -->
        <link href="css/bootstrap-journal.min.css" rel="stylesheet" media="screen">
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js' type='text/javascript'></script>
        <script src='js/bootstrap.min.js' type='text/javascript'></script>
       <!-- Accessing the tree javascript -->
        <script src='js/jit.js' type='text/javascript'></script>
        
        <!-- Checks if user has entered a valid course into the text box, then includes tree stuff -->
        <script type='text/javascript'>
      <?php if( isset($_POST['goal']) && preg_match("/\w{4}\d{3}\w?/", $_POST['goal']) ) {
          include('tree.js.php');
} ?>
        </script>

        <style type="text/css">
            body {
                padding-top: 80px;
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
            .table th, .table td {
              text-align: center;
              vertical-align: top;
            }
            .table td {
              padding-top: 10px;
            }
        </style>

	</head>	

    <body <?php if( isset($_POST['goal']) && preg_match("/\w{4}\d{3}\w?/", $_POST['goal']) ) { echo 'onload="init();"'; } ?> >

    <?php
      printNavbar("goals");
    ?>
    <div class='container-fluid'>

        <!-- START: main page -->
        <div class='row-fluid'>
            <?php printNavlist("goals"); ?>
            <div class='offset2 span6'>
              <form action='' method='POST'>
              <table class='table table-bordered table-hover'>
                <thead><tr><th style='text-align: center;'>Course Code</th></tr></thead>
                <tbody><tr><td><input type='text' name='goal' placeholder='CMSC132' /></td></tr></tbody>
              </table>  
              </form>
<div class='row-fluid'>
<div class='offset2 span8' style='overflow: hidden;' id="center-container"><div class='span10' style="height: 350px; overflow: hidden;" id="treediv"></div></div>
</div>
<br /><br />
<?php
if( isset($_POST['goal']) && preg_match("/\w{4}\d{3}\w?/", $_POST['goal']) ) {
  $mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
  if( $mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  }

  $safe = 0;
  $arr = array();

?>
<table class='table table-bordered table-condensed table-hover'>
  <thead>
    <tr>
      <th style='text-align: center;'>Course Code</th>
      <th style='text-align: center;'>Credits</th>
      <th style='text-align: center;'>Prerequisites</th>
      <th style='text-align: center;'>Corequisites</th>
    </tr>
  </thead>
  <tbody>
<?php

  function getPre($ccode,$mysqli) {
  global $safe, $arr;
  $arr[] = $ccode;
  if( $safe >= 10 ) {
     return;
  }
  $safe++;
  $stmt = $mysqli->prepare("SELECT name, credits, prereqs, coreqs, description FROM course_info WHERE name = ?");
  $param = $ccode;
  $stmt->bind_param('s', $param);
  $stmt->execute();
  $stmt->bind_result($name,$credits,$prereqs,$coreqs,$desc);

    while( $stmt->fetch() ) {
      echo "<tr>";
      echo "<td><b>";
      echo "<a href='#' id='".$name."' class='btn btn-link' data-toggle='popover' data-trigger='hover' data-placement='left' data-content='".$desc."' title='".$name."'>".$name."</a>";
      echo "<script>$(function () { $('#".$name."').popover(); }); </script>";
      echo "</b></td><td>".$credits." credits</td>";
      if( strlen($prereqs) > 1 ) {
        echo "<td>".$prereqs."</td>";
      } else {
        echo "<td></td>";
      }
      if( strlen($coreqs) > 1 ) {
        echo "<td>".$coreqs."</td>";
      } else {
        echo "<td></td>";
      }
      echo "</tr>";
  }
  $prqs = explode( ", ", $prereqs );
  foreach ($prqs as $course) {
    if( $course == $ccode ) {
      continue;
    }
    if( in_array( $course, $arr ) ) {
      continue;
    }
    getPre($course,$mysqli);
  }
  }

  getPre( $_POST['goal'],$mysqli );

?>
</tbody>
</table>

<?php
} elseif( isset($_POST['goal']) ) {
  echo '<b>Please enter a valid course code.</b>'; 
}
?>
</div>

        </div>
        <!-- END: main page -->

        <hr />

        <div class='footer'>
            <p>&copy; SchedShell 2013</p>
        </div>
    </div>

    </body>
</html>
