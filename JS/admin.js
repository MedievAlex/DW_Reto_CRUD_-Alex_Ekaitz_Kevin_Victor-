async function uploadUsers() {
    const response = await fetch(`../Api/searchAllUsers.php`);
    const users = await response.json();
    const select = document.getElementById('userSelect');

    if (users.error) {
        alert("Error fetching users: " + users.error);
    } else{
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.username; // Ponemos id? Necesitariamos crearle el get en la clase Profile
            option.textContent = user.name + " (" + user.email + ")";
            select.appendChild(option);
        });
    }
}

document.addEventListener("DOMContentLoaded", uploadUsers);
  