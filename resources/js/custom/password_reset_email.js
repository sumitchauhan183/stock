let reset = function(){
   
    let data = {  
                  email:''
    }
  
  
    
    let email      = $('#email');
    let submit     = $('#confirm_email');
  
  email.change(function(){
      data.email = $(this).val();
      if(!validateEmail(data.email)){
        alert('please enter valid email');
        data.email = '';
        email.val('');
      }else{
          $.ajax({
              method: "POST",
              url: "../../../api/email/check",
              data: { email: data.email }
            })
              .done(function( msg ) {
                d = JSON.parse(msg);
                if(!d.error){
                   alert("Email not registered with us");
                   data.email = '';
                   email.val('');
                }
              });
      }
  });
  
  submit.click(function () {
      
      if(data.email==''){
          alert('Please enter your email');
          return;
      }
      $('.loader').show();
      $.ajax({
          method: "POST",
          url: "../../../api/user/send/otp/mail/"+data.email,
          data: data
        })
          .done(function( msg ) {
            
            d = JSON.parse(msg);
            if(d.error){
                $('.loader').hide();
               alert(d.message);
            }else{
                var url = '../reset';
                var form = $('<form action="' + url + '" method="post">' +
                '<input type="hidden" name="user_id" value="' + d.user_id + '" />' +
                '</form>');
                $('body').append(form);
                form.submit();
                $('.loader').hide();
            }
          });
  });
  
  function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }
  
  
  
  
    return {
      init: function(){
  
      }
  }  
  }();