const firstName = document.getElementById('first_name');
const lastName = document.getElementById('last_name');
const dob = document.getElementById('dob');
const phoneNumber = document.getElementById('phone_num');
const email = document.getElementById('email');
const address = document.getElementById('address');
const studentImg = document.getElementById('student_img');
const imgPreview = document.getElementById('img_preview');
const firstNameError = document.querySelector('.invalid-feedback');
const lastNameError = document.getElementById('lname_error');
const dobError = document.getElementById('dob_error');
const phoneNumberError = document.getElementById('phone_error');
const emailError = document.getElementById('email_error');
const addressError = document.getElementById('address_error');
const studentImgError = document.getElementById('img_error');
const studentForm = document.getElementById('studentForm');
const fileName = document.getElementById('img_file_name');

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
function isRegexValid(field, regex, errorField, msg) {
  if (!regex.test(field.value)) {
    errorField.innerText = msg;
    errorField.style.display = 'block';
    return false;
  } else {
    return true;
  }
}
function imageInputCheck(e) {
  const validImgTypes = ['image/jpeg', 'image/png'];
  let isType, isSize;
  isType = isSize = false;
  validImgTypes.forEach((type) => {
    if (e.target.files[0]['type'] === type) {
      isType = true;
      imgPreview.src = URL.createObjectURL(e.target.files[0]);
    }
  });
  if (e.target.files[0]['size'] < 2097152) {
    isSize = true;
  }
  if (!isSize) {
    studentImgError.innerText = 'The file size is larger than 2MB';
    studentImgError.style.display = 'block';
  } else if (!isType) {
    studentImgError.innerText = "The file isn't in jpg, jpeg or png format";
    studentImgError.style.display = 'block';
  } else {
    studentImgError.innerText = '';
    studentImgError.style.display = 'none';
  }

  return { isType, isSize };
}
function inputValidation() {
  firstName.addEventListener('keyup', () => {
    if (isEmpty(firstName, firstNameError, 'First name is required')) {
      isRegexValid(firstName, /^[a-zA-Z]+$/, firstNameError, 'Alphabets only');
    }
  });
  lastName.addEventListener('keyup', () => {
    if (isEmpty(lastName, lastNameError, 'Last name is required')) {
      isRegexValid(lastName, /^[a-zA-Z]+$/, lastNameError, 'Alphabets only');
    }
  });
  dob.addEventListener('keyup', () => {
    isEmpty(dob, dobError, 'Date of Birth is required');
  });
  dob.addEventListener('change', () => {
    isEmpty(dob, dobError, 'Date of Birth is required');
  });
  phoneNumber.addEventListener('keyup', () => {
    if (isEmpty(phoneNumber, phoneNumberError, 'Phone number is required')) {
      isRegexValid(
        phoneNumber,
        /^(?!(\d)\1{9})(?!0123456789|1234567890|0987654321)\d{10}$/,
        phoneNumberError,
        'Invalid phone number'
      );
    }
  });
  email.addEventListener('keyup', () => {
    if (isEmpty(email, emailError, 'Email address is required')) {
      isRegexValid(
        email,
        /^[0-9a-zA-Z-_\$#]+@[0-9a-zA-Z-_\$#]+\.[a-zA-Z]{2,5}/,
        emailError,
        'Invalid email address'
      );
    }
  });
  address.addEventListener('keyup', () => {
    isEmpty(address, addressError, 'Address is required');
  });
  studentImg.addEventListener('change', (e) => {
    imageInputCheck(e);
  });
}
function valid() {
  const fnameValid = isEmpty(
    firstName,
    firstNameError,
    'First name is required'
  );
  let fnameRegex;
  if (fnameValid) {
    fnameRegex = isRegexValid(
      firstName,
      /^[a-zA-Z]+$/,
      firstNameError,
      'Alphabets only'
    );
  }
  const lnameValid = isEmpty(lastName, lastNameError, 'Last name is required');
  let lnameRegex;
  if (lnameValid) {
    lnameRegex = isRegexValid(
      lastName,
      /^[a-zA-Z]+$/,
      lastNameError,
      'Alphabets only'
    );
  }
  const dobValid = isEmpty(dob, dobError, 'Date of Birth is required');
  const phoneValid = isEmpty(
    phoneNumber,
    phoneNumberError,
    'Phone number is required'
  );
  let phoneRegex;
  if (phoneValid) {
    phoneRegex = isRegexValid(
      phoneNumber,
      /^(?!(\d)\1{9})(?!0123456789|1234567890|0987654321)\d{10}$/,
      phoneNumberError,
      'Invalid phone number'
    );
  }
  const emailValid = isEmpty(email, emailError, 'Email address is required');
  let emailRegex;
  if (emailValid) {
    emailRegex = isRegexValid(
      email,
      /^[0-9a-zA-Z-_\$#]+@[0-9a-zA-Z-_\$#]+\.[a-zA-Z]{2,5}/,
      emailError,
      'Invalid email address'
    );
  }
  const addressValid = isEmpty(address, addressError, 'Address is required');
  let imgExtensionValid;
  let imgValid = true;
  if (fileName) {
    if (fileName.value !== '') {
      imgExtensionValid = imageInputCheck({
        target: { files: [studentImg.files[0]] },
      });
    } else {
      imgValid = isEmpty(studentImg, studentImgError, 'Image is required');

      if (imgValid) {
        imgExtensionValid = imageInputCheck({
          target: { files: [studentImg.files[0]] },
        });
      }
    }
  }
  imgValid = isEmpty(studentImg, studentImgError, 'Image is required');

  if (imgValid) {
    imgExtensionValid = imageInputCheck({
      target: { files: [studentImg.files[0]] },
    });
  }
  if (
    fnameValid &&
    fnameRegex &&
    lnameValid &&
    lnameRegex &&
    dobValid &&
    phoneValid &&
    phoneRegex &&
    emailValid &&
    emailRegex &&
    addressValid &&
    imgValid &&
    imgExtensionValid.isSize &&
    imgExtensionValid.isType
  ) {
    return true;
  } else {
    return false;
  }
}
inputValidation();
