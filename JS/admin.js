let usersData = [];
let selectedUserData = [];

async function uploadUsers() {
    const response = await fetch(`../Api/searchAllUsers.php`);
    const users = await response.json();
    const select = document.getElementById('userSelect');

    if (users.error) {
        alert("Error fetching users: " + users.error);
    } else{
        usersData = users;
        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.username; // Ponemos id? Necesitariamos crearle el get en la clase Profile
            option.textContent = user.name + " (" + user.email + ")";
            select.appendChild(option);
        });
    }
}

function showUsersData() {
    const select = document.getElementById('userSelect');
    const selectUsername = select.value;

    if (!selectUsername) {
        document.getElementById('username').value = "";
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
        document.getElementById('name').value = "";
        document.getElementById('lastname').value = "";
        document.getElementById('telephone').value = "";

        document.getElementById('deleteUser').disabled = true;
        document.getElementById('saveChanges').disabled = true;
    } else {
        const user = usersData.find(u => u.username == selectUsername);
        if (user) {
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('password').value = user.password;
            document.getElementById('name').value = user.name;
            document.getElementById('lastname').value = user.lastname;
            document.getElementById('telephone').value = user.telephone;
        }

        document.getElementById('deleteUser').disabled = false;

        selectedUserData = [user.username, user.email, user.password, user.name, user.lastname, user.telephone] //para activar el boton de guardar cambios
    }
}

document.addEventListener("DOMContentLoaded", () => {
    uploadUsers();

    const select = document.getElementById('userSelect');
    select.addEventListener('change', showUsersData);
});
  