$(document).ready(function () {
    var myhight = $('nav').height();
    $('body').css('padding-top', myhight + 20);

    $('.sign').on('click', function () {
        $('.signup').hide();
        $('.signin').show();
    });


    $('.rigstr').on('click', function () {
        $('.signin').hide();
        $('.signup').show();
    });
    $('.close-e').on('click', function (){

      $('.dropdown-menu').fadeOut();

    });

    var lbl= $('.lblerror');
    lbl.hide();

    $('.btn-submit').on('click',function(){
        var mypass= $('.new-pass').val();
        var mycheck= $('.check-pass').val();

        if (mypass == mycheck) {
            lbl.hide();
        }else{
            lbl.show();
        }

    });

});
$('.carousel').carousel();
/*$(document).ready(function () {
    $(".owl-carousel").owlCarousel({
        items: 5,
        margin: 10,
        responsive: {
            1200: {
                items: 3.2
            },
            800: {
                items: 2.5
            },
            500: {
                items: 2
            }
        }
    });
});*/

  // Count value number
  $(document).ready(function(){
    $('.inc').on('click',function(){
        var myinput = $('.count');
        var myvilue = parseInt(myinput.val());
        myvilue = myvilue +1;
        myinput.val(myvilue);
    });
    $('.dec').on('click',function(){
        var myinput = $('.count');
        var myvilue = parseInt(myinput.val());
        myvilue = myvilue -1;
        myinput.val(myvilue);
    });

    // Img GAllary
    $('.smallg img').on('click',function(){
       $('.bigimg').attr('src', $(this).attr('src'));
    });
});



/****** to preview uploaded image ******/
function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
    $('#blah')
    .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
    }
    }
    /****************************************/

    $(document).ready(function(){
        $('.tabs li').on("click",function(){
            $(this).addClass('active').siblings().removeClass('active');
        });


    });
    $('.menu').click(function(){
        $('.dropdown-menu').show();


        });

/*******************NavCart*********************/

(function(){
 $(document).click(function() {
    var $item = $(".shopping-cart");
    if ($item.hasClass("active")) {
      $item.removeClass("active");
    }
  });

  $('.shopping-cart').each(function() {
    var delay = $(this).index() * 50 + 'ms';
    $(this).css({
        '-webkit-transition-delay': delay,
        '-moz-transition-delay': delay,
        '-o-transition-delay': delay,
        'transition-delay': delay
    });
  });
  $('#cart').click(function(e) {
    e.stopPropagation();
    $(".shopping-cart").toggleClass("active");
  });

  $('#addtocart').click(function(e) {
    e.stopPropagation();
    $(".shopping-cart").toggleClass("active");
  });
  
    $('[data-mask]').inputmask();
    
    //Date picker
    $('.datepicker').datepicker({
            autoclose: true,
            // minDate: '2',
            startDate: '-1000y',
            endDate: '-15y',
            format: "yyyy-mm-dd",
            // todayHighlight: true,
        })
})();


//// Add Class CArt page

$(document).ready(function () {
  $('.click').on('click',function(){
    $('.dropdown-content').fadeToggle();
  });
});
