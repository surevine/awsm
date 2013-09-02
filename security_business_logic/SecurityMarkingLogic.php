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

class SecurityMarkingLogic
{
	
	public static function getSecurityMarking ( $pageTitle ) 
	{
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
							'awsm_PageSecurity',
							array('groups'),
							'uri = "'.'wiki://'.$pageTitle.'"'
							);
		$resultObj = $res->fetchObject();
		if ( ! $resultObj)
		{
			return null;
		}
		$groups= $resultObj->groups;
		
		wfErrorLog("Found groups:" . $groups . " for page ". $pageTitle ."\n", '/tmp/awsm.log');	
		
		return explode(',',$groups);
	}
	
	public static function getGroupsForCurrentUser () 
	{
		global $wgUser;
		$user=$wgUser;
		$rV = $user->getEffectiveGroups();
		wfErrorLog("Found groups:" . implode(',',$rV) . " for user ". $user ."\n", '/tmp/awsm.log');
		return $rV;
	}
	

}