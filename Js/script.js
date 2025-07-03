const container = document.getElementById('container');
const regsiterBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

regsiterBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});