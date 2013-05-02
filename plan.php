<?php include('nav.inc.php'); ?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<title>Four Year Plan</title>
        <!-- Boostrap/JQuery Includes -->
        <link href="css/bootstrap-journal.min.css" rel="stylesheet" media="screen">
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js' type='text/javascript'></script>
        <script src='js/bootstrap.min.js' type='text/javascript'></script>
        <script src='js/jit.js' type='text/javascript'></script>

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

    <body>

    <?php printNavbar("plan"); ?>

    <div class='container-fluid'>

        <!-- START: main page -->
        <div class='row-fluid'>
            <?php printNavlist("goals"); ?>
            <div class='offset2 span6'>

<!-- apparently if you're not logged in all post variables are erased? wtf...something to do w/CAS -->
<?php 
global $list;
$list = array( "CMSC131", "CMSC132", "CMSC216", "CMSC250", "CMSC330", "CMSC351", "CMSC411", "CMSC412", "CMSC414", "CMSC417", "CMSC420", "CMSC421", "CMSC422", "CMSC423", "CMSC424", "CMSC426", "CMSC427", "CMSC430", "CMSC433", "CMSC434", "CMSC435", "CMSC436", "CMSC451", "CMSC452", "CMSC456", "CMSC460", "CMSC466" );
?>
<?php if( !isset($_POST['page']) || $_POST['page'] == '0' ) { ?>
<form action='' method='POST'>
  <select>
    <option>Computer Science</option>
    <option>Journalism</option>
  </select>
  <input type='hidden' name='page' value='1'>
  <input type='submit' value='Next'>
</form>  
<? } else if( isset($_POST['page']) && $_POST['page'] == 1 ) { ?>
Select the courses you have currently completed:<br />
<form action='' method='POST'>
<?php
foreach( $list as $class ) {
echo "<label class='checkbox'>";
echo "<input type='checkbox' name='taken[]' value='".$class."'>";
echo $class;
echo "</label>";
}
?>
  <input type='hidden' name='page' value='2'>
  <input type='submit' value='Next'>
</form>
<? } else if( isset($_POST['page']) && $_POST['page'] == '2' ) { ?>
<?php
// use $_POST['taken']
  $mysqli = new mysqli("localhost", "hardshell", "d0ntgue55m3", "hardshell");
   if( $mysqli->connect_errno) {
     echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " .      $mysqli->connect_error;
   }
  function getPre($course,$mysqli) {
  global $list;
   if( in_array( $course, $_POST['taken'] ) ) { return FALSE; }

   $stmt = $mysqli->prepare("SELECT name, credits, prereqs, coreqs, description FROM course_info WHERE name = ?");
   $param = $course;
   $stmt->bind_param('s', $param);
   $stmt->execute();
   $stmt->bind_result($name,$credits,$prereqs,$coreqs,$desc);
 
   $able = TRUE;
   while( $stmt->fetch() ) {
    foreach( explode(", ", $prereqs ) as $pre ) {
      if( !preg_match("/^CMSC.+/", $pre) ) { continue; }
      if( !in_array( $pre, $_POST['taken'] ) ) { $able = FALSE; }
    }
   }
   return $able;
  }  

$oklist = Array();

foreach( $list as $class ) {
  if( getPre($class, $mysqli) ) {
    $oklist[] = $class;
  }
}

?>
<table class='table table-bordered table-hover'>
<thead><tr><th style='text-align: center;'>Courses You Can Take</th></tr></thead>
<tbody>
<?
foreach( $oklist as $class ) {
?>
<tr><td><?php echo $class; ?></td></tr>
<?php
}
?>
</tbody>
</table>
<? } ?>
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
