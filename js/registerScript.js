const registerForm = document.getElementById('registerForm');
const username = document.getElementById('username');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirmPassword');
const usernameErrorMsg = document.getElementById('usernameErrorMsg');
const passwordErrorMsg = document.getElementById('passwordErrorMsg');
const confirmPasswordErrorMsg = document.getElementById(
  'confirmPasswordErrorMsg'
);
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
function isPasswordSame(pswd, confirm, errorField, msg) {
  if (pswd.value !== confirm.value) {
    errorField.innerText = msg;
    errorField.style.display = 'block';
    return false;
  } else {
    return true;
  }
}
function isRegexValid(field, regex, errorField, msg) {
  if (!regex.test(field.value)) {
    errorField.innerText = msg;
    errorField.style.display = 'block';
    return false;
  } else {
    return true;
  }
}
function valid() {
  const usernameValid = isEmpty(
    username,
    usernameErrorMsg,
    'Username is required'
  )
    ? true
    : false;
  let usernameRegexValid;
  if (usernameValid) {
    usernameRegexValid = isRegexValid(
      username,
      /^[a-zA-Z0-9]*$/,
      usernameErrorMsg,
      'Username must contain only letters and numbers'
    );
  }
  const passwordValid = isEmpty(
    password,
    passwordErrorMsg,
    'Password is required'
  )
    ? true
    : false;
  let passwordStrong;
  if (passwordValid) {
    passwordStrong = isRegexValid(
      password,
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+-]).{8,}$/,
      passwordErrorMsg,
      'Password must contain At least one lowercase letter, At least one uppercase letter, At least one digit, At least one special character, Be at least 8 characters long'
    );
  }
  const confirmPasswordValid = isEmpty(
    confirmPassword,
    confirmPasswordErrorMsg,
    'Confirm password is required'
  )
    ? true
    : false;

  let samePasswordValid;
  if (confirmPasswordValid) {
    samePasswordValid = isPasswordSame(
      password,
      confirmPassword,
      confirmPasswordErrorMsg,
      "Passwords aren't same"
    );
  }
  if (
    usernameValid &&
    usernameRegexValid &&
    passwordValid &&
    passwordStrong &&
    confirmPasswordValid &&
    samePasswordValid
  ) {
    return true;
  } else {
    return false;
  }
}
registerForm.addEventListener('submit', () => {
  username.addEventListener('keyup', () => {
    if (isEmpty(username, usernameErrorMsg, 'Username is required')) {
      isRegexValid(
        username,
        /^[a-zA-Z0-9]*$/,
        usernameErrorMsg,
        'Username must contain only letters and numbers'
      );
    }
  });
  password.addEventListener('keyup', () => {
    if (isEmpty(password, passwordErrorMsg, 'Password is required')) {
      isRegexValid(
        password,
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+-]).{8,}$/,
        passwordErrorMsg,
        'Password must contain At least one lowercase letter, At least one uppercase letter, At least one digit, At least one special character, Be at least 8 characters long'
      );
    }
  });
  confirmPassword.addEventListener('keyup', () => {
    if (
      isEmpty(
        confirmPassword,
        confirmPasswordErrorMsg,
        'Confirm password is required'
      )
    ) {
      isPasswordSame(
        password,
        confirmPassword,
        confirmPasswordErrorMsg,
        "Passwords aren't same"
      );
    }
  });
});
