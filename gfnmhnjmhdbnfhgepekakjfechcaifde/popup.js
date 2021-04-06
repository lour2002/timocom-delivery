$(document).ready(function() {
  var current_verification_key = localStorage.getItem('verify_key');
  //console.log(current_verification_key);
  //$('#verification_key').val(current_verification_key);
  $('#current_verification_key').html(current_verification_key);
  //check_verification_code(current_verification_key);

  $(document).on('click', '#set_verification_key', function() {
    var verification_key = $('#verification_key').val();
    set_verificate_key(verification_key);
    // TODO: rewrite to checking key
    $('#status_verification_key').html("<span class=\"text-success\">ok</span>");
    console.log('popopen_set');
  });

  function set_verificate_key(verification_key) {
    localStorage.setItem('verify_key', verification_key);
    $('#verification_key').val('');
    $('#current_verification_key').html(verification_key);
    // check_verification_code(verification_key);
  }

  function check_verification_code(check_key) {
    $.ajax({
      type: 'POST',
      url: 'https://kcilk.company/json/chrome.php',
      data: 'action=check_key&check_key='+check_key,
      success: function(dataRequest) {
        $('#status_verification_key').html(dataRequest);
        if(dataRequest == '<span class="text-success">ok</span>'){
          $('.modal-footer').html('<a href="#" class="open_control_panel" data-href="https://kcilk.company/in.php?t='+check_key+'">Open control panel</a>');
        }else{
          $('.modal-footer').html('<a href="#" class="open_control_panel" data-href="https://kcilk.company">Log in to the control panel</a>');
        }
        //console.log(dataRequest);
      },
      error: function() {
        $('#status_verification_key').html('Error checking');
      }
    });
  }

});
