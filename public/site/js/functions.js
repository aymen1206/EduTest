console.clear();

const navExpand = [].slice.call(document.querySelectorAll('.nav-expand'));
const backLink = `<li class="nav-item">
	<a class="nav-link nav-back-link" href="javascript:;">
		للخلف
	</a>
</li>`;

navExpand.forEach(item => {
  item.querySelector('.nav-expand-content').insertAdjacentHTML('afterbegin', backLink);
  item.querySelector('.nav-link').addEventListener('click', () => item.classList.add('active'));
  item.querySelector('.nav-back-link').addEventListener('click', () => item.classList.remove('active'));
});


// ---------------------------------------
// not-so-important stuff starts here

const ham = document.getElementById('ham');
ham.addEventListener('click', function () {
  document.body.classList.toggle('nav-is-toggled');
});


$(document).click(function(){
	$('ul.search-items').removeClass('show-search-items');
	$('.searcl-label i.down-arrow').removeClass('is-search-open');
});

$( document ).ready(function() {	
    
    $('ul.search-items li').click(function(e){
		e.stopPropagation();
		var getValue = $(this).data('value');
		var getText  = $(this).text();
		$('.search-value').attr('value',getValue);
		$('.search-placeholder').text(getText);
		$('ul.search-items li').removeClass('selected-search');
		$(this).addClass('selected-search');
		$('ul.search-items').removeClass('show-search-items');
		$('.searcl-label i.down-arrow').removeClass('is-search-open');		
	});
	
	$('.searcl-label').click(function(e){
		if ($('ul.search-items').hasClass('show-search-items')){
			$('ul.search-items').removeClass('show-search-items');
			$('.searcl-label i.down-arrow').removeClass('is-search-open');
		} else {
			$('ul.search-items').addClass('show-search-items');
			$('.searcl-label i.down-arrow').addClass('is-search-open');
		}
		e.stopPropagation();
	});
	
	$('.mob-menu-over').click(function(){
		  document.body.classList.toggle('nav-is-toggled');
	});

	$( function() {
    	$( ".datepicker" ).datepicker();
  	} );
  	
  	$('.owl-testimonial').owlCarousel({
        rtl:true,
		center: true,
		items:1,
		loop:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:1
	        },
	        1000:{
	            items:2
	        }
	    }
	});
	
	$('.owl-services').owlCarousel({
		rtl:true,
	    loop:true,
	    margin:50,
	    nav:true,
	    dots:false,
	    stagePadding:35,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:3
	        }
	    }
	});
	
	document.getElementById('idn1').addEventListener('input', function (e) {
		e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
	});
	
	document.getElementById('idn2').addEventListener('input', function (e) {
		e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
	});	
		  
});