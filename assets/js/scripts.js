// Sign-In Form Validation
document.getElementById('signInForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
  
    if (email === "" || password === "") {
      alert("Please fill out all fields.");
    } else {
      alert("Sign-In Successful!");
    }
  });
  
  // Sign-Up Form Validation
  document.getElementById('signUpForm').addEventListener('submit', function (e) {
    e.preventDefault();
    let firstName = document.getElementById('firstName').value;
    let lastName = document.getElementById('lastName').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmPassword').value;
  
    if (firstName === "" || lastName === "" || email === "" || password === "" || confirmPassword === "") {
      alert("Please fill out all fields.");
    } else if (password !== confirmPassword) {
      alert("Passwords do not match.");
    } else {
      alert("Sign-Up Successful!");
    }
  });
  