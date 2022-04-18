let sectorstocks = function(){
 
    let search     = $('#search');
    let data       = [];
    let baseurl    = '/stock/';
    
    search.click(function(){
        $("input:checkbox[name=sector]:checked").map(function(){
            data.push(this.value);
        });
        console.log(data);
    });

  
    return {
      init: function(){
  
      }
  }  
  }();