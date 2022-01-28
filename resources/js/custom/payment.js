let payment = function () {
    
    $('.paynow').click(function(e) {
        $('.loader').show();
        if($('.owner_name').val()==''){
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text('Please enter card owner name');
                $('.loader').hide();
                return;

        }
        if($('.card-number').val()==''){
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text('Please enter card number');
                $('.loader').hide();
                return;
        }

        if($('.card-expiry-month').val()==''){
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text('Please enter expiry month');
            $('.loader').hide();
                return;
        }

        if($('.card-expiry-year').val()==''){
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text('Please enter expiry year');
            $('.loader').hide();
                return;
        }

        if($('.card-cvc').val()==''){
            $('.error')
            .removeClass('hide')
            .find('.alert')
            .text('Please enter cvv');
            $('.loader').hide();
            return;
        }
            Stripe.setPublishableKey($('.require-validation').data('stripe-publishable-key'));
            Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
    });
    function stripeResponseHandler(status, response) {
        $('.loader').hide();
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);
        } else {
            /* token contains id, last4, and card type */
            var token = response['id'];
            var form = $('<form action="'+$('.require-validation').data('action')+'" method="post">' +
            "<input type='hidden' name='stripeToken' value='" + token + "'/>"+
            "<input type='hidden' name='user_id' value='" + $('#user_id').val() + "'/>"+
            "<input type='hidden' name='exp_mon'  value='" + $('.card-expiry-month').val() + "'/>"+
            "<input type='hidden' name='exp_year' value='" + $('.card-expiry-year').val() + "'/>"+
            "<input type='hidden' name='card_type'  value='" + $("#authorizenet_cc_type").val() + "'/>"+
            "<input type='hidden' name='owner_name' value='" + $('.owner_name').val() + "'/>"+
            "<input type='hidden' name='card_number' value='" + $('#credit-card-type').val() + "'/>"+
            '</form>');
            $('body').append(form);
            form.submit();
        }
    }

    function getCreditCardType(val) {
        if(!val || !val.length) return undefined;
        switch(val.charAt(0)) {
            case '4': return 'visa';
            case '5': return 'mastercard';
            case '3': return 'amex';
            case '6': return 'discover';
        }
        return undefined;
    }

    $('.card-expiry-month').keyup(function() {
        let val = $(this).val(); 
        if(val.length > 2){
            $('.card-expiry-month').val(val.substring(0,2));
        }
    });

    $('.card-expiry-year').keyup(function() {
        let val = $(this).val(); 
        if(val.length > 4){
            $('.card-expiry-year').val(val.substring(0,4));
        }
    });

    $('#credit-card-type').keyup(function() {
       $("#authorizenet_cc_type").val('');
       let val = $(this).val(); 
    if(val.length > 3){
        switch(getCreditCardType($(this).val())) {
            case 'visa':
             $("#authorizenet_cc_type").val('VISA');
              break;
            case 'mastercard':
             $("#authorizenet_cc_type").val('Master Card');
              break;
            case 'amex':
              $("#authorizenet_cc_type").val('American Express');
              break;
            case 'discover':
             $("#authorizenet_cc_type").val('Discover');
              break;
            default:
               $("#authorizenet_cc_type").val('Unknown');
               break;
          };
    }
    if(val.length > 16){
        $('#credit-card-type').val(val.substring(0,16));
    }
       
    });

return {
    init: function(){

    }
} 
}();