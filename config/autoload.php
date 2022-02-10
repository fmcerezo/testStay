<?php

spl_autoload_register(function ($classname) {
    $classname = explode('\\', $classname);
    $classname = end($classname);
	if (substr($classname, -10) == 'Controller')
    	$filename = "controllers/$classname.php";
    elseif (substr($classname, -9) == 'Exception') {
    	$filename = "classes/exceptions/$classname.php";
    } else {
        $filename = "classes/$classname.php";
    }

    require $filename;
});
