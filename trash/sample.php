<?php
    //phpinfo();
    
    
    function dump_modules()
    {
        $modules = get_loaded_extensions();
        print_r($modules);
        return $modules;
    }
    


    function list_functions_of_module($modules, $module_name)
    {
        foreach ($modules as $m)
        {
            if ($m=="libvirt")
            {
                print "List functions in module: $m\n";
                $funcs = get_extension_funcs($m);
                print_r($funcs);
            }
        }
    }

    function get_libvirt_version() 
    {
        $v = libvirt_version();
        print "the libvirt version is :\n\n\n";
        print_r ($v);
    }


    $ms = dump_modules();
    //list_functions_of_module($ms, "libvirt");
    //get_libvirt_version();
?>
