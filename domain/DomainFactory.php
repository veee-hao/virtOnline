<?php

include "Domain.php";
include "xml.php";

    class DomainFactory
    {
        // connection resource 
        private $_conn = NULL;

       // private $_name2Re = NULL;
        private $_name2Re = NULL;

        public $domains = NULL;
        
        public function __construct($conn) 
        {
            if (isset($conn))
            {
                $this->_conn = $conn;
                $this->_initName2ResourceMap();
            }
            else
                $this->_conn = null;
        }
        
        private function _initName2ResourceMap()
        {    
            if (isset($this->_name2Re))
                return;

            $resources = libvirt_list_domain_resources($this->_conn);
            foreach ($resources as $res)
            {
                $name = libvirt_domain_get_name($res);
                $this->_name2Re[$name] = $res;
            }
        } 


        function getDomains()
        {
            $domains = array();
            if (!$this->_conn)
            {
                return  $domains;
            }

            $resources = libvirt_list_domain_resources($this->_conn);
            foreach ($resources as $res)
            {
                $name = libvirt_domain_get_name($res);
                $id = libvirt_domain_get_id($res);
                $info = libvirt_domain_get_info($res);
                $nics = libvirt_domain_get_interface_devices($res);
                $disks = libvirt_domain_get_disk_devices($res);
                $d = new Domain($name, $id, $info, $nics, $disks);
                $d->setResource($res);
                array_push($domains, $d);

                if (!isset($this->domains))
                {
                    $this->domains = array();
                }
                if (!isset($this->domains[$name]))
                {
                    $this->domains[$name] = $d;
                }
            }
            return $domains;
        }

        function retriveDomain($name)
        {
            if (!$this->domains)
            {
                $this->getDomains();
            }

            return $this->domains[$name];
        }
	function getDomainRes($name)
	{
            if (!$this->domains)
            {
                $this->getDomains();
            }
	    return $this->_name2Re[$name];
	}
	function get_vnc_port($name)
        {
                return libvirt_domain_get_xml_desc($this->getDomainRes($name), "/domain/devices/graphics/@port");
        }    
        function destoryDomain($name)
        {
            $res = libvirt_domain_lookup_by_name($this->_conn, $name);
            if (isset($res))
            {
		$info = libvirt_domain_get_info($res);
		if ($info['state'] == VIR_DOMAIN_RUNNING ) {
            		$ret = libvirt_domain_destroy($res);
			if (!$ret ) { 
				echo "destroy domain failed.";
				return false;
			}
		}
	        return libvirt_domain_undefine($res);
            } else {
		return false;
	    }
        }
	function getNetwork() {
		if ( !$this->_conn ) {
			echo "please setup connection";
			return null;
		} else {
			return libvirt_list_networks($this->_conn, VIR_NETWORKS_ALL);
		}
	}
	function genXML($repo,$linux,$initrd,$vm_name,$autoyast)
	{
		$xml = DOM_XML;
		if ( !empty($autoyast) ) {
			$autoyast = "autoyast=".$autoyast;
		}
		$pattern = array("/INSTALL-LINUX/","/INSTALL-INITRD/","/INSTALL-REPO/","/INSTALL-NAME/","/INSTALL-YAST/");
		$replace = array($linux,$initrd,$repo,$vm_name,$autoyast);
		$xml = preg_replace($pattern,$replace,$xml);
		return $xml;
	}
	function storage_CreateXML($vm_name)
	{
		$xml = VM_DISK; 
		$xml = preg_replace("/INSTALL-NAME/",$vm_name,$xml);
		$res = libvirt_storagepool_lookup_by_name($this->_conn,"default");
		$ret = libvirt_storagepool_set_autostart($res,true);
		$vol = libvirt_storagevolume_create_xml($res, $xml);
		$uuid = libvirt_storagepool_get_uuid_string($res);
		return $uuid;
	}
        function createDomain($repo,$linux,$initrd,$vname,$autoyast)
        {
		$uuid = $this->storage_CreateXML($vname);	
		$xml = $this->genXML($repo,$linux,$initrd,$vname,$autoyast);
		$res = libvirt_domain_define_xml($this->_conn,$xml);
        	$ret = libvirt_domain_set_autostart($res, true);
		$ret = libvirt_domain_create($res);	
		if ( $ret ) {
			echo "starting creating...";
			libvirt_domain_change_boot_devices($res,"hd","cdrom");
			$pid = pcntl_fork();
			if ( $pid == -1 ) {
				echo "can not start fork";
			} else if ( $pid ) {
				
			} else {
				$info = libvirt_domain_get_info($res);
				while ($info['state'] == VIR_DOMAIN_RUNNING ) {
					sleep(3);
					$info = libvirt_domain_get_info($res);
				}
				$ret = libvirt_domain_create($res);
				if ( !$ret ) {
					echo "can not restart";
				}
			}
			return true;	
		} else {
			echo "Cannot start new vm";
			return false;
		}
	}
    }
