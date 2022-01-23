let home = function(){
   
    let data = {
        'selectedTool':[]
    }  

  
  $('#register').click(function(){
    
    if(data.selectedTool.length<1){
        alert("select atleast one tool");
    }else{
        window.location.href = "index.php/user/register";
    }
  });

  $('#tool-one').change(function(){
    if( $(this).is(':checked') ) {
        data.selectedTool.push({'name':'tool-one'});
    }else{
        data.selectedTool =  data.selectedTool.filter(function( obj ) {
            return obj.name !== 'tool-one';
          });
    }
    console.log(data.selectedTool);
  });

$('#tool-two').change(function(){
    if( $(this).is(':checked') ) {
        data.selectedTool.push({'name':'tool-two'});
    }else{
        data.selectedTool =  data.selectedTool.filter(function( obj ) {
            return obj.name !== 'tool-two';
          });
    }
    console.log(data.selectedTool);
});

  return {
    init: function(){

    }
}  
}();