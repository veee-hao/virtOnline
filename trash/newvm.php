<?php
include "domain/DomainFactory.php";
include "lib/Host.php";
//require("include/conn.php");

$conn = connect2Server("qemu","tcp","147.2.207.67",NULL,false);
if (isset($conn))
{
    $df = new DomainFactory($conn);
}

$df->storage_CreateXML();

