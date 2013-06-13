<?php
include("lib/Host.php");
include "domain/DomainFactory.php";
if ( !isset($_SESSION['connected']) || empty($_SESSION['connected']) || isset($_GET['reconn']) ) {
	require("html/connect.php");
} else if ( isset($_REQUEST['newvm']) && !isset($_REQUEST['createvm']) ) {
	require("include/conn.php");
	require("html/newvm.php");
} else {
?>
<div class="container-narrow">
    <div class="container-fluid">
        <div class="row-fluid">
<?php
$dname="";
if ( isset($_REQUEST['dname']) && $dname != $_REQUEST['dname'] ) {
        $dname = $_REQUEST['dname'];
}
//	include("lib/Host.php");
//	include "domain/DomainFactory.php";
	require("include/action.php");
	require("nav.php");
	require("show.php");
?>
        </div><!--/row-fluid-->
    </div><!--/container-fluid-->
</div> <!-- /container-narrow -->
<?php } ?>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/ext.js"></script>
