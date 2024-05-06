(function ( $ ) {
	'use strict';

	if ( typeof qiTemplatesAdmin !== 'object' ) {
		window.qiTemplatesAdmin = {};
	}

	$( document ).ready(
		function () {
			qodefRegistration.init();
		}
	);

	let qodefRegistration = {
		init: function () {
			this.formHolder    = $( '.qodef-admin-registration-page' );

			if ( this.formHolder.length ) {
				this.saveForm( this.formHolder );
			}
		},
		saveForm: function ( $adminPage ) {
			this.registrationForm = $adminPage.find( '#qi_templates_registration_framework_ajax_form' );

			let buttonPressed,
				$messageLoader = $( '.qodef-waiting-message' ),
				$responseField = $( '.qodef-registration-message' );

			if ( this.registrationForm.length ) {

				this.registrationForm.on(
					'submit',
					function ( e ) {
						e.preventDefault();
						e.stopPropagation();
						$messageLoader.addClass( 'qodef-show-loader' );
						$adminPage.addClass( 'qodef-btn-disable' );
						$responseField.text('');

						let form          = $( this ),
							ajaxData      = {
								action: $( this ).data( 'action-name' )
						};

						$.ajax(
							{
								type: 'POST',
								url: ajaxurl,
								cache: ! 1,
								data: $.param(
									ajaxData,
									! 0
								) + '&' + form.serialize(),
							success: function ( data ){
								let response = JSON.parse( data );

								$messageLoader.removeClass( 'qodef-show-loader' );
								if ( response.status === 'success' ) {
									location.reload();
								} else {
									$responseField.text( response.message );
								}
							}
							}
						);
					}
				);
			}
		}
	};

	window.qiTemplatesAdmin.qodefRegistration = qodefRegistration;

})( jQuery );
