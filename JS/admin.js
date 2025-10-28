let usersData = [];
//let selectedUserData = [];//para activar el boton de guardar cambios

async function uploadUsers() {
  try {
    const response = await fetch("../Api/Users.php");
    const users = await response.json();
    const select = document.getElementById("userSelect");

    select.innerHTML = "";

    if (!users || users.length === 0) {
      select.innerHTML =
        '<option value="" selected>-- No users available --</option>';

      document.getElementById("deleteUserButton").disabled = true;
      document.getElementById("saveChangesButton").disabled = true;
    } else {
      select.innerHTML =
        '<option value="" selected>-- Choose an user --</option>';
      usersData = users;

      users.forEach((user) => {
        const option = document.createElement("option");
        option.value = user.id;
        option.textContent = user.name + " (" + user.email + ")";
        select.appendChild(option);
      });
    }
  } catch (error) {
    console.error("Error fetching users:", error);
    alert("Error loading users: " + error.message);
  }
}

function showUsersData() {
  const select = document.getElementById("userSelect");
  const selectId = select.value;

  if (!selectId) {
    document.getElementById("username").value = "";
    document.getElementById("email").value = "";
    document.getElementById("password").value = "";
    document.getElementById("name").value = "";
    document.getElementById("lastname").value = "";
    document.getElementById("telephone").value = "";

    document.getElementById("deleteUserButton").disabled = true;
    document.getElementById("saveChangesButton").disabled = true;
  } else {
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

    //selectedUserData = [user.username, user.email, user.password, user.name, user.lastname, user.telephone]; //para activar el boton de guardar cambios
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
      location.reload();
    }
  } catch (error) {
    alert("Error deleting user:", error);
  }
}

async function saveChanges(event) {}

document.addEventListener("DOMContentLoaded", () => {
  const type = localStorage.getItem("type");
  if (!type) {
    window.location.href = "../index.html";
    return; // Para que no ejecute el resto del código
  } else if (type === "user") {
    window.location.href = "user.html";
    return;
  }

  document.getElementById("profile").textContent =
    localStorage.getItem("username");

  uploadUsers();

  document
    .getElementById("userSelect")
    .addEventListener("change", showUsersData);

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
