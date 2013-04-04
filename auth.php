<?php
/*
 * Direct users to this page and they will be forced to login
 * through the UMD CAS.  Will redirect to homepage on success
 * and output error on failure (or something).
 */

require_once './CAS/config.php';
require_once './CAS.php';

phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

//Comment this out for production.
//phpCAS::setCasServerCACert($cas_server_ca_cert_path);

//Comment this out for testing.
phpCAS::setNoCasServerValidation();

if( isset($_REQUEST['logout']) ) {
  phpCAS::handleLogoutRequests();
  phpCAS::logout();
} else if( isset($_REQUEST['login']) ) {
  phpCAS::forceAuthentication();
}

header('Location: http://eric.zinnikas.org/schedshell/');
?>
