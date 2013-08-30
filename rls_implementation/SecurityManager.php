<?php namespace awsm\rls_implementation;


require_once( "$IP/includes/GlobalFunctions.php" );

wfErrorLog("Loading Security Manager\n", '/tmp/awsm.log');

class SecurityManager
{
	public static function onUserCan ( &$title, &$user, $action, &$result ) 
	{
		wfErrorLog("Invoking onUserCan for title " . $title . ", user " . $user . " and action " . $action . "\n", '/tmp/awsm.log');
		if (substr($user, -1) === '2') { //User 2 can't access pages ending with a '1'
			return !(substr($title, -1) === '1');
		}
		
		if (substr($user, -1) === '1') { //User 1 can't access pages ending with a '2'
			//User 2 can't access pages ending with a '1'
			return !(substr($title, -1) === '2');
		}
		return true;
	}
	
	
}



wfErrorLog("Security Manager Loaded\n", '/tmp/awsm.log');
