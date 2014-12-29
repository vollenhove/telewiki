<?php


require_once "$IP/skins/wp/wp.php";
require_once('extensions/AuthWP.php');
$wgAuth=new AuthWP();
#no reg.
$wgGroupPermissions['*']['createaccount'] = false;
