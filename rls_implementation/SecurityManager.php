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

//require_once( "$IP/includes/db/DatabaseUtility.php" );

wfErrorLog("Loading Security Manager\n", '/tmp/awsm.log');

class SecurityManager
{
	public static function onUserCan ( &$title, &$user, $action, &$result = null ) 
	{
		wfErrorLog("Invoking onUserCan for title " . $title . ", user " . $user . " and action " . $action . "\n", '/tmp/awsm.log');
		return \awsm\security_business_logic\AccessDecisionManager::canUserSeePage($user, $title);
	}
	
	/*
	 * 
	 * public static function onQueryPageResults ( $resultsIn )
	{
		global $wgUser;
		$user=$wgUser;
		wfErrorLog("Invoking onQueryPageResults for user " . $user . "\n", "/tmp/awsm.log");
		
		$secureResults = new awsm_ResultWrapper($resultsIn);
		
		return $secureResults;
	}
	*/
	
}

/**
 * 
 * This basically didn't work!
 * 
 **/
 /**
class awsm_ResultWrapper extends \ResultWrapper implements \Iterator {
	
	var $db, $result, $pos = 0, $skipped, $wrapped, $currentRow = null;
	
	function __construct($wrapped) {
		$this->wrapped=$wrapped;
		wfErrorLog("Wrapping an object with " . $wrapped->numRows() . " rows \n", '/tmp/awsm.log');
		$this->skipped=0;
		wfErrorLog("Result class " . get_class($wrapped->result) .  "\n", '/tmp/awsm.log');
		
		$this->result=$wrapped->result;
	}
	
	function checkPermissions($title) {
		
		global $wgUser;
		$user=$wgUser;
		
		if (substr($user, -1) === '2' && substr($title, -1) === '1') {
			wfErrorLog("   Forbidding access to " . $title. "\n", '/tmp/awsm.log');
			$this->skipped++;
			return false;
		}
			
		if (substr($user, -1) === '1' && substr($title, -1) === '2') {
			wfErrorLog("   Forbidding access to " . $title. "\n", '/tmp/awsm.log');
			$this->skipped++;
			return false;
		}
		
		wfErrorLog("   Allowing access to " . $title. "\n", '/tmp/awsm.log');
		return true;
	}
	
	function numRows() {
		return $this->wrapped->numRows() - $this->skipped;
	}
	
	function fetchObject() {
		wfErrorLog("Fetching an object\n", '/tmp/awsm.log');
		while (true) {
			$next=$this->wrapped->fetchObject();
			if ($next==null) {
				return null;
			}
			if ($this->checkPermissions($next->title)) {
				return $next;
			}
		}
		return null;		
	}

	function fetchRow() {
		wfErrorLog("Fetching a row\n", '/tmp/awsm.log');
		
		while (true) {
			$next=$wrapped->fetchRow();
			if ($next==null) {
				return null;
			}
			if ($this->checkPermissions($next['title'])) {
				return $next;
			}
		}
		return null;		
	}
	
	function free() {
		wfErrorLog("Free\n", '/tmp/awsm.log');
		
		$this->db->freeResult( $this );
		unset( $this->result );
		unset( $this->db );
	}
	
	function seek( $row ) {
		wfErrorLog("Seek\n", '/tmp/awsm.log');
		
		$this->db->dataSeek( $this, $row );
	}
	
	function rewind() {
		wfErrorLog("Rewind\n", '/tmp/awsm.log');
		
		if ( $this->numRows() ) {
			$this->db->dataSeek( $this, 0 );
		}
		$this->pos = 0;
		$this->currentRow = null;
	}
	

	function current() {
		wfErrorLog("Current\n", '/tmp/awsm.log');
		
		if ( is_null( $this->currentRow ) ) {
			$this->next();
		}
		return $this->currentRow;
	}
	

	function key() {
		wfErrorLog("Key\n", '/tmp/awsm.log');
		
		return $this->pos;
	}
	

	function next() {
		wfErrorLog("Next\n", '/tmp/awsm.log');
		
		$this->pos++;
		$this->currentRow = $this->fetchObject();
		return $this->currentRow;
	}
	

	function valid() {
		wfErrorLog("Valid\n", '/tmp/awsm.log');
		
		return $this->current() !== false;
	}
}
*/


wfErrorLog("Security Manager Loaded\n", '/tmp/awsm.log');
