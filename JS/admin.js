let usersData = [];

async function uploadUsers() {
  try {
    const response = await fetch("../Api/Users.php");
    const result = await response.json();
    const select = document.getElementById("userSelect");

    select.innerHTML = "";

    if (response.status === 404 || response.status === 500) {
      select.innerHTML =
        '<option value="" selected>-- No users available --</option>';
      document.getElementById("deleteUserButton").disabled = true;
      document.getElementById("saveChangesButton").disabled = true;
    } else {
      select.innerHTML =
        '<option value="" selected>-- Choose an user --</option>';
      usersData = result.users;

      result.users.forEach((user) => {
        const option = document.createElement("option");
        option.value = user.id;
        option.textContent = user.name + " (" + user.email + ")";
        select.appendChild(option);
      });
    }
  } catch (error) {
    alert("Error loading users: " + error.message);
  }
}

function showUsersData() {
  const select = document.getElementById("userSelect");
  const selectId = select.value;

  document.querySelector("form").reset();

  if (selectId) {
    const user = usersData.find((u) => u.id == selectId);
    if (user) {
      document.getElementById("username").value = user.username;
      document.getElementById("email").value = user.email;
      document.getElementById("password").value = user.password;
      document.getElementById("name").value = user.name;
      document.getElementById("lastname").value = user.lastname;
      document.getElementById("telephone").value = user.telephone;
      document.querySelector(
        `input[name="gender"][value="${user.gender}"]`
      ).checked = true;
    }

    document.getElementById("deleteUserButton").disabled = false;
    document.getElementById("saveChangesButton").disabled = false;
  } else {
    document.getElementById("deleteUserButton").disabled = true;
    document.getElementById("saveChangesButton").disabled = true;
  }
}

async function deleteUser(event) {
  const select = document.getElementById("userSelect");
  const selectId = select.value;

  event.preventDefault();

  if (!confirm("Are you sure you want to delete this user?")) {
    return;
  }

  try {
    const response = await fetch(
      `../Api/User.php?id=${encodeURIComponent(selectId)}`,
      {
        method: "DELETE",
      }
    );

    const result = await response.json();

    alert(result.message);

    if (result.success) {
      await uploadUsers();
      document.querySelector("form").reset();
    }
  } catch (error) {
    alert("Error deleting user:" + error.message);
  }
}

async function saveChanges(event) {
  const select = document.getElementById("userSelect");
  const selectId = select.value;

  passwordPattern = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
  phonePattern = /^[0-9]{9}$/;

  if (!passwordPattern.test(document.getElementById("password").value)) {
    alert(
      "Password must have at least 8 characters, containing one capital letter and one number."
    );
    event.preventDefault();
    return;
  } else if (!phonePattern.test(document.getElementById("telephone").value)) {
    alert("Telephone number must be exactly 9 digits.");
    event.preventDefault();
    return;
  }

  event.preventDefault();

  const form = document.querySelector("form");
  const formData = new FormData(form);

  try {
    const response = await fetch(
      `../Api/User.php?id=${encodeURIComponent(selectId)}`,
      {
        method: "PUT",
        body: new URLSearchParams(formData), // Converts FormData to URLSearchParams because we use PUT
      }
    );

    const result = await response.json();

    alert(result.message);

    if (result.success) {
      await uploadUsers();
      document.querySelector("form").reset();
    }
  } catch (error) {
    alert("Error saving changes: " + error.message);
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
  } else if (type === "user") {
    window.location.href = "user.html";
    return;
  }

  document.getElementById("profile").textContent =
    localStorage.getItem("username");

  uploadUsers();

  document.getElementById("visibilityButton").addEventListener("click", () => {
    toggleVisibility();
  });

  document.getElementById("telephone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");

    if (this.value.length > 9) {
      this.value = this.value.slice(0, 9);
    }
  });

  document
    .getElementById("userSelect")
    .addEventListener("change", showUsersData);

  document
    .getElementById("deleteUserButton")
    .addEventListener("click", deleteUser);

  document.getElementById("admin-form").addEventListener("submit", saveChanges);

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
