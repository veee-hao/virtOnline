<?php
//include "Util.php";
//$vnc_port=libvirt_domain_get_xml_desc($df->_name2Re["$dname"],"/domain/devices/graphics/@port");
?>
<h2>Virtual Machine</h2>
    <hr>
    <div class="span9">
      <ul>
          <li>Action For This Server</li><br>
          <form index="" method="post" >
        <?php
        if ($dm->state == VIR_DOMAIN_SHUTOFF) {
            echo ('<a href="index.php?dname='.$dname.'&oper=start" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-off"></i><br>Start</a>');
        } else if( $dm->state == VIR_DOMAIN_RUNNING ) {
            echo ('<a href="index.php?dname='.$dname.'&oper=shutdown" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-off"></i><br>Shutdown</a>');
        } else {
            echo ('<a role="button" class="btn disabled" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-off"></i><br>Shutdown</a>');
	}
        if ($dm->state == VIR_DOMAIN_RUNNING) {
            echo ('<a href="index.php?dname='.$dname.'&oper=pause" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-pause"></i><br>Pause</a>');
        } else if ($dm->state == VIR_DOMAIN_PAUSED) {
            echo ('<a href="index.php?dname='.$dname.'&oper=resume" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-play"></i><br>Resume</a>');
        } else {
            echo ('<a href="index.php?dname='.$dname.'&oper=pause" role="button" class="btn disabled" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-pause"></i><br>Pause</a>');
	}
        if ($dm->state == VIR_DOMAIN_RUNNING) {
            echo ('<a href="index.php?dname='.$dname.'&oper=reset" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-refresh"></i><br>Reboot</a>');
        } else {
            echo ('<a href="index.php?dname='.$dname.'&oper=shutdown" role="button" class="btn disabled" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-refresh"></i><br>Reboot</a>');
        }
	if ($dm->state == VIR_DOMAIN_SHUTOFF) {
            echo ('<a href="index.php?dname='.$dname.'&oper=delete" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-remove"></i><br>Delete</a>');
        } else {
            echo ('<a href="index.php?dname='.$dname.'&oper=delete" role="button" class="btn disabled" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-remove"></i><br>Delete</a>');
	}
        if ( !isset($_GET['vnc']) && ($dm->state == VIR_DOMAIN_RUNNING || $dm->state == VIR_DOMAIN_PAUSED) ) {
//            echo ('<a href="index.php?dname='.$dname.'&oper=console" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-align-justify"></i><br>Console</a>');
            echo ("<a href=\"index.php?dname=".$dname.'&vnc=true" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-align-justify"></i><br>Console</a>');
//            echo ('<a href="indexphp?dname='.$dname.'&oper=snapshot" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-download-alt"></i><br>Snapshot</a>');
        } else {
            echo ('<a href="index.php?dname='.$dname.'" role="button" class="btn" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-align-justify"></i><br>VM Info</a>');
//            echo ('<a href="index.php?dname='.$dname.'&oper=snapshot" role="button" class="btn disable" data-toggle="modal" style="height:40px;width:60px;"><i class="icon-download-alt"></i><br>Snapshot</a>');
	}  
      ?>
          </form>
<?php
if ( isset($_GET['vnc'])) {
$vnc_port=$df->get_vnc_port($dname);
$_SESSION['vnc'] = "true";
?>
</ul>
</div> <!-- /span9 -->
  <div id="vncviewer" >
<!--    <applet archive="/static/java/vncviewer.jar" code="com.tightvnc.vncviewer.VncViewer" width="800" height="600">
    <applet archive="lib/vncviewer.jar" code="com.tightvnc.vncviewer.VncViewer" width="700" height="550">
--><applet archive="lib/vncviewer.jar" code="com.tightvnc.vncviewer.VncViewer" width="700" height="550">
      <param name="SOCKETFACTORY" value="com.tightvnc.vncviewer.SshTunneledSocketFactory">
      <param name="Scaling factor" value="auto">
      <param name="sshHost" value=<?php echo $_SESSION['server_address'];?>>
      <param name="sshUser" value="root" />
      <param name="HOST" value="localhost">
      <param name="PORT" value=<?php echo $vnc_port;?>>
      Sorry, the VNC Applet could not be started. Please make sure that Java 1.4.2 (or later) is installed and active in your browser (<a href="http://java.sun.com/getjava">Click here to install Java now</a>)
    </applet>
  <div>
<?php
} else {
unset($_SESSION['vnc']);
?>
          <hr>
          <li>Name & Status</li><br>
          <div class="pagination-centered">
                <p><b>Name:</b><?php echo $dname; ?> </p>
                <p><b>Status:</b> <?php echo getDomainStateStr($dm->state); ?></p>
                <p><b>Uptime:</b>  (Min)</p>
          </div>
          <hr>
          <li>Technical Details</li><br>
          <div class="pagination-centered">
                <p><b>VCPU:</b>  <?php echo $dm->name ?>  </p>
                <p><b>RAM:</b> <?php echo $dm->memory ?> KB</p>
<!--
                <p><b>MAC:</b>  dom_info.2  ( dom_info.3 )</p>
-->
                <p><b>HDD:</b><?php echo $dm->disks[0]?></p>
          </div>
        <hr>
        <li>Media Details</li><br>
        <div class="pagination-centered">
              <b>Connected Image:</b> 
              <form index="" method="post">
                <br>
                <input type="hidden" name="iso_img" value=" media ">
                <input type="submit" class="btn"  name="remove_iso" value="Disconnect" onclick="return confirm('Are you sure?')">
                <b>Images:</b> 
		  <select name="iso_img" class="input-large">
                      <option value="none">None</option>
                      <option value=" iso ">{{ iso }}</option>
                  </select>
                <br />
                <a class="btn disabled" name="connect">Connect</a>
              </form>
        </div>
      </ul>
    </div> <!-- /span9 -->
<?php } ?>
