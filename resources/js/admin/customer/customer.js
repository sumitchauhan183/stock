$(document).ready(function() { 

   $('#uploadxl').on('click', function(e){
      $('#imgupload').trigger('click');
      
   });

   $('#imgupload').change(function(){
    let formData = new FormData();           
    formData.append("file", imgupload.files[0]);
          $.ajax({
              url: '../../api/admin/data/addxl',
              type: 'POST',
              data: formData,
              async: false,
              success: function (data) {
                 if(data.error){
                    alert(data.msg);
                 }else{
                     alert('Data uploaded successfully');
                 }
                 $("#imgupload").val('');
              },
              cache: false,
              contentType: false,
              processData: false
          });
  });

 });