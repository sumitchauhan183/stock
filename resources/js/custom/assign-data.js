let assign =  function(){

  let data = {
      'selectedData':[],
      'selectedTrainer':0,
      'selectedEmployee':0,
      'assignTo':''
  }

  let allSelected = $('#customers-select-all');
  let allSelectBoxSingle = $('input:checkbox[name=customer-select]');
  let trainer = $('#trainer');
  let employee = $('#employee');
  let trainerDrop = $('#tr-drop');
  let employeeDrop = $('#em-drop');
  let btnAssignData = $('#assign-data');

  btnAssignData.click(function(){
      if(data.assignTo=='trainer'){
        if(data.selectedTrainer==0){
            alert('Please select trainer from the list.');
            return;
        }
      }else if(data.assignTo=='employee'){
        if(data.selectedEmployee==0){
            alert('Please select employee from the list.');
            return;
        }
      }else{
          alert('please click either trainer or employee.');
          return;
      }

      if(data.selectedData.length < 1){
          alert('please select atleast single customer data to assign.');
          return;
      }

      trainerDrop.hide();
      employeeDrop.hide();
      //data.selectedTrainer = 0;
      //data.selectedEmployee = 0;
      //data.assignTo = '';
      btnAssignData.hide();
      $.post("assign",
      {
        assignTo: data.assignTo,
        selectedTrainer: data.selectedTrainer,
        selectedEmployee: data.selectedEmployee,
        selectedData: data.selectedData,
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      function(d, status){
        //console.log(d);
        //console.log(status);
        alert("Data: " + d + "\nStatus: " + status);
      });
      


});


    trainerDrop.change(function(){
       data.selectedTrainer = trainerDrop.val();
    });

    employeeDrop.change(function(){
        data.selectedEmployee = employeeDrop.val();
    });




  trainer.click(function(){
       employeeDrop.hide();
       trainerDrop.show();
       data.assignTo = 'trainer';
       btnAssignData.show();
  });

  employee.click(function(){
        trainerDrop.hide();
        employeeDrop.show();
        data.assignTo = 'employee';
        btnAssignData.show();
  });





  allSelected.change(function() {
        if(this.checked) {
            allSelectBoxSingle.prop('checked',true);
            $("input:checkbox[name=customer-select]:checked").each(function(){
                data.selectedData.push($(this).val());
            });
        }else{
            allSelectBoxSingle.prop('checked',false);
            data.selectedData = [];
        }   
  });

  allSelectBoxSingle.change(function(){
    let val = $(this).val();
    if(this.checked) {
        data.selectedData.push(val);
    }else{
        data.selectedData = data.selectedData.filter(function(e){
            return e != val; 
         });
    }  
  });


  return {
      init: function(){

      }
  }  
}();