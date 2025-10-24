const credential = document.getElementById('credential');
const passwd = document.getElementById('password');
const loginBtn = document.getElementById('loginBtn');

loginBtn.addEventListener("click", () => {
    verifyUser()
});

function verifyUser() {
    const response = fetch(`../Api/login.php`);


}