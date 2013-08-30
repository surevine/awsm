<?php namespace awsm;


require_once('rls_implementation/SecurityManager.php');
require_once( "$IP/includes/GlobalFunctions.php" );

wfErrorLog( "Extension Loading", '/tmp/awsm.log\n' );


/**
 * Prototype security model for investigation purposes
 * 
 * List of things we need to handle:
 * 
 * 		1)  Search results
 * 		2)  Recent changes
 * 		3)  Transclusion (can this be done form outside the template namespace?)
 * 		4)  Random page can select a protected page, but it doesn't show the content
 * 		5)	Anonymous access
 * 		6)	We need to check file uploads
 * 		7)	What links here
 * 		8)	The various special pages
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

wfErrorLog("Extension Loaded", '/tmp/awsm.log\n');