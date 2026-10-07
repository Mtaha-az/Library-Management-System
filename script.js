// Function to toggle between Admin Login and Student Login
function showAdminLogin() {
    document.getElementById('student-login').style.display = 'none';
    document.getElementById('admin-login').style.display = 'block';
    document.getElementById('admin-register').style.display = 'none';
}

function showStudentLogin() {
    document.getElementById('admin-login').style.display = 'none';
    document.getElementById('student-login').style.display = 'block';
    document.getElementById('admin-register').style.display = 'none';
}

// Function to toggle to Admin Registration Page
function showAdminRegister() {
    document.getElementById('admin-login').style.display = 'none';
    document.getElementById('admin-register').style.display = 'block';
}

// Function to show/hide password and change lock/unlock image
function togglePassword(inputId, imgId) {
    let passwordInput = document.getElementById(inputId);
    let lockImage = document.getElementById(imgId);
    let checkbox = document.getElementById(inputId + "-checkbox");

    if (checkbox.checked) {
        passwordInput.type = "text"; // Show password
        lockImage.src = "unlock.png"; // Change to unlock image
    } else {
        passwordInput.type = "password"; // Hide password
        lockImage.src = "lock.png"; // Change back to lock image
    }
}
function validateEmail() {
    const email = document.getElementById("admin_email").value; // Get email field
    const errorMessage = document.getElementById("email-error"); // Error message element
    const emailPattern = /@admin\.library$/; // Regular expression to check if the email ends with @admin.library

    // Check if the email matches the pattern
    if (!emailPattern.test(email)) {
        errorMessage.style.display = "block"; // Show error message
        errorMessage.textContent = "Invalid Email Type"; // Set error message
    } else {
        errorMessage.style.display = "none"; // Hide error message if valid
    }
}
function validatePassword(){
    const passmsg = document.getElementById("Pass-error");
    if (document.getElementById("admin_password_reg").value !== document.getElementById("admin_confirm_password").value) {
        passmsg.style.display = "block"; // Show error message
        passmsg.textContent = "Password Don't Match";
    }
    else{
        passmsg.style.display = "none";
    }
}