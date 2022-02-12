let changePassword = function(){
   
    let data = {  
                  password:'',
                  confirm:'',
                  user_id: $('#user_id').val()
    }
  
    let password      = $('#password');
    let confirm       = $('#confirm');
    let submit        = $('#change_password');
    let baseurl       = '/stock/';
  


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

  submit.click(function () {
     
      if(data.password.length<8 || data.password.length>16){
        alert('password must have minimum 8 and maxiumum 16 characters.')
        data.password = '';
        password.val('');
        return;
    }
    if(data.password!=data.confirm){
        alert("Password and confirm password do not match");
        data.confirm = '';
        confirm.val('');
    }
      $('.loader').show();
      $.ajax({
          method: "POST",
          url: baseurl+"api/user/change/password",
          data: data
        })
          .done(function( msg ) {
            d = JSON.parse(msg);
            alert(d.message);
            if(d.error){
                $('.loader').hide();
            }else{
                window.location.href = baseurl+"user/settings";
            }
        });
  });
  
    return {
      init: function(){
  
      }
  }  
  }();