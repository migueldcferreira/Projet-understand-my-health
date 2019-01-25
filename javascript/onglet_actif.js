/*$( '#topheader .navbar-nav a' ).on( 'click', function () {
	$( '#topheader .navbar-nav' ).find( 'li.active' ).removeClass( 'active' );
	$( this ).parent( 'li' ).addClass( 'active' );
});*/

$(document).ready(function() {
	// get current URL path and assign 'active' class
	var path = window.location.pathname.substr(window.location.pathname.lastIndexOf('/') + 1);
	$('.nav > .nav-item > a[href="'+ path +'"]').parent('li').addClass('active');
})