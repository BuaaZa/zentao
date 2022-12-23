<?php
$config->ticket->listFields     = "module,product,type,openedBuild,assignedTo,mailto,pri";
$config->ticket->sysListFields  = "module,product,type,openedBuild,assignedTo,mailto,pri";
$config->ticket->templateFields = 'product,module,title,pri,type,desc,openedBuild,assignedTo,deadline,customer,contact,notifyEmail,mailto,keywords';
$config->ticket->cascade        = array('module' => 'product');