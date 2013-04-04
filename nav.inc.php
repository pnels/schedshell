<?php

require_once './CAS/config.php';
require_once './CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
//phpCAS::setCasServerCACert($cas_server_ca_cert_path);
phpCAS::setNoCasServerValidation();

function printNavbar($name) {
$index_active = '';
if($name == "index") { $index_active = "class='active'"; }
$user = '';
$login = '';
if( phpCAS::checkAuthentication() ) { 
  $user = 'Welcome ' . phpCAS::getUser();
  $login = "'account.php'";
} else {
  $user = 'Sign In';
  $login = "'login.php'";
}
$navbar = <<< NAV
<div class='navbar navbar-fixed-top'>
    <div class='navbar-inner'>
      <div class='container-fluid'>
        <a style="max-height: 40px; overflow: visible; padding-top: 5px; padding-bottom: 0;" href='search.php' class='brand'><img src='img/slogo50.png' /><span style="margin-top: 10px; padding-left: 15px; position: relative; top: 5px;">SCHEDSHELL</span></a>
        <p class='pull-right'><a href=$login class='btn btn-primary'>$user</a></p>
        <ul class='nav'>
          <li><a $index_active href='search.php'>Home</a></li>
          <li><a href='#'>My Account</a></li>
          <li><a href='#'>About</a></li>
        </ul>
      </div>
    </div>
  </div>    
NAV;

echo $navbar;
}

function printNavlist($name) {
$index = "";
$semester = "";
$goals = "";
$cumulative = "";
$predict = "";

if($name == 'index') {
  $index = "class='active'";
} elseif ($name == 'semester') {
  $semester = "class='active'";
} elseif ($name == 'goals') {
  $goals = "class='active'";
} elseif ($name == 'cumulative') {
  $cumulative = "class='active'";
} elseif ($name == 'predict') {
  $predict = "class='active'";
}


$navlist = <<< LIST
  <div class='span2'>
    <div class='well sidebar-nav'>
      <ul class='nav nav-list'>
        <li class='nav-header'>Tools</li>
        <li $index ><a href='search.php'>Home</a></li>
        <li class='active' ><a href='search.php'>Prerequisite Search</a></li>
        <!-- <li $semester ><a href='semester.php'>Semester GPA</a></li> -->
        <!-- <li $goals ><a href='goals.php'>GPA Goals</a></li> -->
        <!-- <li $cumulative ><a href='cumulative.php'>Cumulative GPA</a></li> -->
        <!-- <li $predict ><a href='predict.php'>GPA Trends</a></li> -->
        <li class='nav-header'>Navigation</li>
        <li><a href='#'>My Account</a></li>
        <li><a href='#'>Log Out</a></li>
      </ul>
    </div>
  </div>
LIST;

echo $navlist;
}
?>
