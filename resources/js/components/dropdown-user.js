window.toggleUserMenu = function (event) {
    event.stopPropagation();

    const dropdown = document.getElementById('userDropdown');
    if (!dropdown) return;

    dropdown.style.display =
        dropdown.style.display === 'flex' ? 'none' : 'flex';
};

document.addEventListener('click', () => {
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.style.display = 'none';
    }
});
