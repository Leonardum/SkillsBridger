// Unchecks the "yes" answer if that is checked and hides the price input field.
function uncheckYes(isTicked) {
	var price = document.getElementById('price');
	var paymentMethod = document.getElementById('paymentMethod');
	if (isTicked) {
		var paidEntrance = document.getElementById('paidEntrance');
		if (paidEntrance.checked) {
			paidEntrance.checked = false;
			price.style.display = 'none';
			paymentMethod.style.display = 'none';
			
			var entrancePaid = document.getElementById('entrancePaid');
			if (entrancePaid.checked) {
				entrancePaid.checked = false;
			}
			
			var onlinePaid = document.getElementById('onlinePaid');
			if (onlinePaid.checked) {
				var subscriptionPage = document.getElementById('subscriptionPage');
				alternateSubscription = document.getElementById('alternateSubscription');
				if (!alternateSubscription.checked) {
					subscriptionPage.style.display = 'none';
				}
				onlinePaid.checked = false;
			}
			
			/* var children = price.childNodes;
			for(var i = 0; i < children.length; i++) {
				children[i].style.display = 'none';
			} */
		}
	}
}


// Unchecks the "no" answer if that is checked and shows the price input field.
function uncheckNo(isTicked) {
	var price = document.getElementById('price');
	var paymentMethod = document.getElementById('paymentMethod');
	if (isTicked) {
		var freeEntrance = document.getElementById('freeEntrance');
		if (freeEntrance.checked) {
			freeEntrance.checked = false;
		}
		price.style.display = 'block';
		paymentMethod.style.display = 'block';
	} else {
		price.style.display = 'none';
		paymentMethod.style.display = 'none';
		
		var onlinePaid = document.getElementById('onlinePaid');
		if (onlinePaid.checked) {
			onlinePaid.checked = false;
		}
		
		var entrancePaid = document.getElementById('entrancePaid');
		if (entrancePaid.checked) {
			entrancePaid.checked = false;
		}
	}
}


// Unchecks the "online" answer if that is checked.
function uncheckOnline(isTicked) {
	if (isTicked) {
		var onlinePaid = document.getElementById('onlinePaid');
		if (onlinePaid.checked) {
			onlinePaid.checked = false;
			var alternateSubscription = document.getElementById('alternateSubscription');
			if (!alternateSubscription.checked) {
				subscriptionPage.style.display = 'none';
			}
		}
	}
}


// Unchecks the "entrance" answer if that is checked.
function uncheckEntrance(isTicked) {
	var subscriptionPage = document.getElementById('subscriptionPage');
	if (isTicked) {
		var entrancePaid = document.getElementById('entrancePaid');
		if (entrancePaid.checked) {
			entrancePaid.checked = false;
		}
		
		subscriptionPage.style.display = 'block';
	} else {
		var alternateSubscription = document.getElementById('alternateSubscription');
		if (!alternateSubscription.checked) {
			subscriptionPage.style.display = 'none';
		}
	}
}


// Shows the input field for the external link if this box is checked and hides it  if it is not (unless the event should be paid online).
function setSubscriptionPage(isTicked) {
	var subscriptionPage = document.getElementById('subscriptionPage');
	if (isTicked) {
		subscriptionPage.style.display = 'block';
	} else {
		var onlinePaid = document.getElementById('onlinePaid');
		if (!onlinePaid.checked) {
			subscriptionPage.style.display = 'none';
		}
	}
}


/* Shows the textarea to describe who exactly the event is for, in case this box is checked. */
function setOpenFor(isTicked) {
	var openFor = document.getElementById('openFor');
	if (isTicked) {
		openFor.style.display = 'block';
	} else {
		openFor.style.display = 'none';
	}
}


// Unchecks the motivation letter required box when this box is checked.
function setMotivationLetterEncouraged(isTicked) {
	if (isTicked) {
		var motivationLetter = document.getElementById('motivationLetter');
		motivationLetter.checked = false;
	}
}


// Unchecks the motivation letter encouraged box when this box is checked.
function setMotivationLetter(isTicked) {
	if (isTicked) {
		var motivationLetterEncouraged = document.getElementById('motivationLetterEncouraged');
		motivationLetterEncouraged.checked = false;
	}
}


// Unchecks the cv required box when this box is checked.
function setCvEncouraged(isTicked) {
	if (isTicked) {
		var cv = document.getElementById('cv');
		cv.checked = false;
	}
}


// Unchecks the cv encouraged box when this box is checked.
function setCv(isTicked) {
	if (isTicked) {
		var cvEncouraged = document.getElementById('cvEncouraged');
		cvEncouraged.checked = false;
	}
}