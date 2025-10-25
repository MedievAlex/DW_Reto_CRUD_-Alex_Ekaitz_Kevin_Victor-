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
      alert("User created successfully!");
      window.location.href = "user.html";
    } else {
      alert("Error: " + (result.error || result.message));
    }
  } catch (error) {
    alert("An error occurred while creating the user.");
  }
}

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("signup-form").addEventListener("submit", createUser);

  document.getElementById("telephone").addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");

    if (this.value.length > 9) {
      this.value = this.value.slice(0, 9);
    }
  });
});
