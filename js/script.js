const loginForm = document.getElementById('loginForm');
const username = document.getElementById('username');
const password = document.getElementById('password');
const usernameErrorMsg = document.getElementById('usernameErrorMsg');
const passwordErrorMsg = document.getElementById('passwordErrorMsg');
function isEmpty(field, errorField, msg) {
  if (field.value === '') {
    errorField.innerText = msg;
    errorField.style.display = 'block';
    return false;
  } else {
    errorField.innerText = '';
    return true;
  }
}
loginForm.addEventListener('submit', () => {
  username.addEventListener('keyup', () => {
    isEmpty(username, usernameErrorMsg, 'Username is required');
  });
  password.addEventListener('keyup', () => {
    isEmpty(password, passwordErrorMsg, 'Password is required');
  });
});
function valid() {
  const usernameValid = isEmpty(
    username,
    usernameErrorMsg,
    'Username is required'
  )
    ? true
    : false;
  const passwordValid = isEmpty(
    password,
    passwordErrorMsg,
    'Password is required'
  )
    ? true
    : false;
  if (usernameValid && passwordValid) {
    return true;
  } else {
    return false;
  }
}
