let register = function(){
   
  let data = {
                first_name:'',
                last_name:'',
                country:'USA',
                city:'',
                state:'',
                email:'',
                userid:'',
                password:'',
                confirm:'',
                tool:'',
                zipcode:''
  }


  let first_name = $('#first_name');
  let last_name  = $('#last_name');
  let country    = $('#country');
  let city       = $('#city');
  let state      = $('#state');
  let zipcode    = $('#zipcode');
  let email      = $('#email');
  let userid     = $('#userid');
  let password   = $('#password');
  let confirm    = $('#confirm');
  let submit     = $('#register_2');



first_name.change(function(){
      data.first_name = $(this).val();
});
last_name.change(function(){
    data.last_name = $(this).val();
});
country.change(function(){
    data.country = $(this).val();
});
city.change(function(){
    data.city = $(this).val();
});
state.change(function(){
    data.state = $(this).val();
});
zipcode.change(function(){
    data.zipcode = $(this).val();
});
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
              if(d.error){
                 alert(d.message);
                 data.email = '';
                 email.val('');
              }
            });
    }
});
userid.change(function(){
    data.userid = $(this).val();
    $.ajax({
        method: "POST",
        url: "../api/userid/check",
        data: { userid: data.userid }
      })
        .done(function( msg ) {
          d = JSON.parse(msg);
          if(d.error){
             alert(d.message);
             data.userid = '';
             userid.val('');
          }
        });
});
password.change(function(){
    data.password = $(this).val();
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
    if(data.first_name==''){
        alert('Please enter your first name');
        return;
    }
    if(data.last_name==''){
        alert('Please enter your last name');
        return;
    }
    if(data.city==''){
        alert('Please enter city');
        return;
    }
    if(data.state==''){
        alert('Please enter state');
        return;
    }
    if(data.zipcode==''){
        alert('Please enter zipcode');
        return;
    }
    if(data.email==''){
        alert('Please enter your email');
        return;
    }
    if(!validateEmail(data.email)){
        alert('Please enter valid email');
        return;
    }
    if(data.userid==''){
        alert('Please enter userid');
        return;
    }
    if(data.password==''){
        alert('Please enter password');
        return;
    }
    if(data.confirm==''){
        alert('Please enter confirm password');
        return;
    }
    data.tool = $('#tool').val();
    $('.loader').show();
    $.ajax({
        method: "POST",
        url: "../api/user/register",
        data: data
      })
        .done(function( msg ) {
            $('.loader').hide();
          d = JSON.parse(msg);
          if(d.error){
             alert(d.message);
             data.email = '';
             data.userid = '';
             email.val('');
             userid.val('');
          }else{
            var url = 'payment';
            var form = $('<form action="' + url + '" method="post">' +
            '<input type="text" name="user_id" value="' + d.user_id + '" />' +
            '</form>');
            $('body').append(form);
            form.submit();
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