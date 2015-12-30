$(function(){
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
		e=$("#kalk p .price_name"), a=0, z="Русский",
		r=$("#price");

		z!=b.val()&&(a=parseInt(b.attr("data-price").split("|")[variant]));
		z!=c.val()&&(a+=parseInt(c.attr("data-price").split("|")[variant])); 
		$("#verstka").is(":checked")&&(a+=70); a*=d;
		$("#notarial").is(":checked")&&(a+=800);
		c.val()==b.val()&&(a=0); e.val(a); r.val(a);
	};

	$("#calk select, #calk input").on('change', function(){
		goCalk();
	});
	$("#transfrom").on('change', function(){
		if($("#transfrom").val() != 'Русский') {
			$("#transto").find("option:contains('Русский')").attr("selected", "selected");
			$("#transto").parents(".selecter").find(".selecter-selected").html("Русский");
		}
	});
	$("#transto").on('change', function(){
		if($("#transto").val() != 'Русский') {
			$("#transfrom").find("option:contains('Русский')").attr("selected", "selected");
			$("#transfrom").parents(".selecter").find(".selecter-selected").html("Русский");
		}
	});
	if($("#transfrom").length){
		goCalk();
	}

	// $("#calk").submit(function() { return false; });

	// $("#to_send").on("click", function(){
	// 	var fistName   = jQuery("#fistName").val();
	// 	var phoneval   = jQuery("#phone").val();
	// 	var emailval   = jQuery("#email").val();
	// 	var price_calk = jQuery(".price_name").val();

	// 	if(fistName == '') {
	// 		jQuery("#fistName").addClass("error");
	// 	} else {
	// 		jQuery("#fistName").removeClass("error");
	// 	}

	// 	if(phoneval == '') {
	// 		jQuery("#phone").addClass("error");
	// 	} else {
	// 		jQuery("#phone").removeClass("error");
	// 	}

	// 	if(emailval == '') {
	// 		jQuery("#email").addClass("error");
	// 	} else {
	// 		jQuery("#email").removeClass("error");
	// 	}
		
	// 	if(phoneval != '' && fistName != '' && emailval != '') {

	// 		jQuery("#to_send").replaceWith("<p class='ok'><strong>Успешно! Ваше сообщение отправлено  :)</strong></p>");

	// 		var form = document.forms.calk;

	// 		var formData = new FormData(form);  

	// 		var xhr = new XMLHttpRequest();
	// 		xhr.open("POST", "/");

	// 		xhr.onreadystatechange = function() {
	// 			if (xhr.readyState == 4) {
	// 				if(xhr.status == 200) {
	// 					data = xhr.responseText;
	// 					if(data == "true") {
	// 						$(".sending").replaceWith("<p>Принято!<p>");
	// 					} else {
	// 						$(".sending").replaceWith("<p >Ошибка! Обновите страницу...<p>");
	// 					}
	// 				}
	// 			}
	// 		};
	// 		xhr.send(formData);
	// 	}
	// });
});