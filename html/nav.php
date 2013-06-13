<?php
//include "domain/DomainFactory.php";
require("include/conn.php");
$domains = $df->getDomains();
if (isset($_GET['createvm']))
{
	require("include/newvm.php");
	//$df->createDomain();
}
?>
          <div class="span4">
            <div class="well sidebar-nav">
              <ul class="nav nav-list">
                <li class="nav-header">Server Settings</li>
                <li>
                  <a href="index.php"><i class="icon-info-sign"></i> Host Overview</a>
                </li>
                <li><a href="index.php?newvm=true"><i class="icon-plus"></i> Create VM</a></li>
                <li><a href="storage.php"><i class="icon-folder-open"></i> Storage pool</a></li>
                <li><a href="network.php"><i class="icon-signal"></i> Network pool</a></li>
<!--                <li><a href="snapshot.php"><i class="icon-download-alt"></i> Snapshots</a></li>
-->
                <li class="nav-header">Virtual Machines</li>
<?php

echo ('<li onclick="jsfun()"><i class="icon-home"></i><B>-'.$_SESSION['server_address'].'</B></li>');
echo ('<div id="ChildUL" style="display:block;">');
echo ('<table>');
foreach ($domains as $vm) {
	echo ('<tr><td>');
	if ( $dname == $vm->name) {
		echo ('<li class="active">');
	}
	echo ('&nbsp&nbsp&nbsp&nbsp|-<icon class="icon-th-large"></icon><a href="index.php?dname='.$vm->name.'">'.$vm->name);
	if ( $dname == $vm->name) {
		echo ('</li>');
	}
	echo ("</a></td>");
	echo ('<td style="text-align:center">');
	switch ($vm->state) {
		case VIR_DOMAIN_RUNNING:
			echo ('<font color="green">Running</font>');
			break;
		case VIR_DOMAIN_SHUTOFF:
			echo ('<font color="red">Shutoff</font>');
			break;
		case VIR_DOMAIN_PAUSED:
			echo ('<font color="orange">Suspend</font>');
			break;
		default:
			echo ('<font color="grey">Unknown</font>');
	}
	echo ('</td></tr>');
}
echo ('</table></div>');    
?>
              </ul>
            </div><!--/.well -->
          </div><!--/span-->
