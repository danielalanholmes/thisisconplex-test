import $ from 'jquery';

document.addEventListener(
	'DOMContentLoaded',
	function () {
		qodefPluginRegistration.init();
	}
);

const qodefPluginRegistration = {
	init: function () {
		this.holder = document.querySelector( '.qodef-admin-registration-page' );

		if ( this.holder ) {
			this.saveForm( this.holder );
		}
	},
	saveForm: function ( $holder ) {
		const $form = $holder.querySelector( '.qodef-registration-form' );

		if ( $form ) {
			const $messageLoader = $holder.querySelector( '.qodef-waiting-message' ),
				$responseField   = $holder.querySelector( '.qodef-registration-message' );

			$form.addEventListener(
				'submit',
				( e ) => {
					e.preventDefault();
					e.stopPropagation();

					$holder.classList.add( 'qodef-btn-disable' );
					$messageLoader.classList.add( 'qodef-show-loader' );
					$responseField.innerText = '';

					const ajaxData = {
						action: $form.getAttribute( 'data-action' ),
					};

					$.ajax(
						{
							type: 'POST',
							url: ajaxurl,
							cache: ! 1,
							data: $.param(
								ajaxData,
								! 0
							) + '&' + $( $form ).serialize(),
							success: function ( data ){
								const response = JSON.parse( data );

								$messageLoader.classList.remove( 'qodef-show-loader' );

								if ( response.status === 'success' ) {
									location.reload();
								} else {
									$responseField.innerText = response.message;
								}
							}
						}
					);
				}
			);
		}
	},
};

export default qodefPluginRegistration;
