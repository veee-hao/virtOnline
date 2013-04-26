<?php
include "Util.php";

    class Host 
    {
        //inactive domain have no id
        private $_conn = NULL; 

        public $name = "";
        
        // the architecture of the physical host
        public $model = "";

        // the total physical memroy of the host, unit in byte.
        public $totalMemory = 0;

        public $totalCpuNo = 0;

        public $cpuSpeed = 0;

        //the statistic information of Memory 
        public $memStats = NULL;

        // the statistic information of CPU 
        public $cpuStats = NULL;
        


        function __construct()
        {
            //$this->name = $name;
            $this->_hconn();
            $this->_initHostInfo();
            $this->_initMemoryStats();
            $this->_initCpuStats();
        }
        private function _hconn()
        {
//	    global $server_address, $hypervisor, $transfertype;
            if (!isset($this->_conn))
            {
//                $address = retriveServerAddr();
                $this->_conn = connect2Server($_SESSION['hypervisor'], $_SESSION['transfertype'], $_SESSION['server_address'], NULL, true);
            }
	}
        private function _initHostInfo()
        {
/*
	    global $server_address, $hypervisor, $transfertype;
            if (!isset($this->_conn))
            {
//                $address = retriveServerAddr();
                $this->_conn = connect2Server($hypervisor, $transfertype, $server_address, NULL, true);
            }
*/
            $info = libvirt_node_get_info($this->_conn);

            if (isset($info))
            {
                $this->totalMemory = $info['memory'];
                $this->totalCpuNo  = $info['cpus'];
                $this->cpuSpeed    = $info['mhz'];
                $this->model = $info['model'];
            }

        }

        private function _initMemoryStats()
        {
/*            if (!isset($this->_conn))
            {
                $address = retriveServerAddr();
                $this->_conn = connect2Server('qemu', 'tcp', $address, NULL, true);
            }
*/
            $mem = libvirt_node_get_mem_stats($this->_conn);

            if (isset($mem))
                $this->memstats = $mem;
        }


        private function _initCpuStats()
        {
  /*          if (!isset($this->_conn))
            {
                $address = retriveServerAddr();
                $this->_conn = connect2Server('qemu', 'tcp', $address, NULL, true);
            }
*/
            $cpuStats = libvirt_node_get_cpu_stats($this->_conn, VIR_NODE_CPU_STATS_ALL_CPUS);

            if (isset($cpuStats))
                $this->cpuStats= $cpuStats;

        }
    }
