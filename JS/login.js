const credential = document.getElementById('credential');
const passwd = document.getElementById('password');
const loginBtn = document.getElementById('loginBtn');

loginBtn.addEventListener("click", () => {
    verifyUser()
});

async function verifyUser() {
    const response = await fetch(`../Api/login.php`);
    const user = response.json();

    if (user.error) {
        alert("Error fetching user: " + user.error);
    } else{
        userData = user;
    }
}