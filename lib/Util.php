<?php

function connect2Server($hypervisor, $transferType, $address, $user=null, $readOnly)
{
    //$url = "qemu+tcp://147.2.207.67/system";
    if (!isset($address))
    {
        $address = retriveServerAddr();
//        $address = "147.2.207.67";
//        print "address -------------------$address\n";
    }

    $url = $hypervisor . "+" .$transferType . "://" . $address ."/system";
    $conn = libvirt_connect($url, $readOnly);
    return $conn;
}

function retriveServerAddr()
{

     if (isset($_SESSION['server_address']))
     {
         return $_SESSION['server_address'];
     }
}

function libvirtVersion()
{
    $v = libvirt_version();
    $s_v = $v['libvirt.major']. "." . $v['libvirt.minor'] .".". $v['libvirt.release'];

    return $s_v;
}

function getDomainStateStr($state)
{
    $stateStr = "No State";
    $stateStr = "<font color='grey'>$stateStr</font>";
    if (!isset($state))
    {
        return $stateStr;
    }
    switch ($state)
    {
        case VIR_DOMAIN_RUNNING:
            $stateStr = 'Running';
            $stateStr = "<font color='green'>$stateStr</font>";
            break;

        case VIR_DOMAIN_BLOCKED:
            $stateStr = 'Blocked';
            $stateStr = "<font color='grey'>$stateStr</font>";
            break;

        case VIR_DOMAIN_PAUSED:
            $stateStr = 'Suspend';
            $stateStr = "<font color='orange'>$stateStr</font>";
            break;
        
        case VIR_DOMAIN_SHUTDOWN:
            $stateStr = 'Shutdown';
            $stateStr = "<font color='grey'>$stateStr</font>";
            break;
        
        case VIR_DOMAIN_SHUTOFF:
            $stateStr = 'Shut Off';
            $stateStr = "<font color='red'>$stateStr</font>";
            break;
            
        case VIR_DOMAIN_CRASHED:
            $stateStr = 'Crashed';
            break;

        default:
            break;
    }

    return $stateStr;
}

