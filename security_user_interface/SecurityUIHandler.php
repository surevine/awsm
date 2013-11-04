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
require_once( "$IP/extensions/awsm/security_business_logic/SecurityMarkingParser.php" );


class SecurityUIHandler
{
	public static function onBeforePageDisplay( \OutputPage &$out, \Skin &$skin ) {
				
		$pageTitle = $out->getPageTitle();

		$groups = \awsm\security_business_logic\SecurityMarkingLogic::getSecurityMarking($pageTitle);
			
		if ( $groups && sizeof($groups)>0 && !(sizeof($groups)===1 && $groups[0]==="") ) {
			$groupsStr = implode(' ', $groups);
			wfErrorLog("Drawing display UI for ". $pageTitle ."\n", '/tmp/awsm.log');
			$out->addScript("<script type=\"text/javascript\" src=\"/w/extensions/awsm/security_user_interface/SecuritySelector.js\"></script>");
			$out->addInlineScript("awsm_renderSecurityMarking(\"". $groupsStr ."\")");
			$out->addStyle('/w/extensions/awsm/security_user_interface/SecuritySelector.css');
		}
		
		return true;		
	}
	
	public static function onPageContentSave( &$wikiPage, &$user, &$content, &$summary,	$isMinor, $isWatch, $section ) {
		$parsedContent = \awsm\security_business_logic\SecurityMarkingParser::parseFromPageContent($content);
		if ( ! ($parsedContent === FALSE)) {
			$securityMarking = $parsedContent["securityMarking"];
				
			\awsm\security_business_logic\SecurityMarkingLogic::setSecurityMarking($wikiPage->getTitle(), $securityMarking);
			$content = new \WikitextContent($parsedContent["pageContent"]);
		}
		return true;
	}
	
	public static function showEditFormfields( &$editpage, $out ) {
		wfErrorLog("Drawing edit form for ". $editpage->getTitle() ."\n", '/tmp/awsm.log');
				
		$existingSecurityMarking = \awsm\security_business_logic\SecurityMarkingLogic::getSecurityMarking($editpage->getTitle());
		if ($existingSecurityMarking === null) {
			$existingSecurityMarking="(no security groups set)";
		}
		else {
			$existingSecurityMarking=implode(" ", $existingSecurityMarking);
		}
		
		$editpage->editFormTextBeforeContent .= '<div id="awsm_container"><button class="ui-button" id="awsm_securityMarking">' . $existingSecurityMarking  . '</button></div>';
		$out->addScript("<script type=\"text/javascript\" src=\"/w/extensions/awsm/security_user_interface/SecuritySelector.js\"></script>");
		$out->addScript("<script type=\"text/javascript\" src=\"/w/extensions/awsm/security_user_interface/jquery-ui-1.10.3.custom.min.js\"></script>");
		$out->addStyle('/w/extensions/awsm/security_user_interface/SecuritySelector.css');
		
		//Tweak the JQuery theme here
		$out->addStyle('/w/extensions/awsm/security_user_interface/themes/smoothness/jquery-ui.min.css');
		$out->addStyle('/w/extensions/awsm/security_user_interface/themes/smoothness/jquery.ui.theme.css');
		
		
		$availableMarkings=\awsm\security_business_logic\SecurityMarkingLogic::getGroupsForCurrentUser(); //Set markings available for this user to select
		$out->addInlineScript("awsm_setCurrentUserGroups(\"".implode(" ", $availableMarkings)."\")");
		$out->addInlineScript("awsm_renderSecuritySelector()");
		$out->addInlineScript("awsm_setCurrentPageGroups(\"".$existingSecurityMarking."\")");
		
		return true;
	}
	
}
