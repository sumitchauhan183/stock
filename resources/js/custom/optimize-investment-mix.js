let optimizeInvestmentMix = function(){
 
    let search     = $('#search');
    let baseurl    = '/stock/';
    
    search.click(function(){
        let stocks = $("input[type='radio'][name='stocks']:checked").val();
        if(stocks=='all'){
            window.location.href = baseurl+'user/stocks/all';
        }else if(stocks='assets'){
            window.location.href = baseurl+'user/stocks/assets';
        }else if(stocks=='sector'){
            window.location.href = baseurl+'user/stocks/sector';
        }else{
            alert('please select stock type');
        }
    });
  
    return {
      init: function(){
  
      }
  }  
  }();