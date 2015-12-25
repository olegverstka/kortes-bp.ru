$(function(){
    $(".file_upload_1").click(function(){
        var wrapper = $( ".file_upload_1" ),
            inp = wrapper.find( ".input_1" ),
            btn = wrapper.find( ".button_1" ),
            lbl = wrapper.find( ".div_1" );

        btn.focus(function(){
            inp.focus()
        });
        // Crutches for the :focus style:
        inp.focus(function(){
            wrapper.addClass( "focus" );
        }).blur(function(){
            wrapper.removeClass( "focus" );
        });

        var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

        inp.change(function(){
            var file_name;
            if( file_api && inp[ 0 ].files[ 0 ] ) 
                file_name = inp[ 0 ].files[ 0 ].name;
            else
                file_name = inp.val().replace( "C:\\fakepath\\", '' );

            if( ! file_name.length )
                return;

            if( lbl.is( ":visible" ) ){
                lbl.text( file_name );
                btn.text( "Выбрать" );
            }else
                btn.text( file_name );
        }).change();
    });

    $(".file_upload_2").click(function(){
        var wrapper = $( ".file_upload_2" ),
            inp = wrapper.find( ".input_2" ),
            btn = wrapper.find( ".button_2" ),
            lbl = wrapper.find( ".div_2" );

        btn.focus(function(){
            inp.focus()
        });
        // Crutches for the :focus style:
        inp.focus(function(){
            wrapper.addClass( "focus" );
        }).blur(function(){
            wrapper.removeClass( "focus" );
        });

        var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

        inp.change(function(){
            var file_name;
            if( file_api && inp[ 0 ].files[ 0 ] ) 
                file_name = inp[ 0 ].files[ 0 ].name;
            else
                file_name = inp.val().replace( "C:\\fakepath\\", '' );

            if( ! file_name.length )
                return;

            if( lbl.is( ":visible" ) ){
                lbl.text( file_name );
                btn.text( "Выбрать" );
            }else
                btn.text( file_name );
        }).change();
    });
    
    $(".file_upload_3").click(function(){
        var wrapper = $( ".file_upload_3" ),
            inp = wrapper.find( ".input_3" ),
            btn = wrapper.find( ".button_3" ),
            lbl = wrapper.find( ".div_3" );

        btn.focus(function(){
            inp.focus()
        });
        // Crutches for the :focus style:
        inp.focus(function(){
            wrapper.addClass( "focus" );
        }).blur(function(){
            wrapper.removeClass( "focus" );
        });

        var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

        inp.change(function(){
            var file_name;
            if( file_api && inp[ 0 ].files[ 0 ] ) 
                file_name = inp[ 0 ].files[ 0 ].name;
            else
                file_name = inp.val().replace( "C:\\fakepath\\", '' );

            if( ! file_name.length )
                return;

            if( lbl.is( ":visible" ) ){
                lbl.text( file_name );
                btn.text( "Выбрать" );
            }else
                btn.text( file_name );
        }).change();
    });

    $(".file_upload_4").click(function(){
        var wrapper = $( ".file_upload_4" ),
            inp = wrapper.find( ".input_4" ),
            btn = wrapper.find( ".button_4" ),
            lbl = wrapper.find( ".div_4" );

        btn.focus(function(){
            inp.focus()
        });
        // Crutches for the :focus style:
        inp.focus(function(){
            wrapper.addClass( "focus" );
        }).blur(function(){
            wrapper.removeClass( "focus" );
        });

        var file_api = ( window.File && window.FileReader && window.FileList && window.Blob ) ? true : false;

        inp.change(function(){
            var file_name;
            if( file_api && inp[ 0 ].files[ 0 ] ) 
                file_name = inp[ 0 ].files[ 0 ].name;
            else
                file_name = inp.val().replace( "C:\\fakepath\\", '' );

            if( ! file_name.length )
                return;

            if( lbl.is( ":visible" ) ){
                lbl.text( file_name );
                btn.text( "Выбрать" );
            }else
                btn.text( file_name );
        }).change();
    });

    jQuery(".order, .order-red, .btn").fancybox({
        'scrolling' : 'no',
        'titleShow' : false,
        'onClosed'  : function() {
            jQuery(".order").hide();
        }
    });

    jQuery('.fancy').fancybox();

    $(".bx-slider").bxSlider({
        'auto' : true,
        'pager' : false,
        'controls' : false
    });

    $("input[type='number']").stepper();

    $(".select").selecter();

    $(".toggle_mnu").click(function() {
        $(".sandwich").toggleClass("active");
    });

    $(".toggle_mnu").on('click', function() {
        if ($(".main_menu").is(":visible")) {
            $(".main_menu").fadeOut(600);
            $(".main_menu li a").removeClass("fadeInUp animated");
        } else {
            $(".main_menu").fadeIn(600);
            $(".main_menu li a").addClass("fadeInUp animated");
        };
    });

    $(".main_menu ul a").mPageScroll2id();

    $("#add_comm_1").click(function(){
        var link = $(this);
        var list = $(this).parents(".application").find(".wrap-comment_1");
        console.log(link);
        console.log(list);
        if(list.hasClass('open')) {
            $(".wrap-comment_1").css('display', 'none');
            $(".wrap-comment_1").removeClass('open');
        } else {
            $(".wrap-comment_1").css('display', 'block');
            $(".wrap-comment_1").addClass('open');
        }
        return false;
    });
    $("#add_comm_2").click(function(){
        var link = $(this);
        var list = $(this).parents(".application").find(".wrap-comment_2");
        console.log(link);
        console.log(list);
        if(list.hasClass('open')) {
            $(".wrap-comment_2").css('display', 'none');
            $(".wrap-comment_2").removeClass('open');
        } else {
            $(".wrap-comment_2").css('display', 'block');
            $(".wrap-comment_2").addClass('open');
        }
        return false;
    });
    $("#add_comm_3").click(function(){
        var link = $(this);
        var list = $(this).parents(".application").find(".wrap-comment_3");
        console.log(link);
        console.log(list);
        if(list.hasClass('open')) {
            $(".wrap-comment_3").css('display', 'none');
            $(".wrap-comment_3").removeClass('open');
        } else {
            $(".wrap-comment_3").css('display', 'block');
            $(".wrap-comment_3").addClass('open');
        }
        return false;
    });

    var height = 100;
    if (height === undefined)
        height = 100;
    $(window).scroll(function () {
        if ($(this).scrollTop() > height) {
            $('a.order-red').fadeIn();
        }
        else {
            $('a.order-red').fadeOut(400);
        }
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
            $('a.order-red').fadeOut(400);
        }
    });

    var variant = 1;
    var variantText = ['стандартного', 'профессионального', 'экспертного']

    $(".ch-item").on('click', function(){
        var v=parseInt($(this).attr('data-id'));
        $(".ch-item").removeClass('active');
        $(this).addClass('active');
        variant = v;
        $("#variant").text(variantText[variant]);
        $("#transvariant").val(variantText[variant]);
        $("#kalkulator").css('background-image', 'url(acss/calkbg'+variant+'.jpg)');
        goCalk();
    });

    function goCalk(){
        var b=$("#transfrom option:selected"),
        c=$("#transto option:selected"),
        d=parseInt($("#pages").val()),
        e=$("#kalk p .price_name"), a=0, z="Русский";
        z!=b.val()&&(a=parseInt(b.attr("data-price").split("|")[variant]));
        z!=c.val()&&(a+=parseInt(c.attr("data-price").split("|")[variant])); 
        $("#verstka").is(":checked")&&(a+=70); a*=d;
        $("#notarial").is(":checked")&&(a+=800);
        c.val()==b.val()&&(a=0); e.val(a);
    };

    $("#calk select, #calk input").on('change', function(){goCalk();});
    if($("#transfrom").length){
        goCalk();
    }

    $("#calk").submit(function() { return false; });

    $("#send").on("click", function(){
        var fistName  = jQuery("#fistName").val();
        var phoneval  = jQuery("#phone").val();
        var emailval  = jQuery("#email").val();

        if(fistName == '') {
            jQuery("#fistName").addClass("error");
        } else {
            jQuery("#fistName").removeClass("error");
        }

        if(phoneval == '') {
            jQuery("#phone").addClass("error");
        } else {
            jQuery("#phone").removeClass("error");
        }

        if(emailval == '') {
            jQuery("#email").addClass("error");
        } else {
            jQuery("#email").removeClass("error");
        }
        
        if(phoneval != '' && fistName != '' && emailval != '') {

            jQuery("#send").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");

            var form = document.forms.calk;

            var formData = new FormData(form);  

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/#wpcf7-f91-p20-o1");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        data = xhr.responseText;
                        if(data == "true") {
                            $(".sending").replaceWith("<p>Принято!<p>");
                        } else {
                            $(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
                        }
                    }
                }
            };
            
            xhr.send(formData);

        }
    });

    $("#feedback").submit(function() { return false; });

    $("#send2").on("click", function(){
        var fistName  = jQuery("#fistName2").val();
        var phoneval  = jQuery("#phone2").val();
        var emailval  = jQuery("#email2").val();

        if(fistName == '') {
            jQuery("#fistName2").addClass("error");
        } else {
            jQuery("#fistName2").removeClass("error");
        }

        if(phoneval == '') {
            jQuery("#phone2").addClass("error");
        } else {
            jQuery("#phone2").removeClass("error");
        }

        if(emailval == '') {
            jQuery("#email2").addClass("error");
        } else {
            jQuery("#email2").removeClass("error");
        }
        
        if(phoneval != '' && fistName != '' && emailval != '') {

            jQuery("#send2").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");

            var form = document.forms.feedback;

            var formData = new FormData(form);  

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/#wpcf7-f4-p20-o1");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        data = xhr.responseText;
                        if(data == "true") {
                            $(".sending").replaceWith("<p>Принято!<p>");
                        } else {
                            $(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
                        }
                    }
                }
            };
            
            xhr.send(formData);

        }
    });
    
    $("#feedback2").submit(function() { return false; });

    $("#send3").on("click", function(){
        var fistName  = jQuery("#fistName3").val();
        var phoneval  = jQuery("#phone3").val();
        var emailval  = jQuery("#email3").val();

        if(fistName == '') {
            jQuery("#fistName3").addClass("error");
        } else {
            jQuery("#fistName3").removeClass("error");
        }

        if(phoneval == '') {
            jQuery("#phone3").addClass("error");
        } else {
            jQuery("#phone3").removeClass("error");
        }

        if(emailval == '') {
            jQuery("#email3").addClass("error");
        } else {
            jQuery("#email3").removeClass("error");
        }
        
        if(phoneval != '' && fistName != '' && emailval != '') {

            jQuery("#send3").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");

            var form = document.forms.feedback2;

            var formData = new FormData(form);  

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/#wpcf7-f74-p20-o1");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        data = xhr.responseText;
                        if(data == "true") {
                            $(".sending").replaceWith("<p>Принято!<p>");
                        } else {
                            $(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
                        }
                    }
                }
            };
            
            xhr.send(formData);

        }
    });

    $("#reg").submit(function() { return false; });

    $("#reg_submit").on("click", function(){
        var fio  = jQuery("#fio").val();
        var date  = jQuery("#date").val();
        var email_reg  = jQuery("#email_reg").val();
        var mob_reg  = jQuery("#mob_reg").val();
        var name_institution  = jQuery("#name_institution").val();
        var faculty  = jQuery("#faculty").val();
        var specialization  = jQuery("#specialization").val();
        var receipt_date  = jQuery("#receipt_date").val();
        var expiration_date  = jQuery("#expiration_date").val();
        var kopi  = jQuery("#kopi").val();
        var lang_native  = jQuery("#lang_native").val();
        var language_pair  = jQuery("#language_pair").val();

        if(fio == '') {
            jQuery("#fio").addClass("error");
        } else {
            jQuery("#fio").removeClass("error");
        }

        if(date == '') {
            jQuery("#date").addClass("error");
        } else {
            jQuery("#date").removeClass("error");
        }

        if(email_reg == '') {
            jQuery("#email_reg").addClass("error");
        } else {
            jQuery("#email_reg").removeClass("error");
        }
        if(mob_reg == '') {
            jQuery("#mob_reg").addClass("error");
        } else {
            jQuery("#mob_reg").removeClass("error");
        }
        if(name_institution == '') {
            jQuery("#name_institution").addClass("error");
        } else {
            jQuery("#name_institution").removeClass("error");
        }
        if(faculty == '') {
            jQuery("#faculty").addClass("error");
        } else {
            jQuery("#faculty").removeClass("error");
        }
        if(specialization == '') {
            jQuery("#specialization").addClass("error");
        } else {
            jQuery("#specialization").removeClass("error");
        }
        if(receipt_date == '') {
            jQuery("#receipt_date").addClass("error");
        } else {
            jQuery("#receipt_date").removeClass("error");
        }
        if(expiration_date == '') {
            jQuery("#expiration_date").addClass("error");
        } else {
            jQuery("#expiration_date").removeClass("error");
        }
        if(kopi == '') {
            jQuery("#kopi").addClass("error");
        } else {
            jQuery("#kopi").removeClass("error");
        }
        if(lang_native == '') {
            jQuery("#lang_native").addClass("error");
        } else {
            jQuery("#lang_native").removeClass("error");
        }
        if(language_pair == '') {
            jQuery("#language_pair").addClass("error");
        } else {
            jQuery("#language_pair").removeClass("error");
        }
        
        if(fio != '' && date != '' && email_reg != '' && mob_reg != '' && name_institution != '' && faculty != '' && specialization != '' && receipt_date != '' && expiration_date != '' && kopi != '' && lang_native != '' && language_pair != '') {

            jQuery("#reg_submit").replaceWith("<p class='ok'><strong>Спасибо за регистрацию! Мы обязательно рассмотрим Вашу кандидатуру. В случае положительного решения, мы свяжемся с Вами.</strong></p>");

            var form = document.forms.reg;

            var formData = new FormData(form);  

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/registratsiya/#wpcf7-f80-p78-o1");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if(xhr.status == 200) {
                        data = xhr.responseText;
                        if(data == "true") {
                            $(".sending").replaceWith("<p>Принято!<p>");
                        } else {
                            $(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
                        }
                    }
                }
            };
            
            xhr.send(formData);

        }
    });

    $('#conditions').click(function() {
        if($(this).is(':checked')) {
            $('#reg_submit').removeAttr("disabled");
            $('#reg_submit').removeClass('disable');
        } else {
            $('#reg_submit').attr("disabled","disabled");
            $('#reg_submit').addClass('disable');
        }
    });
});