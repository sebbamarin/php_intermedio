// list countries
fetch('../assets/countries.json')
  .then(response => response.json())
  .then(data => {
    let countries = data.countries;
    let select = document.getElementById('country');
    countries.map(country => {
      let option = document.createElement('option');
      option.value = country.name;
      option.innerHTML = country.name;
      select?.appendChild(option);
    })
  })
  .catch(error => console.log(error));

// list benefits
fetch('../assets/benefits.json')
  .then(response => response.json())
  .then(data => {
    let benefits = data.benefits;
    let select = document.getElementById('benefit');
    benefits.map(benefit => {
      let option = document.createElement('option');
      option.value = benefit.name;
      option.innerHTML = benefit.name;
      select?.appendChild(option);
    })
  })
  .catch(error => console.log(error));

// form complaints
const form = document.forms['complaint-form'];
// validate form
const validateForm = event => {
  if (form.country.value == 'Select a Country') {
    form.country.value = '';
  } if (form.benefit.value == 'Select a Benefit') {
    form.benefit.value = '';
  } if (form.tier.value == 'Select a Tier') {
    form.tier.value = '';
  } if (form.digits.value.length < 6) {
    form.digits.value = '';
  }
  if (!form.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
    form.classList.add('was-validated');
    return false;
  } else {
    form.classList.remove('was-validated');
    form.submit.disabled = true;
    document.getElementById('textSubmit').classList.add('d-none');
    document.getElementById('loader').classList.remove('d-none');
    form.method = 'POST';
    form.action = '../db/create_complaint.php';
    return true;
  }
}

// form Login
const formLogin = document.forms['login-complaint-form'];
// validate form
const validateFormLogin = event => {
  if (formLogin.password.value.length < 6 || formLogin.password.value.length > 8) {
    formLogin.password.value = '';
  }
  if (!formLogin.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
    formLogin.classList.add('was-validated');
    return false;
  } else {
    formLogin.classList.remove('was-validated');
    formLogin.submit.disabled = true;
    document.getElementById('textSubmit').classList.add('d-none');
    document.getElementById('loader').classList.remove('d-none');
    formLogin.method = 'POST';
    return true;
  }
}

// form Register
const formRegister = document.forms['register-complaint-form'];
// validate form
const validateFormRegister = event => {
  if (formRegister.user_password.value.length < 6 || formRegister.user_password.value.length > 8) {
    formRegister.user_password.value = '';
    formRegister.user_password_repeat.value = '';
  }
  if (formRegister.user_password.value != formRegister.user_password_repeat.value) {
    formRegister.user_password.value = '';
    formRegister.user_password_repeat.value = '';
  }
  if (!formRegister.checkValidity()) {
    event.preventDefault();
    event.stopPropagation();
    formRegister.classList.add('was-validated');
    return false;
  } else {
    formRegister.classList.remove('was-validated');
    formRegister.submit.disabled = true;
    document.getElementById('textSubmit').classList.add('d-none');
    document.getElementById('loader').classList.remove('d-none');
    formRegister.method = 'POST';
    return true;
  }
}

// filter change option
const filter_change = (elem) => {
  document.getElementById('btn_filter').disabled = false;
  elem.style.borderColor = 'var(--primary)';
  elem.style.borderWidth = '2px';
}

// filter list admin
const filter_list = () => {
  let digits = document.getElementById('filter_digits')?.value;
  let benefit = document.getElementById('filter_benefit')?.value;
  let tier = document.getElementById('filter_tier')?.value;
  let country = document.getElementById('filter_country')?.value;
  let email = document.getElementById('filter_email')?.value;
  let date = document.getElementById('filter_date')?.value;
  let state = document.getElementById('filter_state')?.value;
  let url = '../admin/?filter=complaints&';
  if (digits != 'Digits') {
    url += 'digits=' + digits + '&';
  } if (benefit != 'Benefit') {
    url += 'benefit=' + benefit + '&';
  } if (tier != 'Tier') {
    url += 'tier=' + tier + '&';
  } if (country != 'Country') {
    url += 'country=' + country + '&';
  } if (email != 'Email') {
    url += 'email=' + email + '&';
  } if (date != 'Date') {
    url += 'date=' + date + '&';
  } if (state != 'State') {
    url += 'state=' + state;
  }
  window.location.href = url;
}

function exportTableToExcel(filename = '') {
  let downloadLink;
  let dataType = 'application/vnd.ms-excel';
  let tableSelect = document.getElementsByTagName("table");
  let tableHTML = tableSelect[1].outerHTML.replace(/ /g, '%20');
  // Specify file name
  if (filename == '') {
    filename = 'complaints.xls';
  }
  // Create download link element
  downloadLink = document.createElement("a");
  document.body.appendChild(downloadLink);
  if (navigator.msSaveOrOpenBlob) {
    var blob = new Blob(['\ufeff', tableHTML], {
      type: dataType
    });
    navigator.msSaveOrOpenBlob(blob, filename);
  } else {
    // Create a link to the file
    downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    // Setting the file name
    downloadLink.download = filename;
    //triggering the function
    downloadLink.click();
  }
}