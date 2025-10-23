let usersData = [];
//let selectedUserData = [];//para activar el boton de guardar cambios

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
            option.value = user.id; // Ponemos id? Necesitariamos crearle el get en la clase Profile
            option.textContent = user.name + " (" + user.email + ")";
            select.appendChild(option);
        });
    }
}

function showUsersData() {
    const select = document.getElementById('userSelect');
    const selectId = select.value;

    if (!selectId) {
        document.getElementById('username').value = "";
        document.getElementById('email').value = "";
        document.getElementById('password').value = "";
        document.getElementById('name').value = "";
        document.getElementById('lastname').value = "";
        document.getElementById('telephone').value = "";

        document.getElementById('deleteUserButton').disabled = true;
        document.getElementById('saveChangesButton').disabled = true;
    } else {
        const user = usersData.find(u => u.id == selectId);
        if (user) {
            document.getElementById('username').value = user.username;
            document.getElementById('email').value = user.email;
            document.getElementById('password').value = user.password;
            document.getElementById('name').value = user.name;
            document.getElementById('lastname').value = user.lastname;
            document.getElementById('telephone').value = user.telephone;
        }

        document.getElementById('deleteUserButton').disabled = false;
        document.getElementById('saveChangesButton').disabled = false;

        //selectedUserData = [user.username, user.email, user.password, user.name, user.lastname, user.telephone]; //para activar el boton de guardar cambios
    }
}

async function deleteUser() { //Trabajando en el metodo todavia
    if (!confirm("Are you sure you want to delete this user?")) {
        return;
    } else {
        const select = document.getElementById('userSelect');
        const selectId = select.value;

        const response = await fetch(`../Api/deleteUser.php?id=${encodeURIComponent(selectId)}`, {
            method: 'DELETE'
        });
        const users = await response.json();
        
        if (users.error) {
            alert("Error deleting user: " + users.error);
        } else{
            alert("User deleted successfully.");
            location.reload();
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    uploadUsers();

    const select = document.getElementById('userSelect');
    select.addEventListener('change', showUsersData);

    const deleteButton = document.getElementById('deleteUserButton');
    deleteButton.addEventListener('click', deleteUser);
});
  