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
require_once( "$IP/extensions/awsm/rls_implementation/FilteredResultsSet.php" );

class SecurityManager
{
	public static function onUserCan ( &$title, &$user, $action, &$result = null ) 	{
		return \awsm\security_business_logic\AccessDecisionManager::canUserSeePage($title);
	}
	
	public static function onSpecialSearchResults( $term, &$titleMatches, &$textMatches ) {
		
		if ($titleMatches) {
			$titleMatches = new FilteredResultsSet($titleMatches);
		}
		if ($textMatches) {
			$textMatches = new FilteredResultsSet($textMatches);
		}
		return true;
	}
	
	
	//Note that we need to add 
	public static function onOldChangesListRecentChangesLine( &$changeslist, &$s, $rc, &$classes ) {
		$pageTitle=$rc->getTitle();
		return \awsm\security_business_logic\AccessDecisionManager::canUserSeePage($pageTitle);
	}
}