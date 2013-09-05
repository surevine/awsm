<?php namespace awsm;
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

require_once('rls_implementation/SecurityManager.php');
require_once('security_user_interface/SecurityUIHandler.php');
require_once( "$IP/includes/GlobalFunctions.php" );


/**
 * Prototype security model for investigation purposes
 * 
 * List of things we need to handle:
 * 
 * 		1)  Search results
 * 		2)  Recent changes - we can use the FetchChangesList hook to handle this, but we haven't prototyped it yet
 * 		3)  Transclusion (can this be done form outside the template namespace?)
 * 		4)  Random page can select a protected page, but it doesn't show the content
 * 		5)	Anonymous access - easy enough to disable
 * 		6)	We need to check file uploads
 * 		7)	What links here
 * 		8)	The various special pages - QueryPage.php could be a base for this - have found a way to do it that covers most of the pages, and we can hide specific pages
 * 			that present us any issues.
 * 		9)	If a page you can't see is on your watchlist, you can see the comments for changes but not the changes themselves
 * 
 * 
 * 
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}


$wgHooks['userCan'][]='\awsm\rls_implementation\SecurityManager::onUserCan';
$wgHooks['FetchChangesList'][] = '\awsm\rls_implementation\SecurityManager::onFetchChangesList';
$wgHooks['BeforePageDisplay'][] = '\awsm\security_user_interface\SecurityUIHandler::onBeforePageDisplay';
$wgHooks['PageContentSave'][] = '\awsm\security_user_interface\SecurityUIHandler::onPageContentSave';
$wgHooks['EditPage::showEditForm:fields'][] = '\awsm\security_user_interface\SecurityUIHandler::showEditFormFields';
$wgHooks['SpecialSearchResults'][] = '\awsm\rls_implementation\SecurityManager::onSpecialSearchResults';