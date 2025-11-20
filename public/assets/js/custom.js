/* JS Document */

/******************************

[Table of Contents]

1. Vars and Inits
2. Set Header
3. Init Menu
4. Init Home Slider
5. Init Date Picker
6. Init Select
7. Init Milestones


******************************/

$(document).ready(function()
{
	"use strict";

	/* 

	1. Vars and Inits

	*/

	var header = $('.header');
	var ctrl = new ScrollMagic.Controller();

	setHeader();

	$(window).on('resize', function()
	{
		setHeader();

		setTimeout(function()
		{
			$(window).trigger('resize.px.parallax');
		}, 375);
	});

	$(document).on('scroll', function()
	{
		setHeader();
	});

	initMenu();
	initDropdown();
	initMobileMenuDropdown();
	initHomeSlider();
	initDatePicker();
	initSelect();
	initMilestones();

	/* 

	2. Set Header

	*/

	function setHeader()
	{
		if($(window).scrollTop() > 91)
		{
			header.addClass('scrolled');
		}
		else
		{
			header.removeClass('scrolled');
		}
	}

	/* 

	3. Init Menu

	*/

	function initMenu()
	{
		var hamb = $('.hamburger');
		var menu = $('.menu');
		var menuOverlay = $('.menu_overlay');
		var menuClose = $('.menu_close_container');

		hamb.on('click', function()
		{
			menu.toggleClass('active');
			menuOverlay.toggleClass('active');
		});

		menuOverlay.on('click', function()
		{
			menuOverlay.toggleClass('active');
			menu.toggleClass('active');
		});

		menuClose.on('click', function()
		{
			menuOverlay.toggleClass('active');
			menu.toggleClass('active');
		});
	}

	/* 

	4. Init Dropdown Menu

	*/

	function initDropdown()
	{
		var dropdown = $('.main_nav .dropdown');
		
		if(dropdown.length)
		{
			// Dropdown linkine tıklandığında
			dropdown.find('> a').on('click', function(e)
			{
				e.preventDefault();
				var $parent = $(this).parent('.dropdown');
				$parent.toggleClass('active');
				
				// Diğer dropdown menüleri kapat
				dropdown.not($parent).removeClass('active');
			});
			
			// Dışarı tıklandığında dropdown'u kapat
			$(document).on('click', function(e)
			{
				if(!$(e.target).closest('.dropdown').length)
				{
					dropdown.removeClass('active');
				}
			});
		}
	}

	/* 

	4.1. Init Mobile Menu Dropdown

	*/

	function initMobileMenuDropdown()
	{
		var menuDropdown = $('.menu_nav .menu-dropdown');
		
		if(menuDropdown.length)
		{
			// Mobile menüdeki dropdown toggle'a tıklandığında
			menuDropdown.find('.menu-dropdown-toggle').on('click', function(e)
			{
				e.preventDefault();
				var $parent = $(this).closest('.menu-dropdown');
				var $menu = $parent.find('.menu-dropdown-menu');
				var $chevron = $(this).find('.menu-chevron');
				
				// Aç/kapa
				$parent.toggleClass('active');
				$menu.slideToggle(300);
				
				// Chevron'u döndür
				if($parent.hasClass('active'))
				{
					$chevron.css('transform', 'rotate(180deg)');
				}
				else
				{
					$chevron.css('transform', 'rotate(0deg)');
				}
				
				// Diğer dropdown menüleri kapat
				menuDropdown.not($parent).removeClass('active').find('.menu-dropdown-menu').slideUp(300);
				menuDropdown.not($parent).find('.menu-chevron').css('transform', 'rotate(0deg)');
			});
		}
	}

	/* 

	5. Init Home Slider

	*/

	function initHomeSlider()
	{
		if($('.home_slider').length)
		{
			var homeSlider = $('.home_slider');
			homeSlider.owlCarousel(
			{
				items:1,
				autoplay:true,
				loop:true,
				nav:false,
				smartSpeed:1200,
				mouseDrag:false,
				dotsContainer:'home_slider_custom_dots'
			});

			/* Custom dots events */
			if($('.home_slider_custom_dot').length)
			{
				$('.home_slider_custom_dot').on('click', function()
				{
					$('.home_slider_custom_dot').removeClass('active');
					$(this).addClass('active');
					homeSlider.trigger('to.owl.carousel', [$(this).index(), 300]);
				});
			}

			/* Change active class for dots when slide changes by nav or touch */
			homeSlider.on('changed.owl.carousel', function(event)
			{
				$('.home_slider_custom_dot').removeClass('active');
				$('.home_slider_custom_dots li').eq(event.page.index).addClass('active');
			});
		}
	}

	/* 

	6. Init Date Picker

	*/

	function initDatePicker()
	{
		var dp = $('#datepicker');
		dp.datepicker();
	}

	/* 

	7. Init Select

	*/

	function initSelect()
	{
		if($('.intro_select').length)
		{
			var select = $('.intro_select');
			select.each(function()
			{
				var selected = $(this);
				selected.change(function()
				{
					selected.addClass('selected');
				});
			});
		}
	}

	/* 

	8. Init Milestones

	*/

	function initMilestones()
	{
		if($('.milestone_counter').length)
		{
			var milestoneItems = $('.milestone_counter');

	    	milestoneItems.each(function(i)
	    	{
	    		var ele = $(this);
	    		var endValue = ele.data('end-value');
	    		var eleValue = ele.text();

	    		/* Use data-sign-before and data-sign-after to add signs
	    		infront or behind the counter number */
	    		var signBefore = "";
	    		var signAfter = "";

	    		if(ele.attr('data-sign-before'))
	    		{
	    			signBefore = ele.attr('data-sign-before');
	    		}

	    		if(ele.attr('data-sign-after'))
	    		{
	    			signAfter = ele.attr('data-sign-after');
	    		}

	    		var milestoneScene = new ScrollMagic.Scene({
		    		triggerElement: this,
		    		triggerHook: 'onEnter',
		    		reverse:false
		    	})
		    	.on('start', function()
		    	{
		    		var counter = {value:eleValue};
		    		var counterTween = TweenMax.to(counter, 4,
		    		{
		    			value: endValue,
		    			roundProps:"value", 
						ease: Circ.easeOut, 
						onUpdate:function()
						{
							document.getElementsByClassName('milestone_counter')[i].innerHTML = signBefore + counter.value + signAfter;
						}
		    		});
		    	})
			    .addTo(ctrl);
	    	});
		}
	}

});