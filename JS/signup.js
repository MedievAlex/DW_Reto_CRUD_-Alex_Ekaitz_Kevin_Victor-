// Creates the User
async function createUser(event) {
  event.preventDefault();

  passwordPattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  phonePattern = /^[0-9]{9}$/;

  if (!passwordPattern.test(document.getElementById("password").value)) {
    alert("Password must have at least 8 characters, containing one number and both, one captial letter and not one.");
  } else if (!phonePattern.test(document.getElementById("telephone").value)) {
    alert("Telephone number must be exactly 9 digits.");
  } else {
    const form = document.querySelector("form");
    const formData = new FormData(form);

    try {
      const response = await fetch(`../Api/User.php`, {
        method: "POST",
        body: formData,
      });

      const result = await response.json();

      if (result.success) {
        localStorage.setItem("type", "user");
        localStorage.setItem("id", result.user.id);
        localStorage.setItem("username", result.user.username);
        window.location.href = "user.html";
      } else {
        alert(result.message);
      }
    } catch (error) {
      alert("An error occurred while creating the user.");
    }
  }
}

// Shows or hides the Password value
function toggleVisibility() {
  const passwordInput = document.getElementById("password");
  const icon = document.getElementById("icon");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.textContent = "visibility_off";
  } else {
    passwordInput.type = "password";
    icon.textContent = "visibility";
  }
}

// When loading the page asigns the methods to the buttons
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("visibilityButton").addEventListener("click", () => {
    toggleVisibility();
  });

  const userType = localStorage.getItem("type");
  if (userType === "admin") {
    window.location.href = "admin.html";
    return;
  } else if (userType === "user") {
    window.location.href = "user.html";
    return;
  }

  document.getElementById("signup-form").addEventListener("submit", createUser);

  document.getElementById("telephone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");

    if (this.value.length > 9) {
      this.value = this.value.slice(0, 9);
    }
  });
});
