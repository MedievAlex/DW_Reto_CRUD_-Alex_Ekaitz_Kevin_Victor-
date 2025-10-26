const visibilityBtn = document.getElementById("visibilityBtn");
const deleteUserBtn = document.getElementById("deleteUser");
const saveChangesBtn = document.getElementById("saveChanges");

visibilityBtn.addEventListener("click", () => {
  toggleVisibility();
});

deleteUserBtn.addEventListener("click", () => {});

saveChangesBtn.addEventListener("click", () => {});

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
    return; // Para que no ejecute el resto del código
  } else if (type === "admin") {
    window.location.href = "admin.html";
    return;
  }

  document
    .getElementById("logoutLink")
    .addEventListener("click", function (event) {
      event.preventDefault();

      if (!confirm("Are you sure you want to log out?")) {
        return;
      }

      localStorage.removeItem("type");
      localStorage.removeItem("id");
      window.location.href = "../index.html";
    });
});
