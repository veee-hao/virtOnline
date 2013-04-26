<?php
    class Domain
    {
        ///domain resource handler 
        private $_res = null;
        
        //inactive domain have no id
        public $id = -1;  

        public $name = "";
        
        public $maxMem = 0;
        
        public $memory = 0;
        
        /**
         *  domain state could be one of following:
         *  VIR_DOMAIN_RUNNING  1
         *  VIR_DOMAIN_BLOCKED  2
         *  VIR_DOMAIN_PAUSED   3
         *  VIR_DOMAIN_SHUTDOWN 4
         *  VIR_DOMAIN_SHUTOFF  5
         *  VIR_DOMAIN_CRASHED  6
         * */
        public $state = 0;
        
        public $virtCpu = 0;
        
        public $cpuUsed = 0;

        public $numOfNIC = 0;

        public $nics = null;

        public $numOfDisk = 0;

        public $disks = 0;

        function __construct($name, $id, $info, $nics=null, $disks=null)
        {
            $this->name = $name;
            $this->id= $id;
            $this->maxMem = $info['maxMem'];
            $this->memory = $info['memory'];
            $this->state = $info['state'];
            $this->virtCpu = $info['nrVirtCpu'];
            $this->cpuUsed= $info['cpuUsed'];

            $this->numOfNIC = count($nics);
            $this->nics = $nics;
                
            $this->numOfDisk = count($disks);
            $this->disks= $disks;
        }

        function getStateString()
        {
            $stateStr = "Unknown";
            switch ($this->state)
            {
                case VIR_DOMAIN_NOSTATE:
                    $stateStr = "No State";
                    break;
                case VIR_DOMAIN_RUNNING:
                    $stateStr = "Running";
                    break;

                case VIR_DOMAIN_BLOCKED:
                    $stateStr = "Blocked";
                    break;

                case VIR_DOMAIN_PAUSED:
                    $stateStr = "Paused";
                    break;

                case VIR_DOMAIN_SHUTDOWN:
                    $stateStr = "Shutdown";
                    break;

                case VIR_DOMAIN_SHUTOFF:
                    $stateStr = "Shut Off";
                    break;

                case VIR_DOMAIN_CRASHED:
                    $stateStr = ":) Crashed";
                    break;

                default:
                    break;
            }

            return $stateStr;
        }

        function setResource($domainResource)
        {
            if (isset($domainResource))
                $this->_res = $domainResource;
        }

        function getResource()
        {
            return $this->_res;
        }
        
        function startDomain()
        {
            //use cacched hash map to retrive domain resource 
            //$res = $this->_name2Re[$this->name];
            //
            if (isset($this->_res))
            {
               return libvirt_domain_create($this->_res); 
            }
            return FALSE;
        }

        function shutdownDomain()
        {
            if (isset($this->_res))
            {
               return libvirt_domain_shutdown($this->_res); 
            }
            return FALSE;
        }

        function suspendDomain()
        {
            if (isset($this->_res))
            {
               return libvirt_domain_suspend($this->_res); 
            }
            return FALSE;
        }

        function resumeDomain()
        {
            if (isset($this->_res))
            {
               return libvirt_domain_resume($this->_res); 
            }
            return FALSE;
        }
        
        function rebootDomain()
        {
            if (isset($this->_res))
            {
               return libvirt_domain_reboot($this->_res); 
            }
            return FALSE;
        }
    }
?>
