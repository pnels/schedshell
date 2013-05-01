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

    <?php printNavbar("goals"); ?>

    <div class='container-fluid'>

        <!-- START: main page -->
        <div class='row-fluid'>
            <?php printNavlist("goals"); ?>
            <div class='offset2 span6'>
<?php if( !isset($_POST['page']) || $_POST['page'] == '0' ) { ?>
<form action='' method='POST'>
  <select>
    <option>Computer Science</option>
    <option>Journalism</option>
  </select>
</form>  
<? } else if( isset($_POST['page']) && $_POST['page'] == '1' ) { ?>
<form action='' method='POST'>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC131'>
    CMSC131
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC132'>
    CMSC132
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC216'>
    CMSC216
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC250'>
    CMSC250
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC330'>
    CMSC330
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC351'>
    CMSC351
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='STAT4XX'>
    STAT4XX
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='MATH4XX'>
    MATH4XX
  </label>
<!-- start 400s -->
  <label class='checkbox'>
    <input type='checkbox' value='CMSC411'>
    CMSC411
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC412'>
    CMSC412
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC414'>
    CMSC414
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC417'>
    CMSC417
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC420'>
    CMSC420
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC421'>
    CMSC421
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC422'>
    CMSC422
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC423'>
    CMSC423
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC424'>
    CMSC424
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC426'>
    CMSC426
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC427'>
    CMSC427
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC430'>
    CMSC430
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC433'>
    CMSC433
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC434'>
    CMSC434
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC435'>
    CMSC435
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC436'>
    CMSC436
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC451'>
    CMSC451
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC452'>
    CMSC452
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC456'>
    CMSC456
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC460'>
    CMSC460
  </label>
  <label class='checkbox'>
    <input type='checkbox' value='CMSC466'>
    CMSC466
  </label>
</form>
<? } else if( isset($_POST['page']) && $_POST['page'] == '2' ) { ?>

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
