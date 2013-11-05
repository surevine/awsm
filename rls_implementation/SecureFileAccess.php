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


//Bootstrap mediawiki
$oldDir=getcwd();
chdir ('../../..');

if ( isset( $_SERVER['MW_COMPILED'] ) ) {
	require ( '/phase3/includes/WebStart.php' );
} else {
	require ( 'includes/WebStart.php' );
}
chdir ($oldDir);

require_once( "$IP/includes/GlobalFunctions.php" );


$path = filter_input(INPUT_GET,"path",FILTER_SANITIZE_STRING);
wfErrorLog("Evaluating access for a file: " . $path . "\n", '/tmp/awsm.log');

$path="../../../". $path;

$imageInfo = getimagesize($path);
header("Content-Type: " . $imageInfo['mime'] );
header("Content-Length: " . filesize($path));
$fp = fopen($path, 'rb');
fpassthru($fp);