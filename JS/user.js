async function showUserData() {
  const userId = localStorage.getItem("id");

  try {
    const response = await fetch(
      `../Api/User.php?id=${encodeURIComponent(userId)}`
    );

    const result = await response.json();

    if (result.success) {
      document.getElementById("username").value = result.user.username;
      document.getElementById("email").value = result.user.email;
      document.getElementById("password").value = result.user.password;
      document.getElementById("name").value = result.user.name;
      document.getElementById("lastname").value = result.user.lastname;
      document.getElementById("telephone").value = result.user.telephone;
      document.querySelector(
        `input[name="gender"][value="${result.user.gender}"]`
      ).checked = true;

      document.getElementById("deleteUserButton").disabled = false;
      document.getElementById("saveChangesButton").disabled = false;
    } else {
      alert(result.message);
      document.getElementById("deleteUserButton").disabled = true;
      document.getElementById("saveChangesButton").disabled = true;
    }
  } catch (error) {
    alert("Error fetching user data:" + error.message);
  }
}

async function deleteUser(event) {
  const userId = localStorage.getItem("id");

  event.preventDefault();

  if (!confirm("Are you sure you want to delete your account?")) {
    return;
  }

  try {
    const response = await fetch(
      `../Api/User.php?id=${encodeURIComponent(userId)}`,
      {
        method: "DELETE",
      }
    );

    const result = await response.json();

    if (result.success) {
      localStorage.removeItem("type");
      localStorage.removeItem("id");
      localStorage.removeItem("username");
      window.location.href = "../index.html";
    }
  } catch (error) {
    alert("Error deleting user:" + error.message);
  }
}

async function saveChanges(event) {
  const userId = localStorage.getItem("id");

  event.preventDefault();

  pattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

  if (pattern.test(document.getElementById("password").value)) {
    // Verifyes if the password matches the pattern
    const form = document.querySelector("form");
    const formData = new FormData(form);

    try {
      const response = await fetch(
        `../Api/User.php?id=${encodeURIComponent(userId)}`,
        {
          method: "PUT",
          body: new URLSearchParams(formData), // Converts FormData to URLSearchParams because we use PUT
        }
      );

      const result = await response.json();

      alert(result.message);
    } catch (error) {
      alert("Error saving changes:" + error.message);
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
  const type = localStorage.getItem("type");
  if (!type) {
    window.location.href = "../index.html";
    return;
  } else if (type === "admin") {
    window.location.href = "admin.html";
    return;
  }

  document.getElementById("profile").textContent =
    localStorage.getItem("username");

  showUserData();

  document.getElementById("visibilityButton").addEventListener("click", () => {
    toggleVisibility();
  });

  document
    .getElementById("deleteUserButton")
    .addEventListener("click", deleteUser);

  document
    .getElementById("saveChangesButton")
    .addEventListener("click", saveChanges);

  document
    .getElementById("logoutLink")
    .addEventListener("click", function (event) {
      event.preventDefault();

      if (!confirm("Are you sure you want to log out?")) {
        return;
      }

      localStorage.removeItem("type");
      localStorage.removeItem("id");
      localStorage.removeItem("username");
      window.location.href = "../index.html";
    });
});
