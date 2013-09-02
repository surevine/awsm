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
require_once( "$IP/extensions/awsm/security_business_logic/SecurityMarkingLogic.php" );

wfErrorLog("Loading Access Decision Manager\n", '/tmp/awsm.log');

class AccessDecisionManager
{

	public static function canUserSeePage ( $user, $title) 
	{
		$groupsForPage=SecurityMarkingLogic::getSecurityMarking($title);
		
		if ( ! $groupsForPage) {
			return true; //Shortcut - no groups == yes, you can see it
		}
		
		$groupsForUser=SecurityMarkingLogic::getGroupsForCurrentUser();
		
		$combined_groups=array_merge($groupsForPage,$groupsForUser);
		
		
		if(array_unique($combined_groups) === $groupsForUser) {
			wfErrorLog("Access granted to " . $user . " for " . $title . " \n", '/tmp/awsm.log');
			return true;
		}
		else {
			wfErrorLog("Access forbidden to " . $user . " for " . $title . " \n", '/tmp/awsm.log');
			return false;
		}
	}
}

wfErrorLog("Access Decision Manager Loaded\n", '/tmp/awsm.log');
