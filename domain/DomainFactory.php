<?php

include "Domain.php";

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
               return libvirt_domain_destroy($res); 
            }
        }
	function genXML()
	{
/*
	    $xml = "<domain type=$inst['domain_type']>\n";
	    $xml .= "<name>$inst['name']</name>\n";
	    $xml .= "<memory>$inst['ram']</memory>\n";
	    $xml .= "<currentMemory>$inst['ram']</currentMemory>\n";
	    $xml .= "<vcpu>$inst['vcpu']</vcpu>";
*/	    $xml = <<<EOF
 <domain type='kvm' id='67'>
   <name>vmOnline-autoinstall</name>
   <uuid>5f8aef11-cdb0-d634-3872-4bdf303cb648</uuid>
   <memory>524288</memory>
   <currentMemory>524288</currentMemory>
   <vcpu>4</vcpu>
  <os>
    <type arch='x86_64' machine='pc-0.15'>hvm</type>
    <kernel>/tmp/kernel</kernel>
    <initrd>/tmp/install-initrd</initrd>
    <cmdline> install=http://147.2.207.240/repo/sles-11-sp2-x86_64 </cmdline>
    <boot dev='cdrom'/>
  </os>
  <features>
    <acpi/>
    <apic/>
    <pae/>
  </features>
  <clock offset='utc'/>
  <on_poweroff>destroy</on_poweroff>
  <on_reboot>destroy</on_reboot>
  <on_crash>destroy</on_crash>
  <devices>
    <emulator>/usr/bin/qemu-kvm</emulator>
    <disk type='file' device='disk'>
      <driver name='qemu' type='raw'/>
      <source file='/var/lib/libvirt/images/vmOnline-autoinstall.raw'/>
      <target dev='vda' bus='virtio'/>
      <alias name='virtio-disk0'/>
      <address type='pci' domain='0x0000' bus='0x00' slot='0x04' function='0x0'/>
    </disk>
    <interface type='bridge'>
      <mac address='52:54:00:5c:aa:59'/>
      <source bridge='br0'/>
      <target dev='vnet3'/>
      <model type='virtio'/>
      <alias name='net0'/>
      <address type='pci' domain='0x0000' bus='0x00' slot='0x03' function='0x0'/>
    </interface>
    <input type='mouse' bus='ps2'/>
    <graphics type='vnc' port='5900' autoport='yes'/>
    <video>
      <model type='cirrus' vram='9216' heads='1'/>
      <alias name='video0'/>
      <address type='pci' domain='0x0000' bus='0x00' slot='0x02' function='0x0'/>
    </video>
    <memballoon model='virtio'>
      <alias name='balloon0'/>
      <address type='pci' domain='0x0000' bus='0x00' slot='0x06' function='0x0'/>
    </memballoon>
  </devices>
</domain>
EOF;
	return $xml;
	}
	public function storage_CreateXML()
	{
		$xml = <<<EOF
<volume>
  <name>vmOnline-autoinstall.raw</name>
  <key>/var/lib/libvirt/images/vmOnline-autoinstall.raw</key>
  <source>
  </source>
  <capacity>8589934592</capacity>
  <allocation>143360</allocation>
  <target>
    <path>/var/lib/libvirt/images/vmOnline-autoinstall.raw</path>
    <format type='raw'/>
    <permissions>
      <mode>0600</mode>
      <owner>0</owner>
      <group>0</group>
    </permissions>
  </target>
</volume>
EOF;
		$res=libvirt_storagepool_lookup_by_name($this->_conn,"default");
		$vol = libvirt_storagevolume_create_xml($res, $xml);
	}
        function createDomain()
        {
		$xml = $this->genXML();
		$res = libvirt_domain_define_xml($this->_conn,$xml);
		$this->storage_CreateXML();	
		$ret = libvirt_domain_create($res);	
        	$ret = libvirt_domain_set_autostart($res, true);
		if ( $ret ) {
			echo "starting creating...";
		} else {
			echo "Cannot start new vm";
		}
	}
    }
