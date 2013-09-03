



function awsm_renderSecurityMarking(securityGroups) {
	var newElement = document.createElement('span');
	newElement.setAttribute('class', 'awsm_securityLabel');
	newElement.innerHTML=securityGroups; //Note that this is unsafe and needs sanitising in production
	var container = document.getElementById('content');
	var nextSibling = document.getElementById('firstHeading');
	container.insertBefore(newElement, nextSibling);
}