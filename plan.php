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

<!-- apparently if you're not logged in all post variables are erased? wtf...something to do w/CAS -->

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
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC131'>
    CMSC131
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC132'>
    CMSC132
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC216'>
    CMSC216
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC250'>
    CMSC250
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC330'>
    CMSC330
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC351'>
    CMSC351
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='STAT4XX'>
    STAT4XX
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='MATH4XX'>
    MATH4XX
  </label>
<!-- start 400s -->
400 Level courses are below:<br />
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC411'>
    CMSC411
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC412'>
    CMSC412
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC414'>
    CMSC414
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC417'>
    CMSC417
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC420'>
    CMSC420
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC421'>
    CMSC421
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC422'>
    CMSC422
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC423'>
    CMSC423
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC424'>
    CMSC424
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC426'>
    CMSC426
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC427'>
    CMSC427
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC430'>
    CMSC430
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC433'>
    CMSC433
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC434'>
    CMSC434
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC435'>
    CMSC435
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC436'>
    CMSC436
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC451'>
    CMSC451
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC452'>
    CMSC452
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC456'>
    CMSC456
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC460'>
    CMSC460
  </label>
  <label class='checkbox'>
    <input type='checkbox' name='taken[]' value='CMSC466'>
    CMSC466
  </label>
  <input type='hidden' name='page' value='2'>
  <input type='submit' value='Next'>
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
