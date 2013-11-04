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

var CURRENT_USER_GROUPS=[];
var CURRENT_PAGE_GROUPS=[];

function awsm_renderSecurityMarking(securityGroups) {
	var newElement = document.createElement('span');
	newElement.setAttribute('class', 'awsm_securityLabel');
	newElement.innerHTML=securityGroups; //Note that this is unsafe and needs sanitising in production
	var container = document.getElementById('content');
	var nextSibling = document.getElementById('firstHeading');
	container.insertBefore(newElement, nextSibling);
}

function awsm_renderSecuritySelector() {
	var button=$("#awsm_securityMarking")[0];
	var existingSecurityGroups = button.innerHTML;
	
	if (existingSecurityGroups.length > 20) { //Ensure all the security groups can be seen
		button.style.cssText='width:'+existingSecurityGroups.length+'em;';
	}
	
	$("#wpSave").click(function() { awsm_applySelectedSecurityMarking();}) //Attach behaviour to the save button
	$("#awsm_securityMarking").click(function() { awsm_showSecuritySelectorDialogue(); return false;}) //Attach behaviour to security groups button

	
	//Create security selector dialogue elements
	var container=$("#awsm_container")[0];
	var groupSelectorForm = document.createElement('div');
	groupSelectorForm.className="awsm_groupSelector";
	var groupList = document.createElement('ul');
	for (var i=0; i < CURRENT_USER_GROUPS.length; i++) {
		var listItem = document.createElement('li');
		listItem.innerHTML=CURRENT_USER_GROUPS[i];
		listItem.setAttribute("onclick", 'awsm_toggleListItem(this)');
		listItem.id='awsm_group_li_'+CURRENT_USER_GROUPS[i];
		groupList.appendChild(listItem);
	}
	groupSelectorForm.appendChild(groupList);
	container.appendChild(groupSelectorForm);
	
	$( "div.awsm_groupSelector" ).dialog({
		title: "Select Security Groups",
		autoOpen: false,
		modal: true,
		close: function (event, ui) { awsm_applySelectedGroups(); },
		buttons: { 
			"Use Groups": function() {
				$( this ).dialog( "close" );
			}
		}
	});
}

function awsm_showSecuritySelectorDialogue() {
	$( "div.awsm_groupSelector" ).dialog("open");
	
	var listElements=$(".awsm_groupSelector li"); //Set the elements to the pre-selected values
	for (var i=0; i < listElements.length; i++) {
		var groupName=listElements[i].innerHTML;
		if (awsm_isGroupSetOnPage(groupName)) {
			listElements[i].className="selected";
		}
		else {
			listElements[i].className="unselected";
		}
	}
}

function awsm_isGroupSetOnPage(groupName) {
	for (var i=0; i <CURRENT_PAGE_GROUPS.length; i++) {
		if (CURRENT_PAGE_GROUPS[i]==groupName) {
			return true;
		}
	}
	return false;
}

function awsm_setCurrentPageGroups(groups) {
	CURRENT_PAGE_GROUPS=groups.split(" ");
}

function awsm_setCurrentUserGroups(groups) {
	CURRENT_USER_GROUPS=groups.split(" ");
}

function awsm_toggleListItem(item) {
	var groupName=item.innerHTML;
	if (item.className=='selected') { //Select or un-select, as appropriate 
		item.className="unselected";
	}
	else {
		item.className="selected";
	}
}

function awsm_applySelectedGroups() {
	var listElements=$(".awsm_groupSelector li"); //Set the elements to the pre-selected values
	var newSelectedGroups="";
	for (var i=0; i < listElements.length; i++) {
		var listItem=listElements[i];
		if (listItem.className=='selected') {
			newSelectedGroups+=' ';
			newSelectedGroups+=listItem.innerHTML;
		}
	}
	newSelectedGroups=$.trim(newSelectedGroups);
	if (newSelectedGroups=="") {
		newSelectedGroups="(no security groups set)";
	}
	$("#awsm_securityMarking")[0].innerHTML=newSelectedGroups;
	CURRENT_PAGE_GROUPS=newSelectedGroups.split(" ");
}

function awsm_applySelectedSecurityMarking() {
	var securityMarkingCode="<securityMarking>"+CURRENT_PAGE_GROUPS.join(",")+"</securityMarking>";
	var textBox=$("#wpTextbox1")[0];
	textBox.value=securityMarkingCode+textBox.value;
}