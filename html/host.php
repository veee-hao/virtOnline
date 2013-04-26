<?php
//include ("lib/Host.php");

$h = new Host();
//echo $h->model;
$v = libvirtVersion();
?>

<h2>Overview</h2>
<hr>
<div class='row-fluid'>
  <div class='span5'>
    <p>Host IP</p>
    <p>Architecture</p>
    <p>Processor(s)</p>
    <p>CPU utilization</p>
    <p>Memory </p>
    <p>Type connection</p>
    <p>Libvirt version</p>
  </div>
  <div class='span6'>
    <p><?php echo retriveServerAddr();?> </p>
    <p><?php echo $h->model ?></p>
    <p> <?php echo $h->totalCpuNo?> </p>
    <p>Usage:  cpu_usage </p>
    <p> <?php echo $h->totalMemory?> KB</p>
    <p> qemu </p>
    <p><?php echo $v;?></p>
  </div>
</div>
