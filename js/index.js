// login forma
console.clear();

const loginBtn = document.getElementById("login");
const signupBtn = document.getElementById("signup");

loginBtn.addEventListener("click", (e) => {
	let parent = e.target.parentNode.parentNode;
	Array.from(e.target.parentNode.parentNode.classList).find((element) => {
		if (element !== "slide-up") {
			parent.classList.add("slide-up");
		} else {
			signupBtn.parentNode.classList.add("slide-up");
			parent.classList.remove("slide-up");
		}
	});
});

signupBtn.addEventListener("click", (e) => {
	let parent = e.target.parentNode;
	Array.from(e.target.parentNode.classList).find((element) => {
		if (element !== "slide-up") {
			parent.classList.add("slide-up");
		} else {
			loginBtn.parentNode.parentNode.classList.add("slide-up");
			parent.classList.remove("slide-up");
		}
	});
});

$('#register').on('click', function (event) {
	event.preventDefault();
	var name = document.getElementById('regName').value;
	var email = document.getElementById('regEmail').value;
	var pw = document.getElementById('regPw').value;
	if (name != "" && email != "" && pw != "") {
		$.ajax({
			url: "includes/action.php",
			type: "POST",
			data: {
				type: 1,
				regName: name,
				regEmail: email,
				regPw: pw
			},
			cache: false,
			success: function (dataResult) {
				console.log(dataResult);
				var dataResult = JSON.parse(dataResult);
				if (dataResult.statusCode == 200) {
					location.href = "glavna.php";
				}
				else if (dataResult.statusCode == 201) {
					$('#errorRegister').html('That email is taken!');
					$('#erorRegName').html('');
					$('#erorRegEmail').html('');
					$('#erorRegPw').html('');
				}
			}
		});
	}
	else {
		$('#erorRegName').html((name == "") ? 'Enter your name !' : '');
		$('#erorRegEmail').html((email == "") ? 'Enter your email!' : '');
		$('#erorRegPw').html((pw == "") ? 'Enter your password!' : '');
	}
});

$('#logIn').on('click', function (event) {
	event.preventDefault();
	var email = document.getElementById('logEmail').value;
	var pw = document.getElementById('logPw').value;
	if (email != "" && pw != "") {
		$.ajax({
			url: "includes/action.php",
			type: "POST",
			data: {
				type: 2,
				logEmail: email,
				logPw: pw
			},
			cache: false,
			success: function (dataResult) {
				var dataResult = JSON.parse(dataResult);
				if (dataResult.statusCode == 200) {
					location.href = "glavna.php";
				}
				else if (dataResult.statusCode == 201) {
					$('#errorLogin').html('Error while logging in !');
					$('#erorLogEmail').html('');
					$('#erorLogPw').html('');
				}
				else if (dataResult.statusCode == 202) {
					$('#errorLogin').html("That user doesn't exhist!");
					$('#erorLogEmail').html('');
					$('#erorLogPw').html('');
				}
			}
		});
	}
	else {
		$('#erorLogEmail').html((email == "") ? 'Enter your email!' : '');
		$('#erorLogPw').html((pw == "") ? 'Enter your password!' : '');
	}
});
