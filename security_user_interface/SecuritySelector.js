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

function awsm_renderSecurityMarking(securityGroups) {
	var newElement = document.createElement('span');
	newElement.setAttribute('class', 'awsm_securityLabel');
	newElement.innerHTML=securityGroups; //Note that this is unsafe and needs sanitising in production
	var container = document.getElementById('content');
	var nextSibling = document.getElementById('firstHeading');
	container.insertBefore(newElement, nextSibling);
}