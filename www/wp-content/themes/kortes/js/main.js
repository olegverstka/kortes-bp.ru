$(function(){function e(){var e=$("#transfrom option:selected"),a=$("#transto option:selected"),n=parseInt($("#pages").val()),s=$("#kalk p .price_name"),o=0,t="Русский";t!=e.val()&&(o=parseInt(e.attr("data-price").split("|")[r])),t!=a.val()&&(o+=parseInt(a.attr("data-price").split("|")[r])),$("#verstka").is(":checked")&&(o+=70),o*=n,$("#notarial").is(":checked")&&(o+=800),a.val()==e.val()&&(o=0),s.val(o)}$(".file_upload_1").click(function(){var e=$(".file_upload_1"),a=e.find(".input_1"),r=e.find(".button_1"),n=e.find(".div_1");r.focus(function(){a.focus()}),a.focus(function(){e.addClass("focus")}).blur(function(){e.removeClass("focus")});var s=window.File&&window.FileReader&&window.FileList&&window.Blob?!0:!1;a.change(function(){var e;e=s&&a[0].files[0]?a[0].files[0].name:a.val().replace("C:\\fakepath\\",""),e.length&&(n.is(":visible")?(n.text(e),r.text("Выбрать")):r.text(e))}).change()}),$(".file_upload_2").click(function(){var e=$(".file_upload_2"),a=e.find(".input_2"),r=e.find(".button_2"),n=e.find(".div_2");r.focus(function(){a.focus()}),a.focus(function(){e.addClass("focus")}).blur(function(){e.removeClass("focus")});var s=window.File&&window.FileReader&&window.FileList&&window.Blob?!0:!1;a.change(function(){var e;e=s&&a[0].files[0]?a[0].files[0].name:a.val().replace("C:\\fakepath\\",""),e.length&&(n.is(":visible")?(n.text(e),r.text("Выбрать")):r.text(e))}).change()}),$(".file_upload_3").click(function(){var e=$(".file_upload_3"),a=e.find(".input_3"),r=e.find(".button_3"),n=e.find(".div_3");r.focus(function(){a.focus()}),a.focus(function(){e.addClass("focus")}).blur(function(){e.removeClass("focus")});var s=window.File&&window.FileReader&&window.FileList&&window.Blob?!0:!1;a.change(function(){var e;e=s&&a[0].files[0]?a[0].files[0].name:a.val().replace("C:\\fakepath\\",""),e.length&&(n.is(":visible")?(n.text(e),r.text("Выбрать")):r.text(e))}).change()}),$(".file_upload_4").click(function(){var e=$(".file_upload_4"),a=e.find(".input_4"),r=e.find(".button_4"),n=e.find(".div_4");r.focus(function(){a.focus()}),a.focus(function(){e.addClass("focus")}).blur(function(){e.removeClass("focus")});var s=window.File&&window.FileReader&&window.FileList&&window.Blob?!0:!1;a.change(function(){var e;e=s&&a[0].files[0]?a[0].files[0].name:a.val().replace("C:\\fakepath\\",""),e.length&&(n.is(":visible")?(n.text(e),r.text("Выбрать")):r.text(e))}).change()}),jQuery(".order, .order-red, .btn").fancybox({scrolling:"no",titleShow:!1,onClosed:function(){jQuery(".order").hide()}}),jQuery(".fancy").fancybox(),$(".bx-slider").bxSlider({auto:!0,pager:!1,controls:!1}),$("input[type='number']").stepper(),$(".select").selecter(),$(".toggle_mnu").click(function(){$(".sandwich").toggleClass("active")}),$(".toggle_mnu").on("click",function(){$(".main_menu").is(":visible")?($(".main_menu").fadeOut(600),$(".main_menu li a").removeClass("fadeInUp animated")):($(".main_menu").fadeIn(600),$(".main_menu li a").addClass("fadeInUp animated"))}),$(".main_menu ul a").mPageScroll2id(),$("#add_comm_1").click(function(){var e=$(this),a=$(this).parents(".application").find(".wrap-comment_1");return console.log(e),console.log(a),a.hasClass("open")?($(".wrap-comment_1").css("display","none"),$(".wrap-comment_1").removeClass("open")):($(".wrap-comment_1").css("display","block"),$(".wrap-comment_1").addClass("open")),!1}),$("#add_comm_2").click(function(){var e=$(this),a=$(this).parents(".application").find(".wrap-comment_2");return console.log(e),console.log(a),a.hasClass("open")?($(".wrap-comment_2").css("display","none"),$(".wrap-comment_2").removeClass("open")):($(".wrap-comment_2").css("display","block"),$(".wrap-comment_2").addClass("open")),!1}),$("#add_comm_3").click(function(){var e=$(this),a=$(this).parents(".application").find(".wrap-comment_3");return console.log(e),console.log(a),a.hasClass("open")?($(".wrap-comment_3").css("display","none"),$(".wrap-comment_3").removeClass("open")):($(".wrap-comment_3").css("display","block"),$(".wrap-comment_3").addClass("open")),!1});var a=100;void 0===a&&(a=100),$(window).scroll(function(){$(this).scrollTop()>a?$("a.order-red").fadeIn():$("a.order-red").fadeOut(400),$(window).scrollTop()+$(window).height()>$(document).height()-100&&$("a.order-red").fadeOut(400)});var r=1,n=["стандартного","профессионального","экспертного"];$(".ch-item").on("click",function(){var a=parseInt($(this).attr("data-id"));$(".ch-item").removeClass("active"),$(this).addClass("active"),r=a,$("#variant").text(n[r]),$("#transvariant").val(n[r]),$("#kalkulator").css("background-image","url(acss/calkbg"+r+".jpg)"),e()}),$("#calk select, #calk input").on("change",function(){e()}),$("#transfrom").length&&e(),$("#calk").submit(function(){return!1}),$("#send").on("click",function(){var e=jQuery("#fistName").val(),a=jQuery("#phone").val(),r=jQuery("#email").val();if(""==e?jQuery("#fistName").addClass("error"):jQuery("#fistName").removeClass("error"),""==a?jQuery("#phone").addClass("error"):jQuery("#phone").removeClass("error"),""==r?jQuery("#email").addClass("error"):jQuery("#email").removeClass("error"),""!=a&&""!=e&&""!=r){jQuery("#send").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");var n=document.forms.calk,s=new FormData(n),o=new XMLHttpRequest;o.open("POST","/#wpcf7-f91-p20-o1"),o.onreadystatechange=function(){4==o.readyState&&200==o.status&&(data=o.responseText,"true"==data?$(".sending").replaceWith("<p>Принято!<p>"):$(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>"))},o.send(s)}}),$("#feedback").submit(function(){return!1}),$("#send2").on("click",function(){var e=jQuery("#fistName2").val(),a=jQuery("#phone2").val(),r=jQuery("#email2").val();if(""==e?jQuery("#fistName2").addClass("error"):jQuery("#fistName2").removeClass("error"),""==a?jQuery("#phone2").addClass("error"):jQuery("#phone2").removeClass("error"),""==r?jQuery("#email2").addClass("error"):jQuery("#email2").removeClass("error"),""!=a&&""!=e&&""!=r){jQuery("#send2").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");var n=document.forms.feedback,s=new FormData(n),o=new XMLHttpRequest;o.open("POST","/#wpcf7-f4-p20-o1"),o.onreadystatechange=function(){4==o.readyState&&200==o.status&&(data=o.responseText,"true"==data?$(".sending").replaceWith("<p>Принято!<p>"):$(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>"))},o.send(s)}}),$("#feedback2").submit(function(){return!1}),$("#send3").on("click",function(){var e=jQuery("#fistName3").val(),a=jQuery("#phone3").val(),r=jQuery("#email3").val();if(""==e?jQuery("#fistName3").addClass("error"):jQuery("#fistName3").removeClass("error"),""==a?jQuery("#phone3").addClass("error"):jQuery("#phone3").removeClass("error"),""==r?jQuery("#email3").addClass("error"):jQuery("#email3").removeClass("error"),""!=a&&""!=e&&""!=r){jQuery("#send3").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");var n=document.forms.feedback2,s=new FormData(n),o=new XMLHttpRequest;o.open("POST","/#wpcf7-f74-p20-o1"),o.onreadystatechange=function(){4==o.readyState&&200==o.status&&(data=o.responseText,"true"==data?$(".sending").replaceWith("<p>Принято!<p>"):$(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>"))},o.send(s)}}),$("#reg").submit(function(){return!1}),$("#reg_submit").on("click",function(){var e=jQuery("#fio").val(),a=jQuery("#date").val(),r=jQuery("#email_reg").val(),n=jQuery("#mob_reg").val(),s=jQuery("#name_institution").val(),o=jQuery("#faculty").val(),t=jQuery("#specialization").val(),i=jQuery("#receipt_date").val(),l=jQuery("#expiration_date").val(),c=jQuery("#kopi").val(),d=jQuery("#lang_native").val(),u=jQuery("#language_pair").val();if(""==e?jQuery("#fio").addClass("error"):jQuery("#fio").removeClass("error"),""==a?jQuery("#date").addClass("error"):jQuery("#date").removeClass("error"),""==r?jQuery("#email_reg").addClass("error"):jQuery("#email_reg").removeClass("error"),""==n?jQuery("#mob_reg").addClass("error"):jQuery("#mob_reg").removeClass("error"),""==s?jQuery("#name_institution").addClass("error"):jQuery("#name_institution").removeClass("error"),""==o?jQuery("#faculty").addClass("error"):jQuery("#faculty").removeClass("error"),""==t?jQuery("#specialization").addClass("error"):jQuery("#specialization").removeClass("error"),""==i?jQuery("#receipt_date").addClass("error"):jQuery("#receipt_date").removeClass("error"),""==l?jQuery("#expiration_date").addClass("error"):jQuery("#expiration_date").removeClass("error"),""==c?jQuery("#kopi").addClass("error"):jQuery("#kopi").removeClass("error"),""==d?jQuery("#lang_native").addClass("error"):jQuery("#lang_native").removeClass("error"),""==u?jQuery("#language_pair").addClass("error"):jQuery("#language_pair").removeClass("error"),""!=e&&""!=a&&""!=r&&""!=n&&""!=s&&""!=o&&""!=t&&""!=i&&""!=l&&""!=c&&""!=d&&""!=u){jQuery("#reg_submit").replaceWith("<p class='ok'><strong>Спасибо за регистрацию! Мы обязательно рассмотрим Вашу кандидатуру. В случае положительного решения, мы свяжемся с Вами.</strong></p>");var p=document.forms.reg,f=new FormData(p),m=new XMLHttpRequest;m.open("POST","/registratsiya/#wpcf7-f80-p78-o1"),m.onreadystatechange=function(){4==m.readyState&&200==m.status&&(data=m.responseText,"true"==data?$(".sending").replaceWith("<p>Принято!<p>"):$(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>"))},m.send(f)}}),$("#conditions").click(function(){$(this).is(":checked")?($("#reg_submit").removeAttr("disabled"),$("#reg_submit").removeClass("disable")):($("#reg_submit").attr("disabled","disabled"),$("#reg_submit").addClass("disable"))})});