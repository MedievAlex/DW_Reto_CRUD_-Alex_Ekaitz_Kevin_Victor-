let usersData = [];
//let selectedUserData = [];//para activar el boton de guardar cambios

async function uploadUsers() {
  try {
    const response = await fetch("../Api/Users.php");
    const users = await response.json();
    const select = document.getElementById("userSelect");

    usersData = users;
    users.forEach((user) => {
      const option = document.createElement("option");
      option.value = user.id;
      option.textContent = user.name + " (" + user.email + ")";
      select.appendChild(option);
    });
  } catch (error) {
    alert("Error fetching users:", error);
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

document.addEventListener("DOMContentLoaded", () => {
  uploadUsers();

  const select = document.getElementById("userSelect");
  select.addEventListener("change", showUsersData);

  const deleteButton = document.getElementById("deleteUserButton");
  deleteButton.addEventListener("click", deleteUser);
});
