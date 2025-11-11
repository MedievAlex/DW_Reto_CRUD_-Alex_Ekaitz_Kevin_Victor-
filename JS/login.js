// Log-ins the User if the credentials are correct
async function login(event) {
  event.preventDefault();

  const form = document.getElementById("login-form");
  const formData = new FormData(form);

  try {
    const response = await fetch(`Api/Login.php`, {
      method: "POST",
      body: formData,
    });

    const result = await response.json();

    if (result.success) {
      const userType = result.profile.type;

      localStorage.setItem("type", userType);
      localStorage.setItem("id", result.profile.id);
      localStorage.setItem("username", result.profile.username);
      window.location.href = `Pages/${userType}.html`;
    } else {
      alert(result.message);
    }
  } catch (error) {
    alert("An error occurred while logging in.");
  }
}

// When loading the page asigns the methods to the buttons
document.addEventListener("DOMContentLoaded", () => {
  const type = localStorage.getItem("type");
  if (type === "admin") {
    window.location.href = "Pages/admin.html";
    return;
  } else if (type === "user") {
    window.location.href = "Pages/user.html";
    return;
  }

  document.getElementById("login-form").addEventListener("submit", login);
});
