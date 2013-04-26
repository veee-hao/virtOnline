<?php
//include("lib/Util.php");
$conn = connect2Server($_SESSION['hypervisor'],$_SESSION['transfertype'],$_SESSION['server_address'],NULL,false);
if (isset($conn))
{
    $df = new DomainFactory($conn);
}
?>
