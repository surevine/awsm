<?php namespace awsm\security_user_interface;

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


class SecurityUIHandler
{
	public static function onBeforePageDisplay( \OutputPage &$out, \Skin &$skin ) {
		$pageTitle = $out->getPageTitle();
		$groups = \awsm\security_business_logic\SecurityMarkingLogic::getSecurityMarking($pageTitle);
		if ($groups) {
			$groupsStr = implode(' ', $groups)
			wfErrorLog("Drawing display UI for ". $pageTitle ."\n", '/tmp/awsm.log');
			$out->addInlineScript("alert('Security Marking is:  ". $groupsStr ."')");
		}
		return true;
		
	}
}
