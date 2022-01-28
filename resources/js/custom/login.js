let register = function(){
   
    let data = {  
                  email:'',
                  password:''
    }
  
  
    
    let email      = $('#email');
    let password   = $('#password');
    let submit     = $('#login');
  
  email.change(function(){
      data.email = $(this).val();
      if(!validateEmail(data.email)){
        alert('please enter valid email');
        data.email = '';
        email.val('');
      }else{
          $.ajax({
              method: "POST",
              url: "../api/email/check",
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
  password.change(function(){
      data.password = $(this).val();
  });
  
  submit.click(function () {
      
      if(data.email==''){
          alert('Please enter your email');
          return;
      }
      if(!validateEmail(data.email)){
          alert('Please enter valid email');
          return;
      }
      if(data.password==''){
          alert('Please enter password');
          return;
      }
      $('.loader').show();
      $.ajax({
          method: "POST",
          url: "../api/user/login",
          data: data
        })
          .done(function( msg ) {
            $('.loader').hide();
            d = JSON.parse(msg);
            if(d.error){
               alert(d.message);
               data.password = '';
               password.val('');
            }else{
              if(d.payment){
                window.location.href = "/stock/index.php/user/dashboard";
              }else{
                var url = 'payment';
                var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="user_id" value="' + d.user_id + '" />' +
                '</form>');
                $('body').append(form);
                form.submit();
              }
              
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