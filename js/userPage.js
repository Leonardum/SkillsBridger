/* -----------------------------------------------------------------------------
1.  General
----------------------------------------------------------------------------- */

/* This function serves to make sure the code that binds the bubbeling event doesn't need to figure out which to use and can work in every browser. */
function addBubbleEvent(element, eventName, callback) {
    if (element.addEventListener) {
        element.addEventListener(eventName, callback, false);
    } else if (element.attachEvent) {
        element.attachEvent("on" + eventName, callback);
    }
}


/* This function serves to make sure the code that binds the capturing event doesn't need to figure out which to use and can work in every browser. */
function addCaptureEvent(element, eventName, callback) {
    if (element.addEventListener) {
        element.addEventListener(eventName, callback, true);
    } else if (element.attachEvent) {
        element.attachEvent("on" + eventName, callback);
    }
}


/* This function hides an element if it is shown and unhides it if it s not. The argument for this function is the id of the element shat should be hidden. It should be passed as a string! */
function hide(elementId) {
    'use strict';
    var element = document.getElementById(elementId);
    if (element.style.display === "none") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}


/* This function redirects the page to the appropriate role when clicked in the hover dropdown menue */
function goTo(value) {
	if (value == "student") {
		document.getElementById('studentLink').click();
	} else if (value == "organisation") {
		document.getElementById('organisationLink').click();
	}
}


/* -----------------------------------------------------------------------------
2.  Formats
----------------------------------------------------------------------------- */

// This function makes the first letter of a string a capital letter.
String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}


/* This function formats a given number (e.g.: 49874132.93219) to a string of the following pattern: xx xxx xxx.xx format. It also rounds the second decimal up or down depending on the third decimal, if this exists. */
function formatNumber(x) {
    var a = String(x);
    var placeOfPeriod = a.lastIndexOf('.');
    
    if (placeOfPeriod === -1) {
        var b = '';
        var c = a;
    } else {
        var b = a.substring(placeOfPeriod);
        if (b.length > 3) {
            if (parseFloat(b[3]) > 4) {
                b = b.substring(0,2) + String(parseInt(b[2]) + 1);
            } else {
                b = b.substring(0, 3);
            }
        }
        var c = a.substring(0, placeOfPeriod);
    }
    var d;
    
    switch (c.length % 3) {
        case 0:
            d = c.replace(/(\d{3})/g, '$1 ');
            break;
            
        case 1:
            var e;
            var f;
            e = c.substring(0,1);
            f = c.substring(1);
            f = f.replace(/(\d{3})/g, '$1 ');
            d = e + " " + f;
            break;
            
        case 2:
            var e;
            var f;
            e = c.substring(0,2);
            f = c.substring(2);
            f = f.replace(/(\d{3})/g, '$1 ');
            d = e + " " + f;
    }
    
    y = d + b;
    return y;
}


/* -----------------------------------------------------------------------------
3.  Text areas
----------------------------------------------------------------------------- */

// Shows the amount of characters to type left in a text area.
function countdown(textId, x, displayId) {
	var charsTyped = document.getElementById(textId).value.length;
	var charsLeft = x - charsTyped;
	charsLeftDisplay = document.getElementById(displayId);
	charsLeftDisplay.innerHTML = "Characters left: " + charsLeft;
}


/* -----------------------------------------------------------------------------
4.  Check boxes
----------------------------------------------------------------------------- */

/* On loading the page, make sure that all check box text has the event listeners attached to them to tick the corresponding check box when clicked. */
function addCheckBoxEventListeners() {
	var checkboxTexts = document.getElementsByClassName('checkboxText');
	var i;
	for (i = 0; i < checkboxTexts.length; i++) {
		var checkboxText = checkboxTexts[i];

		addCaptureEvent(checkboxText, "mousedown", tickbox);
		/* No need to pass anything as a parameter in the 'showSelect' callback function, as the function used for addEventListener will automatically have 'this' bound to the current element. Therefore, you can access 'this' in the callback function. */
	}
}


function tickbox() {
	'use strict';
	var event = event || window.event;
    var i = 0;
    
    for (i = 0; i < this.parentNode.childElementCount; i++) {
        if (this.parentNode.children[i] == this) {
            var checkbox = this.parentNode.children[i-1];
            if (checkbox.checked) {
                checkbox.checked = false;
            } else {
                checkbox.checked = true;
            }
        }
    }
}


/* -----------------------------------------------------------------------------
5.  Radio buttons
----------------------------------------------------------------------------- */

/* On loading the page, make sure that all radio button text has the event listeners attached to them to select the corresponding radio button when clicked. */
function addRadioEventListeners() {
	var radioTexts = document.getElementsByClassName('radioText');
	var i;
	for (i = 0; i < radioTexts.length; i++) {
		var radioText = radioTexts[i];

		addCaptureEvent(radioText, "mousedown", radioButton);
		/* No need to pass anything as a parameter in the 'showSelect' callback function, as the function used for addEventListener will automatically have 'this' bound to the current element. Therefore, you can access 'this' in the callback function. */
	}
}


function radioButton() {
	'use strict';
	var event = event || window.event;
    var i = 0;
    
    for (i = 0; i < this.parentNode.childElementCount; i++) {
        if (this.parentNode.children[i] == this) {
            this.parentNode.children[i-1].checked = true;
        }
    }
}


/* -----------------------------------------------------------------------------
6.  Selects
----------------------------------------------------------------------------- */

/* On loading the page, make sure that all selects have the event listeners attached to them to open the select options when clicked. */
function addOpenSelectEventListeners() {
	var selectWrappers = document.getElementsByClassName('select-wrapper');
	var i;
	for (i = 0; i < selectWrappers.length; i++) {
		var selectWrapper = selectWrappers[i];

		addCaptureEvent(selectWrapper, "click", showSelect);
		/* No need to pass anything as a parameter in the 'showSelect' callback function, as the function used for addEventListener will automatically have 'this' bound to the current element. Therefore, you can access 'this' in the callback function. */
	}
}

function showSelect() {
	'use strict';
	
	/* Get the height of the document before making the select visible in order to know if the select should be expanded towards the bottom or towards the top of the docuument. */
	var documentHeight = document.documentElement.scrollHeight;
    var selectInput = this.getElementsByTagName('input')[0];
	var select = this.getElementsByTagName('ul')[0];
    
	if (select.style.display === "none") {
		select.style.display = "block";
	}
	
	// Get how far down the select menu extends (in y-axis value).
	var selectHeight = select.getBoundingClientRect().bottom + window.scrollY;
	/* = hight from the top of the viewport to the bottom of the select + hight from the top of the document to the place where the viewport is scrolled */
	
	/* If the select extends further down than the document itself, make sure the select menu is made smaller and has a scroll bar. */
	if (selectHeight > documentHeight) {
        
        select.style.maxHeight = documentHeight - selectInput.getBoundingClientRect().bottom + "px";
        select.style.overflow = "auto";
        
        /* This code will instead have the select extend to the top, rather than to the bottom.
		select.style.top = "auto";
		select.style.bottom = "0px";
		
		var optionCount = select.childElementCount;
		var option1 = select.children[0];
		var lastOption = select.children[optionCount-1];
		if (option1.innerHTML === "Choose option") {
			select.insertBefore(option1, lastOption.nextSibling);
		}
        */
	}
}

/* On loading the page, make sure that when clicked outside a select, any open select is closed. */
addCaptureEvent(window, "click", function (event) {hideSelects(event);});
function hideSelects(event) {
	'use strict';
    
	var event = event || window.event;
    
	if (event.target.class != 'option') {
		var selectWrappers = document.getElementsByClassName('select-wrapper');
		var i;
		for (i = 0; i < selectWrappers.length; i++) {

			var select = selectWrappers[i].getElementsByTagName('ul')[0];
			
			if (select.style.display === "block") {
				select.style.display = "none";
			}
            
            /*
			if (select.style.top === "auto") {
				select.style.top = "0px";
			}
			if (select.style.bottom === "0px") {
				select.style.bottom = "auto";
			}
			
			var optionCount = select.childElementCount;
			var lastOption = select.children[optionCount-1];
			if (lastOption.innerHTML === "Choose your option") {
				var option1 = select.children[0];
				select.insertBefore(lastOption,option1);
			}
            */
		}
	}
}

/* On loading the page, make sure that all the first options of the selects have the event listeners attached to them to close the select they are part of when clicked. */
function addCloseSelectEventListeners() {
	var selectOptionsOne = document.getElementsByClassName('disabled');
	var i;
	for (i = 0; i < selectOptionsOne.length; i++) {
		var selectOptionOne = selectOptionsOne[i];

		addCaptureEvent(selectOptionOne, "click", hideSelect);
		/* No need to pass anything as a parameter in the 'showSelect' callback function, as the function used for addEventListener will automatically have 'this' bound to the current element. Therefore, you can access 'this' in the callback function. */
	}
}

function hideSelect() {
	'use strict';
    
	var select = this.parentNode;
	if (select.style.display === "block") {
		select.style.display = "none";
	}
	
    /*
	if (select.style.top === "auto") {
		select.style.top = "0px";
	}
	
	if (select.style.bottom === "0px") {
		select.style.bottom = "auto";
	}
	
	var optionCount = select.childElementCount;
	var lastOption = select.children[optionCount-1];
	if (lastOption.innerHTML === "Choose your option") {
		var option1 = select.children[0];
		select.insertBefore(lastOption,option1);
	}
    */
}

/* Makes sure that when the select options are clicked, that the selected option is displayed in the selectInput and that the correct option is selected in the actual select. */
function addOptionSelectEventListeners() {
	var selectWrappers = document.getElementsByClassName('select-wrapper');
    
	var i;
	for (i = 0; i < selectWrappers.length; i++) {
        
        var select = selectWrappers[i].getElementsByTagName('ul')[0];
        var optionCount = select.childElementCount;

		for (j = 0; j < optionCount; j++) {
			var option = select.children[j];
			addCaptureEvent(option, "click", selectOption);
		}
	}
}


function selectOption() {
	'use strict';
	var event = event || window.event;
	
	var selectWrapper = this.parentNode.parentNode;
	
    var select = selectWrapper.getElementsByTagName('ul')[0];
    var actualSelect = selectWrapper.getElementsByTagName('select')[0];
    var selectInput = selectWrapper.getElementsByTagName('input')[0];
	
	var optionCount = select.childElementCount;
	var i;
	for (i = 0; i < optionCount; i++) {
		if (select.children[i] == this) {
			selectInput.value = select.children[i].innerHTML;
            
            if (actualSelect != undefined) {
                actualSelect.selectedIndex = i;
            }
		}
	}
	
	select.style.display = "none";
}


/* -----------------------------------------------------------------------------
7.  Resonsiveness and media queries (specific to SkillsBridger)
----------------------------------------------------------------------------- */


// If javascript gets the results of a media query...
if (matchMedia) {
	// Check if the media query matches the expression.
	var mqLaptop = window.matchMedia("(min-width: 993px)");
	// Add an event listener which fires when a change is detected.
	mqLaptop.addListener(setLaptopLayout);
	// Execute the width Change function.
	setLaptopLayout(mqLaptop);
}


/* This function makes the left sidebar appear on tablet screens (sidebar width is 30% as compared to 20% for laptop screens and 100% for phone screens). */
function tabletMenuAppear() {
	var sidebar = document.getElementById('left-sidebar');
	var navigation = document.getElementById('navigation');
	
	if (sidebar.style.display === "none" || sidebar.style.display === "") {
        sidebar.style.display = "block";
		navigation.style.width = "70%";
		navigation.style.margin = "0 0 0 30%";
    } else {
        sidebar.style.display = "none";
		navigation.style.width = "100%";
		navigation.style.margin = "0";
    }
}


/* This function sets the "natural state" layouts for screen widths exceeding 992px or fires a new media query listener when the screen is 992px or smaller. */
function setLaptopLayout(mqLaptop) {
	if (mqLaptop.matches) { // Screen is 993px or larger.
		var sidebar = document.getElementById('left-sidebar');
		var navigation = document.getElementById('navigation');
		var roleList = document.getElementById('roleList');
		sidebar.style.display = "block";
		navigation.style.width = "80%";
		navigation.style.margin = "0";
		roleList.style.display = "";
	} else {  // Screen is smaller than 993px.
		var mqSmall = window.matchMedia("(min-width: 601px)");
		mqSmall.addListener(setMobileLayout);
		setMobileLayout(mqSmall);
	}
}


/* This function sets the "natural state" layouts for screen widths between 600px and 993px OR sets the "natural state" layouts for when the screen is 600px or smaller. */
function setMobileLayout(mqSmall) {
	if (mqSmall.matches) { // Screen is between 600px and 993px large.
		var sidebar = document.getElementById('left-sidebar');
		var navigation = document.getElementById('navigation');
		var roleList = document.getElementById('roleList');
		sidebar.style.display = "none";
		navigation.style.width = "100%";
		navigation.style.margin = "0";
		roleList.style.display = "";
	} else {  // Screen is smaller than 601px.
		var sidebar = document.getElementById('left-sidebar');
		var navigation = document.getElementById('navigation');
		var roleList = document.getElementById('roleList');
		sidebar.style.display = "none";
		navigation.style.width = "100%";
		navigation.style.margin = "0";
		roleList.style.display = "none";
		var profilePicture = document.getElementById('profilePicture');
		addCaptureEvent(profilePicture, "click",  function (event) {document.getElementById('userFile').click();});
	}
}


/* -----------------------------------------------------------------------------
8.  Other SkillsBridger-specific functions
----------------------------------------------------------------------------- */

/* This function loads all the unseen notifications of the current user. */
function loadNotifications(userId) {
	'use strict';
	var notificationIcon = document.getElementById('notification');
	var notificationList = document.getElementById('notifications');
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var notifications = JSON.parse(xmlhttp.responseText);
            var i;
            var arrayLength = notifications.length;
            if (arrayLength == 0) {
                notificationList.innerHTML = "<li><a href='#'>You have no new notifications.</a></li>";
            } else {
                for (i = 0; i < arrayLength; i++) {
					var notificationId = notifications[i]['Notification_id'];
                    var message = notifications[i]['Message'];
                    var objectReference = notifications[i]['ObjectReference'];
					var objectId = notifications[i]['ObjectId'];
                    
					var listItem = document.createElement('li');
                    var link = document.createElement('a');
					if (objectReference == 'event') {
						link.setAttribute("href", "index.php?action=studentEventOverview&eventId=" + objectId);
						link.setAttribute("onclick", "notificationSeen(" + userId + ", " + notificationId + ")")
						link.innerHTML = message;
					}
					listItem.appendChild(link);
                    notificationList.appendChild(listItem);
                }
				notificationIcon.setAttribute("src", "./images/newNotification.png")
            }
        }
    }
    xmlhttp.open("GET", "./model/ajax/notificationFetch.php?userId=" + userId, true);
    xmlhttp.send();
}


/* This function sets the notification which is clicked to seen. */
function notificationSeen(userId, notificationId) {
	'use strict';
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {}
    }
    xmlhttp.open("GET", "./model/ajax/notificationFetch.php?userId=" + userId + "&notificationId=" + notificationId, true);
    xmlhttp.send();
}


/* This eventlistener and function make the role selector menu hide on a click outside the role selector menu. */
addCaptureEvent(window, "click", function (event) {hideRoleSelectorMenu(event);});
function hideRoleSelectorMenu(event) {
	'use strict';
	var event = event || window.event;
	var roleList = document.getElementById('roleList');
	if (event.target.id != 'roleList' && event.target.id != 'roleListIcon') {
		if (roleList.style.display === "block") {
			roleList.style.display = "none";
		}
	}
}


/* This eventlistener and function make the notification window hide on click outside the notification window. */
addCaptureEvent(window, "click", function (event) {hideNotifications(event);});
function hideNotifications(event) {
	'use strict';
	var event = event || window.event;
	var notifications = document.getElementById('notifications');
	if (event.target.id != 'notification') {
		if (notifications.style.display === "block") {
			notifications.style.display = "none";
		}
	}
}


/* This eventlistener and function make the settings window hide on click outside the settings window. */
addCaptureEvent(window, "click", function (event) {hideSettings(event);});
function hideSettings(event) {
	'use strict';
	var event = event || window.event;
	var settings = document.getElementById('settings');
	if (event.target.id != 'setting') {
		if (settings.style.display === "block") {
			settings.style.display = "none";
		}
	}
}


/* -----------------------------------------------------------------------------
9.  Waves effect on menu buttons
----------------------------------------------------------------------------- */

/*!
* Waves v0.6.4
* http://fian.my.id/Waves
*
* Copyright 2014 Alfiana E. Sibuea and other contributors
* Released under the MIT license
* https://github.com/fians/Waves/blob/master/LICENSE
*/

;(function(window) {
	'use strict';

	var Waves = Waves || {};
	var $$ = document.querySelectorAll.bind(document);

	// Find exact position of element
	function isWindow(obj) {
		return obj !== null && obj === obj.window;
	}

	function getWindow(elem) {
		return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
	}

	function offset(elem) {
		var docElem, win,
			box = {top: 0, left: 0},
			doc = elem && elem.ownerDocument;

		docElem = doc.documentElement;

		if (typeof elem.getBoundingClientRect !== typeof undefined) {
			box = elem.getBoundingClientRect();
		}
		win = getWindow(doc);
		return {
			top: box.top + win.pageYOffset - docElem.clientTop,
			left: box.left + win.pageXOffset - docElem.clientLeft
		};
	}

	function convertStyle(obj) {
		var style = '';

		for (var a in obj) {
			if (obj.hasOwnProperty(a)) {
				style += (a + ':' + obj[a] + ';');
			}
		}

		return style;
	}

	var Effect = {

		// Effect delay
		duration: 750,

		show: function(e, element) {

			// Disable right click
			if (e.button === 2) {
				return false;
			}

			var el = element || this;

			// Create ripple
			var ripple = document.createElement('div');
			ripple.className = 'waves-ripple';
			el.appendChild(ripple);

			// Get click coordinate and element witdh
			var pos         = offset(el);
			var relativeY   = (e.pageY - pos.top);
			var relativeX   = (e.pageX - pos.left);
			var scale       = 'scale('+((el.clientWidth / 100) * 10)+')';

			// Support for touch devices
			if ('touches' in e) {
			  relativeY   = (e.touches[0].pageY - pos.top);
			  relativeX   = (e.touches[0].pageX - pos.left);
			}

			// Attach data to element
			ripple.setAttribute('data-hold', Date.now());
			ripple.setAttribute('data-scale', scale);
			ripple.setAttribute('data-x', relativeX);
			ripple.setAttribute('data-y', relativeY);

			// Set ripple position
			var rippleStyle = {
				'top': relativeY+'px',
				'left': relativeX+'px'
			};

			ripple.className = ripple.className + ' waves-notransition';
			ripple.setAttribute('style', convertStyle(rippleStyle));
			ripple.className = ripple.className.replace('waves-notransition', '');

			// Scale the ripple
			rippleStyle['-webkit-transform'] = scale;
			rippleStyle['-moz-transform'] = scale;
			rippleStyle['-ms-transform'] = scale;
			rippleStyle['-o-transform'] = scale;
			rippleStyle.transform = scale;
			rippleStyle.opacity   = '1';

			rippleStyle['-webkit-transition-duration'] = Effect.duration + 'ms';
			rippleStyle['-moz-transition-duration']    = Effect.duration + 'ms';
			rippleStyle['-o-transition-duration']      = Effect.duration + 'ms';
			rippleStyle['transition-duration']         = Effect.duration + 'ms';

			rippleStyle['-webkit-transition-timing-function'] = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['-moz-transition-timing-function']    = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['-o-transition-timing-function']      = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';
			rippleStyle['transition-timing-function']         = 'cubic-bezier(0.250, 0.460, 0.450, 0.940)';

			ripple.setAttribute('style', convertStyle(rippleStyle));
		},

		hide: function(e) {
			TouchHandler.touchup(e);

			var el = this;
			var width = el.clientWidth * 1.4;

			// Get first ripple
			var ripple = null;
			var ripples = el.getElementsByClassName('waves-ripple');
			if (ripples.length > 0) {
				ripple = ripples[ripples.length - 1];
			} else {
				return false;
			}

			var relativeX   = ripple.getAttribute('data-x');
			var relativeY   = ripple.getAttribute('data-y');
			var scale       = ripple.getAttribute('data-scale');

			// Get delay beetween mousedown and mouse leave
			var diff = Date.now() - Number(ripple.getAttribute('data-hold'));
			var delay = 350 - diff;

			if (delay < 0) {
				delay = 0;
			}

			// Fade out ripple after delay
			setTimeout(function() {
				var style = {
					'top': relativeY+'px',
					'left': relativeX+'px',
					'opacity': '0',

					// Duration
					'-webkit-transition-duration': Effect.duration + 'ms',
					'-moz-transition-duration': Effect.duration + 'ms',
					'-o-transition-duration': Effect.duration + 'ms',
					'transition-duration': Effect.duration + 'ms',
					'-webkit-transform': scale,
					'-moz-transform': scale,
					'-ms-transform': scale,
					'-o-transform': scale,
					'transform': scale,
				};

				ripple.setAttribute('style', convertStyle(style));

				setTimeout(function() {
					try {
						el.removeChild(ripple);
					} catch(e) {
						return false;
					}
				}, Effect.duration);
			}, delay);
		},

	};


	/**
	 * Disable mousedown event for 500ms during and after touch
	 */
	var TouchHandler = {
		/* uses an integer rather than bool so there's no issues with
		 * needing to clear timeouts if another touch event occurred
		 * within the 500ms. Cannot mouseup between touchstart and
		 * touchend, nor in the 500ms after touchend. */
		touches: 0,
		allowEvent: function(e) {
			var allow = true;

			if (e.type === 'touchstart') {
				TouchHandler.touches += 1; //push
			} else if (e.type === 'touchend' || e.type === 'touchcancel') {
				setTimeout(function() {
					if (TouchHandler.touches > 0) {
						TouchHandler.touches -= 1; //pop after 500ms
					}
				}, 500);
			} else if (e.type === 'mousedown' && TouchHandler.touches > 0) {
				allow = false;
			}

			return allow;
		},
		touchup: function(e) {
			TouchHandler.allowEvent(e);
		}
	};


	/**
	 * Delegated click handler for .waves-effect element.
	 * returns null when .waves-effect element not in "click tree"
	 */
	function getWavesEffectElement(e) {
		if (TouchHandler.allowEvent(e) === false) {
			return null;
		}

		var element = null;
		var target = e.target || e.srcElement;

		while (target.parentElement !== null) {
			if (!(target instanceof SVGElement) && target.className.indexOf('waves-effect') !== -1) {
				element = target;
				break;
			} else if (target.classList.contains('waves-effect')) {
				element = target;
				break;
			}
			target = target.parentElement;
		}

		return element;
	}

	/**
	 * Bubble the click and show effect if .waves-effect elem was found
	 */
	function showEffect(e) {
		var element = getWavesEffectElement(e);

		if (element !== null) {
			Effect.show(e, element);

			if ('ontouchstart' in window) {
				element.addEventListener('touchend', Effect.hide, false);
				element.addEventListener('touchcancel', Effect.hide, false);
			}

			element.addEventListener('mouseup', Effect.hide, false);
			element.addEventListener('mouseleave', Effect.hide, false);
		}
	}

	Waves.displayEffect = function(options) {
		options = options || {};

		if ('duration' in options) {
			Effect.duration = options.duration;
		}

		if ('ontouchstart' in window) {
			document.body.addEventListener('touchstart', showEffect, false);
		}

		document.body.addEventListener('mousedown', showEffect, false);
	};

	window.Waves = Waves;

	document.addEventListener('DOMContentLoaded', function() {
		Waves.displayEffect();
	}, false);

})(window);