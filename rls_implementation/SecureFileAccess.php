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

function last_index_of($sub_str,$instr) {
	if(strstr($instr,$sub_str)!="") {
		return(strlen($instr)-strpos(strrev($instr),$sub_str));
	}
	return(-1);
}

//Bootstrap mediawiki
$oldDir=getcwd();
chdir ('../../..');

if ( isset( $_SERVER['MW_COMPILED'] ) ) {
	require ( '/phase3/includes/WebStart.php' );
} else {
	require ( 'includes/WebStart.php' );
}
chdir ($oldDir);

//Now we've established our Mediawiki globals, we can import the relevant dependencies
require_once( "$IP/includes/GlobalFunctions.php" );
require_once( "$IP/extensions/awsm/security_business_logic/AccessDecisionManager.php" );

//Get the file we're actually trying to access
$path = filter_input(INPUT_GET,"path",FILTER_SANITIZE_STRING);
wfErrorLog("Evaluating access for a file: " . $path . "\n", '/tmp/awsm.log');

//Get the name of the corresponding wiki page
$pageTitle=str_replace('_', ' ', "File:".substr( $path, strrpos( $path, '/' )+1 ));
wfErrorLog("Wiki page name: " . $pageTitle . "\n", '/tmp/awsm.log');


if (\awsm\security_business_logic\AccessDecisionManager::canUserSeePage($pageTitle)) {
	// We can now get the actual file requested, set some headers, and return it
	$path="../../../". $path;
	$imageInfo = getimagesize($path);
	header("Content-Type: " . $imageInfo['mime'] );
	header("Content-Length: " . filesize($path));
	$fp = fopen($path, 'rb');
	fpassthru($fp);
}
else {
	//We don't have access to the underlying file, so throw a 404
	echo '<h1>Not Found</h1><p>The resource was not found</p>';
	header("HTTP/1.0 404 Not Found - Archive Empty");
}