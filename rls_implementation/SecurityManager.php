<?php namespace awsm\rls_implementation;

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
require_once( "$IP/extensions/awsm/security_business_logic/AccessDecisionManager.php" );

class SecurityManager
{
	public static function onUserCan ( &$title, &$user, $action, &$result = null ) 
	{
		wfErrorLog("Invoking onUserCan for title " . $title . ", user " . $user . " and action " . $action . "\n", '/tmp/awsm.log');
		return \awsm\security_business_logic\AccessDecisionManager::canUserSeePage($user, $title);
	}
	
	public static function onFetchChangesList( $user, $skin, &$list ) {
		wfErrorLog("Invoking onFetchChangesList for " . $user . "\n", '/tmp/awsm.log');
		return true;
	}
	
	public static function onSpecialSearchResults( $term, &$titleMatches, &$textMatches ) {
		wfErrorLog("Invoking onSpecialSearchResults\n", '/tmp/awsm.log');
		return true;
	}
	
	
}