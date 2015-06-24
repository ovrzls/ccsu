var j = jQuery.noConflict();

jQuery(document).ready(function() {
	j(".fancybox").fancybox();
	j(".fancybox-spec-height").fancybox({
		beforeLoad : function() {
			this.width  = parseInt(this.element.data('fancybox-width'));  
			this.height = parseInt(this.element.data('fancybox-height'));
		}
	});
});

j(function() {
	j(".main-nav-item")
		.click(function(e) {
			//e.preventDefault();
			var mainNavID = j(this).attr("id");
			var subNavID = j(this).find(".sub-nav-wrap").attr("id");
			j(this).siblings().removeClass('main-nav-item-hover');
			j("#"+mainNavID).toggleClass('main-nav-item-hover');
			j("#"+mainNavID).siblings().find(".sub-nav-wrap").hide();
			//j(this).siblings().removeClass('main-nav-item-hover');
			j("#"+subNavID)
				.slideToggle(250);
	});
	
	j(".sub-nav-wrap").mouseleave(function() {
		j(".sub-nav-wrap").slideUp(250);
		j(".main-nav-item-hover").removeClass("main-nav-item-hover");
		//alert('left');
	});

	//****************************************************************************************
	//		FAQ
	//		Accordian
	//****************************************************************************************

	j(".question").click(function(e) {
		e.preventDefault();
		j(this).next('div').slideToggle(250);
	});

	j(function() {
		j('a.scrollto').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
				var target = j(this.hash);
				target = target.length ? target : j('[name=' + this.hash.slice(1) +']');
				if (target.length) {
					j('html,body').animate({
						scrollTop: target.offset().top
					}, 1000);
					return false;
				}
			}
		});
	});
	j(".gallery-icon").find("a").addClass("fancybox").attr('rel', 'student-art');


	j('#myCarousel').carousel({
		interval: 6000
	});
	j('.caption-button').hover( function() {
		j('.carousel-caption').toggleClass('carousel-caption-hover');
	});
	// Grab your button (based on your posted html)
	j('.closeAlert').click(function( e ){
		//alert('clicked');
		 // Do not perform default action when button is clicked
		e.preventDefault();

		 /*If you just want the cookie for a session don't provide an expires
		 Set the path as root, so the cookie will be valid across the whole site */
		j.cookie('alert-box', 'closed', {
			expires : 1, path    : '/',  secure  : false
		});
	});


	// Grab your button (based on your posted html)
	j('.login').click(function( e ){
		j.removeCookie('url', { path: '/' });
		
		var rURL = window.location.href;
		 /*If you just want the cookie for a session don't provide an expires
		 Set the path as root, so the cookie will be valid across the whole site */
		j.cookie('url', rURL, { expires : 1,path    : '/',  secure  : false
		});
	});

	if( j.cookie('alert-box') === 'closed' ){
		j('#importantAnnouncement').hide();
	 }

	j(".fa-print").click(function(e){
		window.print();
	});

	 function validateEmail(email) { 
		var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return reg.test(email);
	}

	j(document).ready(function() {
		j("#contact").submit(function() { return false; });
		
		j("#sendfeedback").on("click", function(){
			var nameval  = j("#name").val();
			var emailval  = j("#email").val();
			var maillen    = emailval.length;
			var mailvalid = true;
			var msgval    = j("#msg").val();
			var myratingval  = j("#myrating").val();
			var msglen    = msgval.length;
			var humanval  = j("input[name=imhuman]:checked").val();

			if(maillen > 0) {
				mailvalid = validateEmail(emailval);
			}
			if(mailvalid == false) {
				j("#email").addClass("error");
			}
			else if(mailvalid == true){
				j("#email").removeClass("error");
			}
			
			if(msglen < 4) {
				j("#msg").addClass("error");
			}
			else if(msglen >= 4){
				j("#msg").removeClass("error");
			}
			
			if(mailvalid == true && humanval == 'false' && myratingval > 0) {
				// if both validate we attempt to send the e-mail
				// first we hide the submit btn so the user doesnt click twice
				j("#sendfeedback").replaceWith("<em>sending...</em>");
				
				j.ajax({
					type: 'POST',
					url: '/district-resources/php/sendfeedback.php',
					data: j("#contact").serialize(),
					success: function(data) {
						if(data == "true") {
							j("#contact").fadeOut("fast", function(){
								j(this).before("<p><strong>Success! Your feedback has been sent, thanks :)</strong></p>");
								setTimeout("j.fancybox.close()", 1000);
							});
						}
					}
				});
			}
		});
	});

	 j('.menu_head').click(function( e ){
	 	j(this).next('div').slideToggle(250);
	 	j(this).toggleClass('open');
	});
});