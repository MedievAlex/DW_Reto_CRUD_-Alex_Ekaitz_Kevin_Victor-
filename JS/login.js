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
      window.location.href = `Pages/${userType}.html`;
    } else {
      alert("Error: " + result.message);
    }
  } catch (error) {
    alert("An error occurred while logging in.");
  }
}

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
