function togglePassword() {
  const passwordField = document.getElementById('password');
  const toggleIcon = document.getElementById('toggleIcon');
  const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordField.setAttribute('type', type);
  toggleIcon.classList.toggle('bi-eye-slash');
}
