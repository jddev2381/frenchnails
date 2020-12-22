

document.addEventListener("DOMContentLoaded",function(){
	setTimeout(function() { 
		dismissMessage(); 
	}, 6000);
});



function dismissMessage() {
	var entireMessage = document.getElementById('flashMessage');
	entireMessage.style.display = 'none';
}



var hands = document.getElementById('hands');
var feet = document.getElementById('feet');

var hands1 = document.getElementById('hands-1');
var feet1 = document.getElementById('feet-1');

var hands21 = document.getElementById('hands-21');
var feet21 = document.getElementById('feet-21');

var hands22 = document.getElementById('hands-22');
var feet22 = document.getElementById('feet-22');

var hands1options = document.getElementById('hands-1-options');
var feet1options = document.getElementById('feet-1-options');

var hands21options = document.getElementById('hands-21-options');
var feet21options = document.getElementById('feet-21-options');

var hands22options = document.getElementById('hands-22-options');
var feet22options = document.getElementById('feet-22-options');



function showh1() {
	hands1.style.display = 'block';
}
function showf1() {
	feet1.style.display = 'block';
}
function showh21() {
	hands21.style.display = 'block';
}
function showh22() {
	hands22.style.display = 'block';
}
function showf21() {
	feet21.style.display = 'block';
}
function showf22() {
	feet22.style.display = 'block';
}


function clearHandsStuff() {
	hands1options.value = '';
	hands21options.value = '';
	hands22options.value = '';
	// to be safe, let's hide them
	hands1.style.display = 'none';
	hands21.style.display = 'none';
	hands22.style.display = 'none';
}

function clearFeetStuff() {
	feet1options.value = '';
	feet21options.value = '';
	feet22options.value = '';
	// to be safe, let's hide them
	feet1.style.display = 'none';
	feet21.style.display = 'none';
	feet22.style.display = 'none';
}

hands.addEventListener('click', function() {
	if(hands.checked) {
		hands1.style.display = 'block';
	} else {
		hands1.style.display = 'none';
		clearHandsStuff();
	}
})

feet.addEventListener('click', function() {
	if(feet.checked) {
		feet1.style.display = 'block';
	} else {
		feet1.style.display = 'none';
		clearFeetStuff();
	}
})


hands1options.addEventListener('change', function(){
	if(hands1options.value == 'mani') {
		hands21.style.display = 'block';
		hands22.style.display = 'none';

	} else if(hands1options.value == 'fill') {
		hands22.style.display = 'block';
		hands21.style.display = 'none';

	} else if(hands1options.value == 'full') {
		hands22.style.display = 'block';
		hands21.style.display = 'none';
	} else if (hands1options.value == '') {
		hands22.style.display = 'none';
		hands21.style.display = 'none';
	}
})

feet1options.addEventListener('change', function(){
	if(feet1options.value == 'pedi') {
		feet21.style.display = 'block';
		feet22.style.display = 'none';

	} else if(feet1options.value == 'paint') {
		feet22.style.display = 'block';
		feet21.style.display = 'none';

	} else if (feet1options.value == '') {
		feet22.style.display = 'none';
		feet21.style.display = 'none';
	}
})








function toggleTechAvailability($id) {
	//console.log($id);

	var techID = $id;
	// Set up our HTTP request
	var xhr = new XMLHttpRequest();

	// Setup our listener to process completed requests
	xhr.onload = function () {

		// Process our return data
		if (xhr.status >= 200 && xhr.status < 300) {
			// What do when the request is successful
			console.log('success!', xhr);
		} else {
			// What do when the request fails
			console.log('The request failed!');
		}

		// Code that should run regardless of the request status
		//console.log('This always runs...');
	};

	// Create and send a GET request
	// The first argument is the post type (GET, POST, PUT, DELETE, etc.)
	// The second argument is the endpoint URL
	xhr.open('GET', 'http://frenchnails.bobahut.net/admin/staff.php?toggleTechAvailability='+techID);
	xhr.send();
}


function dismissDeleteBox($techID) {
	var box = document.getElementById('deleteTech'+$techID);
	box.style.display = 'none';
}

function showDeleteBox($techID) {
	var box = document.getElementById('deleteTech'+$techID);
	box.style.display = 'flex';
	console.log('delete clicked');
}

