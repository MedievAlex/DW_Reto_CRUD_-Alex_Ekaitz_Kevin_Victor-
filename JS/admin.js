let usersData = [];
//let selectedUserData = [];//para activar el boton de guardar cambios

async function uploadUsers() {
    try {
        const response = await fetch('../Api/searchAllUsers.php');
        const users = await response.json();
        const select = document.getElementById('userSelect');

        if (users == '') {
            alert("No users available");
        } else {
            usersData = users;
            users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = user.name + " (" + user.email + ")";
                select.appendChild(option);
            });
        }
    } catch (error) {
        alert("Error fetching users:", error);
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
        try {
            const select = document.getElementById('userSelect');
            const selectId = select.value;

            alert(`Sending ID: ${selectId}`);
            const response = await fetch(`http://localhost/DW/DW_Reto_CRUD_-Alex_Ekaitz_Kevin_Victor-/Api/deleteUser.php?id=${encodeURIComponent(selectId)}`, {
            method: 'POST',
            });

            const deleted = await response.json();
            
            if (deleted.success) {
                alert(deleted.message);
            } else {
                alert(deleted.message);
            }
        } catch (error) {
            alert("Error deleting user:", error);
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
  