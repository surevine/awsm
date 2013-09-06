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

class FilteredResultsSet extends \SearchResultSet {
	
	protected $wrapped;
	protected $user;
	
	function __construct($toWrap) {
		$this->wrapped=$toWrap;
	}
	
	function next() {
		
		$filter=TRUE;
		while ($filter) {
			$wouldBeNext=$this->wrapped->next();
			if ($wouldBeNext === FALSE) {
				$filter=FALSE;
			}
			else {
				$pageTitle=$wouldBeNext->getTitle();
				if (\awsm\security_business_logic\AccessDecisionManager::canUserSeePage($pageTitle)) {
					$filter=FALSE;
				}
			}
		}
		return $wouldBeNext;
	}
}