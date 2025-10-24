const credential = document.getElementById('credential');
const passwd = document.getElementById('password');
const loginBtn = document.getElementById('loginBtn');

loginBtn.addEventListener("click", () => 
{
    credential = document.getElementById('credential').value;
    passwd = document.getElementById('password').value;
    credential = document.getElementById('credential').value;
    
    if(document.getElementById('credential').value == " " || document.getElementById('password').value == " ")
    {
        alert("Los campos no pueden estar vacios.");
    }
    else
    {
        verifyUser(credential, passwd);
    }
});

async function verifyUser(credential, passwd) 
{
    const response = await fetch(`../Api/login.php`);
    const user = response.json();

    if (user.error) 
    {
        alert("Error verifying the user.");
    } 
    else
    {
        userData = user;
    }
}