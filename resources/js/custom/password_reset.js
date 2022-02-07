let reset = function(){
   
    let data = {  
                  otp:'',
                  password:'',
                  confirm:'',
                  user_id: $('#user_id').val()
    }
  
  
    
    let otp           = $('#otp');
    let password      = $('#password');
    let confirm       = $('#confirm');
    let submit        = $('#reset');
    let resend        = $('#resend');
  
  otp.change(function(){
      data.otp = $(this).val();
      if(data.otp.length<6 || data.otp.length>6){
        alert('otp must have 6 digits');
        data.otp = '';
        otp.val('');
      }else{
          $.ajax({
              method: "POST",
              url: "../../api/otp/check",
              data: { otp: data.otp, user_id: data.user_id }
            })
              .done(function( msg ) {
                d = JSON.parse(msg);
                if(!d.error){
                   otp.attr('readonly',true);
                }else{
                    alert('Invalid OTP entered');
                    data.otp = '';
                    otp.val(''); 
                }
              });
      }
  });

  password.change(function(){
      data.password = $(this).val();
    if(data.password.length<8 || data.password.length>16){
        alert('password must have minimum 8 or maxiumum 16 characters.')
        data.password = '';
        password.val('');
    }else{
        data.password = $(this).val();
    }
    
});
confirm.change(function(){
    data.confirm = $(this).val();
    if(data.password!=data.confirm){
        alert("Password and confirm password do not match");
        data.confirm = '';
        confirm.val('');
    }
});
resend.click(function () {
      
    $('.loader').show();
    $.ajax({
        method: "POST",
        url: "../../api/user/resend/otp/"+data.user_id,
        data: []
      })
        .done(function( msg ) {
          d = JSON.parse(msg);
              $('.loader').hide();
              alert(d.message);
      });
});
  submit.click(function () {
      
      if(data.otp==''){
            alert('Please enter 6 digit OTP sent on your email');  
            data.otp = '';
            otp.val('');
          return;
      }
      if(data.password.length<8 || data.password.length>16){
        alert('password must have minimum 8 and maxiumum 16 characters.')
        data.password = '';
        password.val('');
        return;
    }
      $('.loader').show();
      $.ajax({
          method: "POST",
          url: "../../api/user/reset/password",
          data: data
        })
          .done(function( msg ) {
            d = JSON.parse(msg);
            if(d.error){
                $('.loader').hide();
                alert(d.message);
            }else{
                window.location.href = 'confirm';
                $('.loader').hide();
            }
        });
  });
  
    return {
      init: function(){
  
      }
  }  
  }();