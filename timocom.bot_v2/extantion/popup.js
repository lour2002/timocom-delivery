document.addEventListener("DOMContentLoaded", function () {

  // Elements

  const divUserKey = document.getElementById('verification_key'),
        inputUserKey = document.getElementById('verification_key_input'),
        textUserKey = document.getElementById('current_verification_key'),
        btnUserKey = document.getElementById('set_verification_key'),
        textStatusUserKey = document.getElementById('status_verification_key');

  const current_verification_key = localStorage.getItem('verify_key');

  if (current_verification_key) {
    textUserKey.innerText = current_verification_key;
    textStatusUserKey.innerHTML = "<span class=\"text-success\">ok</span>";
    divUserKey.classList.add('d-none');
  }

  btnUserKey.addEventListener("click", function () {
    var verification_key = inputUserKey.value;
    set_verificate_key(verification_key);
    textStatusUserKey.innerHTML = "<span class=\"text-success\">ok</span>";
  });

  function set_verificate_key(verification_key) {
    localStorage.setItem('verify_key', verification_key);
    inputUserKey.value = '';
    textUserKey.innerHTML = verification_key;
    divUserKey.classList.add('d-none');
  }
});
