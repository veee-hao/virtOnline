  <body>
   <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">Virt-Online</a>
        </div><!--/.container -->
      </div><!--/.navbar-inner -->
    </div><!--/.navbar -->      
    <div class="container-narrow">
      <form class="form-signin" method="post" action="index.php" method="POST">
        <h3></h3>
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="username">Host IP:</label>
            <div class="controls">
              <input class="input-xlarge" id="host_ip" type="text" name="host_ip" maxlength="30" tabindex="1">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="rootpw">Root password:</label>
            <div class="controls">
              <input class="input-xlarge" id="rootpw" type="text" name="rootpw" maxlength="30" tabindex="1">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="hypervisor">Hypervisor</label>
            <select name="hypervisor" class="input-large">
                <option value="qemu">qemu</option>
                <option value="xen">xen</option>
            </select>
	  </div>
          <div class="control-group">
            <label class="control-label" for="transfertype">Transfertype</label>
            <select name="transfertype" class="input-large">
                <option value="tcp">tcp</option>
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
          <button type="submit" name="Connect" id="Connect" class="btn btn-success btn-large">Connect</button>
        </div>
      </form>
    </div> <!-- /container-narrow -->

