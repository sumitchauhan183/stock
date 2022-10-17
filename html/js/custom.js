 // Menu active
 $(document).ready(function () {
        var url = window.location;
        $('ul.metismenu a[href="' + url + '"]').parent().addClass('active');
        $('ul.metismenu a').filter(function () {
            return this.href == url;
        }).parent().addClass('active');
    });

// Mobile Menu


$('.mobile-toggle .ti-align-right').click(function() {
    $('.app-navbar').addClass('Left0');
    $('.mobile-toggle').addClass('Close');
    });

$('.mobile-toggle .ti-close').click(function() {
    $('.app-navbar').removeClass('Left0');
    $('.mobile-toggle').removeClass('Close');
    });
$('.navbar-toggler .ti-align-right').click(function() {
    $('.navbar-toggler').addClass('Close');
    });

$('.navbar-toggler .ti-close').click(function() {
    $('.navbar-toggler').removeClass('Close');
    });



$(document).ready(function(){
  $(".EditProf").click(function(){
    $("#EditProfile").show();
    $("#ViewProfile").hide();
  });
  $("#UpdateInfo").click(function(){
    $("#EditProfile").hide();
    $("#ViewProfile").show();
  });

});


/**********To Top**********/
$(function(){
$(document).on( 'scroll', function(){
if ($(window).scrollTop() > 100) {
$('.scroll-top-wrapper').addClass('show');
} else {
$('.scroll-top-wrapper').removeClass('show');
}
});
$('.scroll-top-wrapper').on('click', scrollToTop);
});
function scrollToTop() {
verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
element = $('body');
offset = element.offset();
offsetTop = offset.top;
$('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
};


// Search and notifications
jQuery('#SearchBox').click(function() {
        $("#SearchInpt").toggle('300');
    });
jQuery('#NotifIcon').click(function() {
        $("#NotificationBox").toggle('300');
    });
jQuery('#ListIcon').click(function() {
        $(".TopicSear").toggle('0');
    });

jQuery('.PaymentFilterIcon').click(function() {
        $(".PaymentFilterList").toggle('0');
    });
    // Show hide js
    $(document).ready(function(){
        $("#ShowButton").click(function(){
          $("#ShowBtn").show();
        });
        $("#ShowButton1").click(function(){
          $("#ShowBtn").show();
        });
      });

      $(function () {
        $("#chkPassport").click(function () {
            if ($(this).is(":checked")) {
                $("#ShowRdo").show();
            } else {
                $("#ShowRdo").hide();
            }
        });
        $("#chkPassport2").click(function () {
            if ($(this).is(":checked")) {
                $("#ShowRdo2").show();
            } else {
                $("#ShowRdo2").hide();
            }
        });
    });
// Canvas Graph js
window.onload = function () {

var chart = new CanvasJS.Chart("macys", {
	theme: "", // "light2", "dark1", "dark2"
	animationEnabled: false, // change to true
	data: [
	{
		// Change type to "bar", "area", "spline", "pie",etc.
		type: "column",
		dataPoints: [
			{ label: "EV", y: 19  },
			{ label: "TV", y: 18  },
			{ label: "GRM", y: 20  },
			{ label: "DFC", y: 18  },
			{ label: "FCF", y: 19  }
		]
	}
	]
});
chart.render();



var chart = new CanvasJS.Chart("ford", {
	theme: "", // "light2", "dark1", "dark2"
	animationEnabled: false, // change to true
	data: [
	{
		// Change type to "bar", "area", "spline", "pie",etc.
		type: "column",
		dataPoints: [
			{ label: "EV", y: 19  },
			{ label: "TV", y: 18  },
			{ label: "GRM", y: 20  },
			{ label: "DFC", y: 18  },
			{ label: "FCF", y: 19  }
		]
	}
	]
});
chart.render();

};


// Modal Animation

$(".modal").each(function (l) {$(this).on("show.bs.modal", function (l) {var o = $(this).attr("data-easein");"shake" == o ? $(".modal-dialog").velocity("callout." + o) : "pulse" == o ? $(".modal-dialog").velocity("callout." + o) : "tada" == o ? $(".modal-dialog").velocity("callout." + o) : "flash" == o ? $(".modal-dialog").velocity("callout." + o) : "bounce" == o ? $(".modal-dialog").velocity("callout." + o) : "swing" == o ? $(".modal-dialog").velocity("callout." + o) : $(".modal-dialog").velocity("transition." + o);});});
