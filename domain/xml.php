<?php
define("AUTOYAST",
"<volume>
  <name>INSTALL-YAST</name>
  <key>/tmp/INSTALL-YAST</key>
  <source>
  </source>
  <capacity>1048576</capacity>
  <allocation>143360</allocation>
  <target>
    <path>/tmp/INSTALL-YAST</path>
    <format type='raw'/>
    <permissions>
      <mode>0600</mode>
      <owner>0</owner>
      <group>0</group>
    </permissions>
  </target>
</volume>");
define("VM_DISK",
"<volume>
  <name>INSTALL-NAME.raw</name>
  <key>/var/lib/libvirt/images/INSTALL-NAME.raw</key>
  <source>
  </source>
  <capacity>8589934592</capacity>
  <allocation>143360</allocation>
  <target>
    <path>/var/lib/libvirt/images/INSTALL-NAME.raw</path>
    <format type='raw'/>
    <permissions>
      <mode>0600</mode>
      <owner>0</owner>
      <group>0</group>
    </permissions>
  </target>
</volume>");
define("DOM_XML",
"<domain type='kvm' id='67'>
   <name>INSTALL-NAME</name>
   <memory>524288</memory>
   <currentMemory>524288</currentMemory>
   <vcpu>4</vcpu>
  <os>
    <type arch='x86_64' machine='pc-0.15'>hvm</type>
    <kernel>INSTALL-LINUX</kernel>
    <initrd>INSTALL-INITRD</initrd>
    <cmdline> install=INSTALL-REPO INSTALL-YAST </cmdline>
    <boot dev='hd'/>
    <boot dev='cdrom'/>
    <bootmenu enable='yes'/>
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
      <source file='/var/lib/libvirt/images/INSTALL-NAME.raw'/>
      <target dev='vda' bus='virtio'/>
      <alias name='virtio-disk0'/>
      <address type='pci' domain='0x0000' bus='0x00' slot='0x04' function='0x0'/>
    </disk>
    <interface type='bridge'>
      <source bridge='br0'/>
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
</domain>");
?>
