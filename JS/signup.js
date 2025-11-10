async function createUser(event) {
  event.preventDefault();

  const form = document.getElementById("signup-form");

  const inputs = form.querySelectorAll("input");

  let allFilled = true;

  inputs.forEach((input) => {
    if (input.value.trim() === "") {
      allFilled = false;
      input.classList.add("error");
    }
  });

  if (!allFilled) {
    alert("Por favor, rellena todos los campos antes de continuar.");
    return; // no continua con el envío
  }

  pattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

  if (pattern.test(document.getElementById("password").value)) {
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
  } else {
    alert(
      "Password must have at least 8 characters and contain one letter and one number."
    );
  }
}

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
