async function createUser(event) {
  event.preventDefault();

  const form = document.getElementById("signup-form");
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
      window.location.href = "user.html";
    } else {
      alert("Error: " + result.message);
    }
  } catch (error) {
    alert("An error occurred while creating the user.");
  }
}

document.addEventListener("DOMContentLoaded", () => {
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
