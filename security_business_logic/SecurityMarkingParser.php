<?php namespace awsm\security_business_logic;

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

class SecurityMarkingParser {
	
	/**
	 * Security Marking must be on the first line of the content, and is between <securityMarking> and </securityMarking>.
	 * Within this block, security groups are seperated by commas
	 */
	public static function parseFromPageContent($pageContent) {
		$nativeData = $pageContent->getNativeData();
		
		$firstLine = strtok($nativeData, "\n");
		$startIdx = strpos($firstLine, '<securityMarking>');
		$endIdx = strpos($firstLine, '</securityMarking');
		
		wfErrorLog("First line of content is ". $firstLine ."\n", '/tmp/awsm.log');
		wfErrorLog("Start of security marking at ". $startIdx . " end is at " . $endIdx ."\n", '/tmp/awsm.log');
		
		//Various conditions that would mean no marking can be found
		if ( $startIdx === FALSE || $endIdx === FALSE || $startIdx == $endIdx || $startIdx>$endIdx) {
			return false;
		}
		
		$newFirstLine = substr($firstLine, 0, $startIdx) . substr($firstLine, $endIdx+18); 	//Remove the security marking from the first line
																							//18 - length of "</securityMarking>"
		
		$securityMarking = trim(substr($firstLine, $startIdx+17, $endIdx-$startIdx-17)); 	//17  length of "<securityMarking>"
		wfErrorLog("Parsed Security Marking: " . $securityMarking ."\n", '/tmp/awsm.log');
		wfErrorLog("New first line: " . $newFirstLine ."\n", '/tmp/awsm.log');
		
		$newlinePosition = strpos($nativeData, "\n");
		wfErrorLog("Newline position: " . $newlinePosition . "\n" , '/tmp/awsm.log');
		
		if ($newlinePosition) {
			$newContent = $newFirstLine . substr($nativeData, strpos($nativeData, "\n"));
		}
		else {
			$newContent = $newFirstLine;
		} 		
		
		wfErrorLog("New content: " . $newContent . "\n", '/tmp/awsm.log');
		
		$retVal = array (
						'securityMarking'	=> $securityMarking,
						'pageContent'		=> $newContent
					);
		
		return $retVal;
	}
	
}