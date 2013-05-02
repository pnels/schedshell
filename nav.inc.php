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
  $login = "'auth.php?login'";
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
  $preclass = '';
  $planclass= '';

if($name == 'pre') {
  $preclass = "class='active'";
} elseif ($name == 'plan') {
  $planclass = "class='active'";
}


$navlist = <<< LIST
  <div class='span2'>
    <div class='well sidebar-nav'>
      <ul class='nav nav-list'>
        <li class='nav-header'>Tools</li>
        <li><a href='index.php'>Home</a></li>
        <li $preclass ><a href='search.php'>Prerequisite Search</a></li>
        <li $planclass ><a href='plan.php'>Four Year Plan</a></li>
        <li class='nav-header'>Navigation</li>
        <li><a href='account.php'>My Account</a></li>
        <li><a href='auth.php?logout'>Log Out</a></li>
      </ul>
    </div>
  </div>
LIST;

echo $navlist;
}
?>
