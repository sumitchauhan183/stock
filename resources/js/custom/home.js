let home = function(){
   
    let data = {
        'selectedTool':[]
    }  

  
  $('#register').click(function(){
    
    if(data.selectedTool.length<1){
        alert("select atleast one tool");
    }else{
        let tool = 0;
        let toolone = data.selectedTool.filter(function( obj ) {
            return obj.name == 'tool-one';
          }).length;

        let tooltwo = data.selectedTool.filter(function( obj ) {
            return obj.name == 'tool-two';
          }).length;  

        if(toolone==1 && tooltwo==1){
           tool = 3;
        }else if(toolone==1){
            tool = 1;
        }else if(tooltwo==1){
            tool = 2;
        }  
        
        var url = 'user/register';
        var form = $('<form action="' + url + '" method="post">' +
        '<input type="text" name="tool" value="' + tool + '" />' +
        '</form>');
        $('body').append(form);
        form.submit();
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
});

  return {
    init: function(){

    }
}  
}();