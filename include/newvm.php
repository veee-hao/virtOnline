<?php
if ( isset($_REQUEST['create_vm']) ) {
	$repo = $_REQUEST['repo'];
	$vname = $_REQUEST['name'];
	$autoyast = $_REQUEST['autoyast'];
	$ram = $_REQUEST['ram'];
	$disk = $_REQUEST['disk'];
	$net = $_REQUEST['net'];
	$bootld = '/boot/arch/loader/';
	$myrand = rand(1000,10000);
	$vlinux = '/tmp/linux'.$myrand;
	$vinitrd = '/tmp/initrd'.$myrand;
	preg_match("/(i\d86|x86[_-]64)/i",$repo,$matches);
	echo "arch:".$matches[1];
	if ( !empty($matches[1]) ) {
		if ( preg_match("/i\d86/i",$matches[1]) ) {
			$matches[1] = "i386";
		}
		$bootld = preg_replace("/arch/",$matches[1],$bootld);
	} else {
		echo "Can not get arch from $repo";
	}
	$sshcmd = "sshpass -p ".$_SESSION['server_pass']." ssh -o StrictHostKeyChecking=no root@".$_SESSION['server_address']." ";
	$cmd = $sshcmd."wget -O $vlinux $repo".$bootld."linux >/dev/null";
	system($cmd,$ret);
	if ( $ret != 0 ) {
		echo "Get kernel failed from $repo";
		echo "by $cmd";
	}
	$cmd = $sshcmd."wget -O $vinitrd $repo".$bootld."initrd >/dev/null";
	system($cmd,$ret);
	if ( $ret != 0 ) {
		echo "Get initrd failed from $repo";
	}
	$ret = $df->createDomain($repo,$vlinux,$vinitrd,$vname,$autoyast);
	if ( $ret ) {
		header("location: index.php?dname=$vname");
		exit();
	}
}
?>
		
