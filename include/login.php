<?php
if ( isset($_REQUEST['Connect']) ) {
	$_SESSION['server_address'] = $_REQUEST['host_ip'];
	$_SESSION['server_pass'] = $_REQUEST['rootpw'];
	$_SESSION['hypervisor'] = $_REQUEST['hypervisor'];
	$_SESSION['transfertype'] = $_REQUEST['transfertype'];
	$_SESSION['connected'] = "true";
}
?>
