<html>
<head>
<?php
	$host_ipaddr = $_GET['host_ip'];
	$vnc_passwd = $_GET['vnc_passwd'];
	$vnc_port = $_GET['vnc_port'];

if ( !empty($vnc_passwd) ) {
?>
  <link rel="shortcut icon" href="../images/favicon.ico">
  <link rel="stylesheet" href="../js/novnc/base.css" title="plain">
  <!--
  <script type='text/javascript' 
      src='http://getfirebug.com/releases/lite/1.2/firebug-lite-compressed.js'></script>
  -->
  <script src="../js/novnc/util.js"></script>
</head>

<body style="margin: 0px;">
  <div id="noVNC_screen">
    <div id="noVNC_status_bar" class="noVNC_status_bar" style="margin-top: 0px;">
      <table border=0 width="100%">
        <tr>
          <td>
            <div id="noVNC_status">Loading</div>
          </td>
          <td width="1%">
            <div id="noVNC_buttons">
              <input type=button value="Ctrl+Alt+Del" id="sendCtrlAltDelButton">
            </div>
          </td>
        </tr>
      </table>
        </div>
        <canvas id="noVNC_canvas" width="640px" height="20px">
          Canvas not supported.
        </canvas>
    </div>
<?php
	$host_ipaddr = $_GET['host_ip'];
?>
    <script>
    /*jslint white: false */
    /*global window, $, Util, RFB, */
    "use strict";

    // Load supporting scripts
    Util.load_scripts(["webutil.js", "base64.js", "websock.js", "des.js",
                       "input.js", "display.js", "jsunzip.js", "rfb.js"]);

    var rfb;

    function passwordRequired(rfb) {
        var msg;
        msg = '<form onsubmit="return setPassword();"';
        msg += '  style="margin-bottom: 0px">';
        msg += 'Password Required: ';
        msg += '<input type=password size=10 id="password_input" class="noVNC_status">';
        msg += '<\/form>';
        $D('noVNC_status_bar').setAttribute("class", "noVNC_status_warn");
        $D('noVNC_status').innerHTML = msg;
    }
    function setPassword() {
        rfb.sendPassword($D('password_input').value);
        return false;
    }
    function sendCtrlAltDel() {
        rfb.sendCtrlAltDel();
        return false;
    }
    function updateState(rfb, state, oldstate, msg) {
        var s, sb, cad, level;
        s = $D('noVNC_status');
        sb = $D('noVNC_status_bar');
        cad = $D('sendCtrlAltDelButton');
        switch (state) {
            case 'failed':       level = "error";  break;
            case 'fatal':        level = "error";  break;
            case 'normal':       level = "normal"; break;
            case 'disconnected': level = "normal"; break;
            case 'loaded':       level = "normal"; break;
            default:             level = "warn";   break;
        }

        if (state === "normal") { cad.disabled = false; }
        else                    { cad.disabled = true; }

        if (typeof(msg) !== 'undefined') {
            sb.setAttribute("class", "noVNC_status_" + level);
            s.innerHTML = msg;
        }
    }

    window.onscriptsload = function () {
        var host, port, password, path, token;

        $D('sendCtrlAltDelButton').style.display = "inline";
        $D('sendCtrlAltDelButton').onclick = sendCtrlAltDel;

        WebUtil.init_logging(WebUtil.getQueryVar('logging', 'warn'));
        document.title = unescape(WebUtil.getQueryVar('title', 'noVNC'));
        // By default, use the host and port of server that served this file
        host = <?php echo $host_ipaddr;?>;
        port = '6080'
        password = <?php echo $vnc_passwd;?>;

        if ((!host) || (!port)) {
            updateState('failed',
                "Must specify host and port in URL");
            return;
        }

        rfb = new RFB({'target':       $D('noVNC_canvas'),
                       'encrypt':      WebUtil.getQueryVar('encrypt',
                                (window.location.protocol === "https:")),
                       'repeaterID':   WebUtil.getQueryVar('repeaterID', ''),
                       'true_color':   WebUtil.getQueryVar('true_color', true),
                       'local_cursor': WebUtil.getQueryVar('cursor', true),
                       'shared':       WebUtil.getQueryVar('shared', true),
                       'view_only':    WebUtil.getQueryVar('view_only', false),
                       'updateState':  updateState,
                       'onPasswordRequired':  passwordRequired});
        rfb.connect(host, port, password, path);
    };
    </script>
<?php
} else {
?>
  <title>VNC</title>
  <style type='text/css'>
/*    #vncviewer { 
      min-width: 799px; 
      max-width: 799px;
      min-height: 628px;
      max-height: 628px;
      border: 1px #fff solid;
      background: #ccc;
      text-align: center;
      font-color: #f00;
    } 
 */
/*    body { 
      background: #fff; 
      text-align: center;
    }
*/
  </style>
</head>
<body>
  <div id="vncviewer" align="center">
<!--    <applet archive="/static/java/vncviewer.jar" code="com.tightvnc.vncviewer.VncViewer" width="800" height="600">
-->    <applet archive="lib/vncviewer.jar" code="com.tightvnc.vncviewer.VncViewer" width="700" height="550">
      <param name="SOCKETFACTORY" value="com.tightvnc.vncviewer.SshTunneledSocketFactory">
      <param name="Scaling factor" value="auto">
      <param name="SSHHOST" value=<?php echo $host_ipaddr;?>>
      <param name="HOST" value="localhost">
      <param name="sshUser" value="root">
      <param name="PORT" value=<?php echo $vnc_port;?>>
      Sorry, the VNC Applet could not be started. Please make sure that Java 1.4.2 (or later) is installed and active in your browser (<a href="http://java.sun.com/getjava">Click here to install Java now</a>)
    </applet>
  </div>
<?php } ?>
</body>
</html>
