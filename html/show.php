<div class="span8 well">
<?php
//$dname="";
//if ( isset($_REQUEST['dname']) && $dname != $_REQUEST['dname'] ) {
//        $dname = $_REQUEST['dname'];
//}

if ( empty($dname) ) {
	require("html/host.php");
} else {
	require("include/conn.php");
	$dm = $df->retriveDomain($dname);
	require("html/detail.php");
}
?>
</div><!--/span-->

