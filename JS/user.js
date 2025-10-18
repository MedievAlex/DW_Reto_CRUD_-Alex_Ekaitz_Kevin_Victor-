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
