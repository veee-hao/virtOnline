<?php
//include "domain/DomainFactory.php";
if ( isset($_GET['dname']) && !empty($_GET['dname']) ) { 
    $dname=$_GET['dname'];
    require("include/conn.php");
    $dm = $df->retriveDomain($dname);
}
if ( isset($_GET['oper']) && !empty($_GET['oper']) ) {
    $oper= $_GET['oper'];
    echo "$oper";
    switch ($oper)
    {
        case 'start':
            $ret = $dm->startDomain();
            break;
        case 'resume':
            $ret = $dm->resumeDomain();
            break;
        case 'pause':
            $ret = $dm->suspendDomain();
            break;
        case 'shutdown':
            $ret = $dm->shutdownDomain();
            break;
        case 'reset':
            $ret = $dm->rebootDomain();
            break;
        case 'delete':
            $ret = $df->destoryDomain($dname);
            break;
//        case 'conn':
//            $_SESSION["connected"]="";
//	    header("location:index-jhao.php");
//	    exit;
//            break;
    }
    if ( !$ret ) {
	echo "$oper $dname failed";
    }
    if ( isset($_SESSION['vnc']) ) {
        if ( $oper == 'delete' ) {
            header("location:index.php");
	} else {
	    header("location:index.php?dname=$dname&vnc=true");
    	}
    } else {
        if ( $oper == 'delete' ) {
	    header("location:index.php");
	} else {
            header("location:index.php?dname=$dname");
	}
    }
    exit;
}
?>
