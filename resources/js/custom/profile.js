let profile = function(){
   
    let first_name = $('#first_name');
    let last_name  = $('#last_name');
    let country    = $('#country');
    let city       = $('#city');
    let state      = $('#state');
    let zipcode    = $('#zipcode');
    let userid     = $('#userid');
    let submit     = $('#save_profile');
    let baseurl    = "/stock/";
    let data = {
                    first_name:first_name.val(),
                    last_name:last_name.val(),
                    country:country.val(),
                    city:city.val(),
                    state:state.val(),
                    userid:userid.val(),
                    zipcode:zipcode.val()
            }
  
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
      $('.loader').show();
      $.ajax({
          method: "POST",
          url: baseurl+"api/user/profile/update",
          data: data
        })
          .done(function( msg ) {
              $('.loader').hide();
            d = JSON.parse(msg);
            if(d.error){
               alert(d.message);
            }else{
               alert(d.message);
               location.reload();
            }
          });
  });
    return {
      init: function(){
  
      }
  }  
  }();