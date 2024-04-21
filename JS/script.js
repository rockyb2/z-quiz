const userIcon = document.querySelector('.user-icon');
const userDropdown = document.querySelector('.user-dropdown');

userIcon.addEventListener('mouseover', () => {
  userDropdown.style.display = 'block';
});

userIcon.addEventListener('mouseout', () => {
  userDropdown.style.display = 'none';
});