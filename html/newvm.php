  <body>
   <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">Virt-Online</a>
        </div><!--/.container -->
      </div><!--/.navbar-inner -->
    </div><!--/.navbar -->      
    <div class="container-narrow">
      <form class="form-signin" method="post" action="index.php?createvm=true" method="POST">
        <h3></h3>
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="name">VM name</label>
            <div class="controls">
              <input class="input-xlarge" id="name" type="text" name="name" maxlength="20" tabindex="1">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="repo">Repo URL</label>
            <div class="controls">
              <input class="input-xlarge" id="repo" type="text" name="repo" maxlength="100" tabindex="1">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="autoyast">Autoyast file</label>
            <div class="controls">
              <input class="input-xlarge" id="autoyast" type="text" name="autoyast" maxlength="100" tabindex="1">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="ram">RAM</label>
            <select name="ram" class="input-large">
<?php
	$host = new Host();
	$ramG = $host->totalMemory/1000000;
	for ( $i=1,$opram=1;$opram<$ramG;$i++) {
		echo '<option value="'.$opram.'G">'.$opram.'G</option>';
		$opram = pow(2,$i);
	}
?>
            </select>
          </div>
          <div class="control-group">
            <label class="control-label" for="disk">Disk</label>
            <select name="disk" class="input-large">
                <option value="1">4G</option>
                <option value="2">8G</option>
            </select>
          </div>
          <div class="control-group">
            <label class="control-label" for="net">Network</label>
            <select name="net" class="input-large">
	         <option value="br0">br0</option>";
<?php
	$networks = $df->getNetwork();
	foreach ( $networks as $net ) {
		echo '<option value="'.$net.'">'.$net.'</option>';
	}
?>
            </select>
          </div>
<!---
          <div class="control-group">
            <label class="control-label" for="password">SSH Passwd</label>
            <div class="controls">
              <input class="input-xlarge" type="password" name="password" id="id_password" tabindex="2">
              <input name="next" id="next" type="hidden" value="/dashboard/">
            </div>
          </div>
-->
        </fieldset>
        <div class="controls">
          <button type="submit" name="create_vm" id="create_vm" class="btn btn-success btn-large">Create</button>
        </div>
      </form>
    </div> <!-- /container-narrow -->

