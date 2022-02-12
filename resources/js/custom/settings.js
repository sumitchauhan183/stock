let settings = function(){
   
    let changepassword       = $('#change_password');
    let sendVerificationLink = $('#send_mail_verification');
    let userid               = $('#user_id').val();

    let baseurl        = '/stock/';

    changepassword.click(function(){
        window.location.href = baseurl+'user/password/change';
    });
    sendVerificationLink.click(function(){
        $.ajax({
            method: "POST",
            url: baseurl+"user/verification/mail/send",
            data: {"user_id":userid}
          })
            .done(function( msg ) {
              $('.loader').hide();
              d = JSON.parse(msg);
                 alert(d.message);
              
            });
    });
   
    return {
      init: function(){
  
      }
  }  
  }();