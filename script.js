/*VAlidation*/
const form = document.getElementById('signup-form');
const nameInput = document.getElementById('name');
const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const usertypeInput = document.getElementById('usertype');
const contactInput = document.getElementById('contact');
const cityInput = document.getElementById('city');
const addressInput = document.getElementById('address');

form.addEventListener('submit', (event) => {
  let errors = [];

  if (nameInput.value.trim() === '') {
    errors.push('Name is required.');
  }

  if (usernameInput.value.trim() === '') {
    errors.push('Username is required.');
  }

  if (emailInput.value.trim() === '') {
    errors.push('Email is required.');
  } else if (!isValidEmail(emailInput.value)) {
    errors.push('Email is invalid.');
  }

  if (passwordInput.value.trim() === '') {
    errors.push('Password is required.');
  }

  if (usertypeInput.value.trim() === '') {
    errors.push('User Type is required.');
  }

  if (contactInput.value.trim() === '') {
    errors.push('Contact is required.');
  }

  if (cityInput.value.trim() === '') {
    errors.push('City is required.');
  }

  if (addressInput.value.trim() === '') {
    errors.push('Address is required.');
  }

  if (errors.length > 0) {
    event.preventDefault();
    alert(errors.join('\n'));
  }
});

function isValidEmail(email) {
  // A simple regular expression to check if the email is valid
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
