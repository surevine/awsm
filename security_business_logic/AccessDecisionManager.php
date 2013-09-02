<?php namespace awsm\security_business_logic;

/**
* Copyright (c) 2013 simonw.
* All rights reserved. This program and the accompanying materials
* are made available under the terms of the GNU Public License v2.0
* which accompanies this distribution, and is available at
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Contributors:
*     simonw - initial API and implementation
**/

require_once( "$IP/includes/GlobalFunctions.php" );
//require_once( "$IP/includes/db/DatabaseUtility.php" );

wfErrorLog("Loading Access Decision Manager\n", '/tmp/awsm.log');

class AccessDecisionManager
{

	public static function canUserSeePage ( $user, $title) 
	{	
		if (substr($user, -1) === '2') {
			//User 2 can't access pages ending with a '1'
			return !(substr($title, -1) === '1');
		}
		
		if (substr($user, -1) === '1') {
			//User 1 can't access pages ending with a '2'
			//User 2 can't access pages ending with a '1'
			return !(substr($title, -1) === '2');
		}
		return true;	
	}
}

wfErrorLog("Access Decision Manager Loaded\n", '/tmp/awsm.log');
