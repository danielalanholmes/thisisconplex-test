(function ( $ ) {
	'use strict';

	if ( typeof qiTemplatesAdmin !== 'object' ) {
		window.qiTemplatesAdmin = {};
	}

	qiTemplatesAdmin.scroll       = 0;
	qiTemplatesAdmin.windowWidth  = $( window ).width();
	qiTemplatesAdmin.windowHeight = $( window ).height();

	$( document ).ready(
		function () {
			qodefAdminOptionsPanel.init();
		}
	);

	$( window ).scroll(
		function () {
			qiTemplatesAdmin.scroll = $( window ).scrollTop();
		}
	);

	$( window ).resize(
		function () {
			qiTemplatesAdmin.windowWidth  = $( window ).width();
			qiTemplatesAdmin.windowHeight = $( window ).height();

			if ( qiTemplatesAdmin.windowWidth > 600 &&
				typeof qiTemplatesAdmin.qodefAdminOptionsPanel.adminPage !== 'undefined' &&
				qiTemplatesAdmin.qodefAdminOptionsPanel.adminPage.length &&
				qiTemplatesAdmin.qodefAdminOptionsPanel.adminHeader.length ) {
				qiTemplatesAdmin.qodefAdminOptionsPanel.adminHeader.width( qiTemplatesAdmin.qodefAdminOptionsPanel.adminPage.width() );
			}
		}
	);

	let qodefAdminOptionsPanel = {
		init: function () {
			this.adminPage = $( '.qodef-admin-page' );
			this.adminHeaderPosition();
		},
		adminHeaderPosition: function () {
			if ( this.adminPage.length && qiTemplatesAdmin.windowWidth > 600 ) {
				this.adminBarHeight         = $( '#wpadminbar' ).height();
				this.adminHeader            = $( '.qodef-admin-header' );
				this.adminHeaderHeight      = this.adminHeader.outerHeight( true );
				this.adminHeaderTopPosition = this.adminHeader.offset().top - parseInt( this.adminBarHeight );
				this.adminContent           = $( '.qodef-admin-content' );

				this.adminHeader.width( this.adminPage.width() );

				$( window ).on(
					'scroll load',
					function () {
						if ( qiTemplatesAdmin.scroll >= qodefAdminOptionsPanel.adminHeaderTopPosition ) {
							qodefAdminOptionsPanel.adminHeader.addClass( 'qodef-fixed' ).css(
								'top',
								parseInt( qodefAdminOptionsPanel.adminBarHeight )
							);
							qodefAdminOptionsPanel.adminContent.css(
								'marginTop',
								qodefAdminOptionsPanel.adminHeaderHeight
							);
						} else {
							qodefAdminOptionsPanel.adminHeader.removeClass( 'qodef-fixed' ).css(
								'top',
								0
							);
							qodefAdminOptionsPanel.adminContent.css(
								'marginTop',
								0
							);
						}
					}
				);
			}
		},
	};

	qiTemplatesAdmin.qodefAdminOptionsPanel = qodefAdminOptionsPanel;

})( jQuery );

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

(function ( $ ) {
	'use strict';

	if ( typeof qiTemplatesAdmin !== 'object' ) {
		window.qiTemplatesAdmin = {};
	}

	$( document ).ready(
		function () {
			qodefDemos.init();
			qodefLazyImages.init();
			qodefImport.init();
			qodefInitSingleDemo.init();
			qodefInitSingleDemo.closeDemo();
			qodefInstallPlugin.init();
			qodefSwiper.init();
			qodefEnableImportSubmitButton.init();
			qodefReloadDemos.init();
		}
	);

	$( window ).scroll(
		function () {
			qiTemplatesAdmin.scroll = $( window ).scrollTop();
			qodefLazyImages.init();
		}
	);

	let qodefDemos = {
		qsRegex: '',
		init: function () {
			let $demosList = $( '.qodef-import-masonry-list' );

			if ( $demosList.length ) {
				$demosList.each(
					function () {
						let $thisDemoList       = $( this ),
							$masonry            = $thisDemoList.find( '.qodef-grid-inner' ),
							$masonryItemSizeGap = parseInt( $masonry.css( 'column-gap' ) ),
							$quickSearch;

						let $masonryIsotope = $masonry.isotope(
							{
								layoutMode: 'packery',
								itemSelector: '.qodef-masonry-item',
								percentPosition: true,
								packery: {
									columnWidth: '.qodef-import-masonry-grid-sizer',
									gutter: $masonryItemSizeGap,
								}
							}
						);

						$demosList.addClass( 'qodef--initialized' );

						$masonryIsotope.on(
							'layoutComplete',
							function () {
								qodefLazyImages.init();
							}
						);

						qodefDemos.updateCountFiltered( $thisDemoList.find( '.qodef-grid-inner' ) );

						$quickSearch = $( '.qodef-filter-holder-top .quicksearch' );

						qodefDemos.initFilter(
							$thisDemoList,
							$quickSearch
						);

						qodefDemos.searchItems(
							$thisDemoList,
							$quickSearch
						);

					}
				);
			}
		},
		initFilter: function ( $thisDemoList, $quickSearch ) {
			$( '.qodef-filter-item' ).click(
				function ( event, isActiveFilter ) {
					let $thisFilter            = $( this ),
						$filterItems,
						$filterActiveItems,
						filterActiveItemsValue = '';

					//reset value in quick search input
					$quickSearch.val( '' );
					$( '.qodef-im-no-results' ).remove();

					$thisFilter.parent().find( '.qodef-filter-item' ).removeClass( 'qodef--active' );
					if ( ! isActiveFilter ) {
						$thisFilter.addClass( 'qodef--active' );
					}

					$( 'html, body' ).animate(
						{ scrollTop: 0 },
						400,
						'swing'
					).promise().then(
						function () {
							// Called when the animation in total is complete, since callback is called twice, both for body and html
							let $masonry = $thisDemoList.find( '.qodef-grid-inner' );

							$filterItems       = $( '.qodef-filter-item' );
							$filterActiveItems = $filterItems.filter( '.qodef--active' );

							$filterActiveItems.each(
								function () {
									filterActiveItemsValue += $( this ).data( 'filter' );
								}
							);

							$masonry.isotope( { filter: filterActiveItemsValue } ).promise().then( function() {
								setTimeout( function () {
									$( document.body ).trigger( 'qi-templates-import-list-filtered' );
								}, 750 );
							} );

							qodefDemos.updateCountFiltered( $thisDemoList.find( '.qodef-grid-inner' ) );
						}
					);
				}
			);
		},
		updateCountFiltered: function ( $holder ) {
			let count = $holder.data( 'isotope' ).filteredItems.length,
				text  = 'demos.';

			if ( count <= 1 ) {
				text = 'demo.';
			}

			//if there is no demos, write a message
			$( '.qodef-im-no-results' ).remove();
			if ( count === 0 ) {
				$( '<p class="qodef-im-no-results">Sorry, no results found matching querying parameters.</p>' ).insertBefore( $holder );
			}

			//show count of demos found
			$holder.parent().find( '.qodef-filter-number-of-results' ).html( 'Choose from <span>' + count + ' ' + text + '</span>' );

		},
		searchItems: function ( $thisDemoList, $quickSearch ) {
			let demoPredictions      = qiTemplatesAdmin.vars.searchPredictions.demo_names,
				patternPredictions   = qiTemplatesAdmin.vars.searchPredictions.pattern_names,
				templatePredictions  = qiTemplatesAdmin.vars.searchPredictions.template_names,
				wireframePredictions = qiTemplatesAdmin.vars.searchPredictions.wireframe_names,
				activeFilterType     = $( '.qodef-im-import-type-filter' ),
				importType           = activeFilterType.filter( '.qodef--active' ).data( 'import-type' ),
				searchPredictions;

			switch (importType) {
				case 'patterns':
					searchPredictions = patternPredictions;
					break;
				case 'templates':
					searchPredictions = templatePredictions;
					break;
				case 'wireframes':
					searchPredictions = wireframePredictions;
					break;
				default:
					searchPredictions = demoPredictions;
			}

			// this has to be before 'keyup events' since autocomplete is preventing them
			$quickSearch.easyAutocomplete(
				{
					data: searchPredictions,
					list: {
						maxNumberOfElements: 10,
						match: {
							enabled: true
						},
						onChooseEvent: function () {
							qodefDemos.searchFilter(
								$thisDemoList,
								$quickSearch
							);
						},
						onShowListEvent: function () {
							$quickSearch.addClass( 'qodef-show-list' );
						},
						onHideListEvent: function () {
							$quickSearch.removeClass( 'qodef-show-list' );
						}

					}
				}
			);

			// use value of search field to filter
			$quickSearch.keyup(
				this.debounce(
					function () {
						qodefDemos.searchFilter(
							$thisDemoList,
							$quickSearch
						);
					},
					500
				)
			);

		},
		debounce: function ( fn, threshold ) {
			let timeout;
			return function debounced() {
				if ( timeout ) {
					clearTimeout( timeout );
				}

				function delayed() {
					fn();
					timeout = null;
				}

				timeout = setTimeout(
					delayed,
					threshold || 100
				);
			};
		},
		searchFilter: function ( $thisDemoList, $quickSearch ) {
			let qsValue = $quickSearch.val();

			//escape eventual '+' symbol in name since it has different meaning in regex
			qsValue = qsValue.replace( '+', '\\+' );

			//remove active filter classes
			$thisDemoList.find( '.qodef-filter-item' ).removeClass( 'qodef--active' );

			qodefDemos.qsRegex = new RegExp(
				qsValue,
				'gi'
			);

			$thisDemoList.find( '.qodef-grid-inner' ).isotope(
				{
					filter: function () {
						return qodefDemos.qsRegex ? $( this ).text().match( qodefDemos.qsRegex ) : true;
					}
				}
			);
			qodefDemos.updateCountFiltered(
				$thisDemoList.find( '.qodef-grid-inner' )
			);
		}
	};

	window.qiTemplatesAdmin.qodefDemos = qodefDemos;

	let qodefLazyImages = {
		init: function () {

			$( '.qodef-lazy-load img:not(.qodef-lazy-loading)' ).each(
				function ( i, object ) {

					object = $( object );

					let rect = object[0].getBoundingClientRect(),
						vh   = (qiTemplatesAdmin.windowHeight || document.documentElement.clientHeight),
						vw   = (qiTemplatesAdmin.windowWidth || document.documentElement.clientWidth),
						oh   = object.outerHeight(),
						ow   = object.outerWidth();

					if (
						(rect.top != 0 || rect.right != 0 || rect.bottom != 0 || rect.left != 0) &&
						(rect.top >= 0 || rect.top + oh >= 0) &&
						(rect.bottom >= 0 && rect.bottom - oh - vh <= 500) &&
						(rect.left >= 0 || rect.left + ow >= 0) &&
						(rect.right >= 0 && rect.right - ow - vw <= 0)
					) {
						object.addClass( 'qodef-lazy-loading' );

						let imageObj = new Image();

						$( imageObj ).on(
							'load',
							function () {
								let $this = $( this );
								object.attr(
									'src',
									$this.attr( 'src' )
								);
								object
								.removeAttr( 'data-image' )
								.removeData( 'image' )
								.removeClass( 'qodef-lazy-loading' );
								object.parent().removeClass( 'qodef-lazy-load' );
							}
						).attr(
							'src',
							object.data( 'image' )
						);
					}
				}
			);
		}
	};

	window.qiTemplatesAdmin.qodefLazyImages = qodefLazyImages;

	let qodefSwiper = {
		init: function () {

			if ( typeof Swiper !== 'undefined' ) {
				var $mainSwiper = new Swiper(
					'.qodef-swiper-container',
					{
						slidesPerView: 1,
						effect: 'fade',
						fadeEffect: {
							crossFade: true
						},
						loop: true,
						autoHeight: true,
						navigation: {
							nextEl: '.swiper-button-next',
							prevEl: '.swiper-button-prev',
						},
						on: {
							slideChange: function () {
								//$mainSwiper is not defined if loop is true, because 'slideChange' is called on int
								//$mainSwiper.slides.length - 2, 2 is here because there are duplicates due to loop: true and slidesPreview: 1
								if ( typeof $mainSwiper !== 'undefined' ) {
									$( '.qodef-swiper-container .swiper-counter span' ).html( ($mainSwiper.realIndex + 1) + '/' + ($mainSwiper.slides.length - 2) );
								}
							},
						},
					}
				);
			}
		}
	};

	window.qiTemplatesAdmin.qodefSwiper = qodefSwiper;

	let qodefInitSingleDemo = {
		mainURL: '',
		singleHolder: '',
		contentHolder: '',
		init: function () {
			let $container              = $( '.qodef-import-masonry-list' ),
				$demoImportLinks        = $container.find( '.qodef-import-demo-link' ),
				nonceHolder             = $container.find( '#qi_templates_demo_import_nonce' );

			qodefInitSingleDemo.mainURL       = qodefInitSingleDemo.clearURL( window.location.href );
			qodefInitSingleDemo.singleHolder  = $( '.qodef-demo-single' );
			qodefInitSingleDemo.contentHolder = $( '.qodef-admin-demos-content ' );

			$demoImportLinks.on(
				'click',
				function ( e ) {
					e.preventDefault();
					let $demo = $( this ),
						$demoID;

					if ( typeof $demo.data( 'demo-id' ) !== 'undefined' && $demo.data( 'demo-id' ) !== '' ) {
						$demoID = $demo.data( 'demo-id' );
					}

					$.ajax(
						{
							type: 'POST',
							url: ajaxurl,
							data: {
								action: 'qi_templates_open_demo_single',
								demoId: $demoID,
								nonce: nonceHolder.val()
							},
							success: function ( data ) {
								let response = JSON.parse( data );
								qodefInitSingleDemo.openDemo(
									response.data,
									$demoID
								);

								let adminHeaderHeight = $( '.qodef-admin-header.qodef-fixed' ).length ? $( '.qodef-admin-header.qodef-fixed' ).outerHeight() : 0;
								$( window ).scrollTop( $( '.qodef-admin-page' ).offset().top - adminHeaderHeight - $( '#wpadminbar' ).outerHeight() );
								qodefInitSingleDemo.closeDemo();
								qodefImport.init();
								qodefInstallPlugin.init();
								qodefSwiper.init();
								qodefEnableImportSubmitButton.init();
							},
							error: function ( data ) {
								// let response = JSON.parse(data);
								// qodefImport.ajaxError(response, options);
							}
						}
					);
				}
			);
		},
		changeURL: function ( $url ) {
			history.pushState(
				'',
				'',
				$url
			);
		},
		addParamsToURL: function ( $params ) {
			let $query             = { 'demo-id': $params },
				$currentUrl        = qodefInitSingleDemo.mainURL,
				$urlParamSeparator = (window.location.href.indexOf( '?' ) === -1) ? '?' : '&',
				$newUrl            = $currentUrl + $urlParamSeparator + decodeURIComponent( $.param( $query ) );
			qodefInitSingleDemo.changeURL( $newUrl );
		},
		removeParamsFromURL: function () {

			let $url = window.location.href,
				$cleanURL = qodefInitSingleDemo.clearURL( $url );

			qodefInitSingleDemo.changeURL( $cleanURL );

		},
		clearURL: function ( $url ) {

			let $parameter = 'demo-id',
				$urlParts = $url.split( '?' );

			if ( $urlParts.length >= 2 ) {

				let $prefix = encodeURIComponent( $parameter ) + '=',
					$pars   = $urlParts[1].split( /[&;]/g );

				//reverse iteration as may be destructive
				for ( let i = $pars.length; i-- > 0; ) {
					//idiom for string.startsWith
					if ( $pars[i].lastIndexOf(
						$prefix,
						0
					) !== -1 ) {
						$pars.splice(
							i,
							1
						);
					}
				}
				return $urlParts[0] + ($pars.length > 0 ? '?' + $pars.join( '&' ) : '');
			}

			return $url;

		},
		openDemo: function ( data, $demoID ) {
			qodefInitSingleDemo.contentHolder.addClass( 'qodef-demo-import-single-opened' );
			qodefInitSingleDemo.singleHolder.html( data );
			qodefInitSingleDemo.addParamsToURL( $demoID );
		},
		closeDemo: function ( data ) {

			let $closeButton = $( '.qodef-return-to-demo-list' );

			if ( $closeButton.length ) {
				$closeButton.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefInitSingleDemo.contentHolder.removeClass( 'qodef-demo-import-single-opened' );
						qodefInitSingleDemo.singleHolder.html();
						qodefInitSingleDemo.removeParamsFromURL();
						qodefDemos.init();
					}
				);
			}

		}
	};

	window.qiTemplatesAdmin.qodefInitSingleDemo = qodefInitSingleDemo;

	let qodefInstallPlugin = {
		init: function () {
			$( '.qodef-required-plugins-holder' ).on(
				'click',
				'.qodef-install-plugin-link',
				function ( e ) {
					e.preventDefault();
					let $link              = $( this ),
						$allLinks          = $link.parents( '.qodef-required-plugins-holder' ).find( '.qodef-install-plugin-link' ),
						$pluginAction      = 'install',
						$pluginActionLabel = '',
						$pluginSlug        = '',
						nonceHolder        = $( '#qi_templates_install_plugins_nonce' );

					$allLinks.addClass( 'qodef-disabled' );
					$link.removeClass( 'qodef-disabled' );
					$link.next( '.qodef-plugin-installing-spinner' ).addClass( 'active' );

					if ( typeof $link.data( 'plugin-action' ) !== 'undefined' && $link.data( 'plugin-action' ) !== '' ) {
						$pluginAction = $link.data( 'plugin-action' );
					}

					if ( typeof $link.data( 'plugin-action-label' ) !== 'undefined' && $link.data( 'plugin-action-label' ) !== '' ) {
						$pluginActionLabel = $link.data( 'plugin-action-label' );
					}

					if ( typeof $link.data( 'plugin-slug' ) !== 'undefined' && $link.data( 'plugin-slug' ) !== '' ) {
						$pluginSlug = $link.data( 'plugin-slug' );
					}

					$link.text( $pluginActionLabel );

					$.ajax(
						{
							type: 'POST',
							url: ajaxurl,
							data: {
								action: 'qi_templates_install_plugin',
								pluginAction: $pluginAction,
								pluginSlug: $pluginSlug,
								nonce: nonceHolder.val()
							},
							success: function ( data ) {
								let $response = JSON.parse( data );

								if ( $pluginAction === 'install' ) {
									if ( $response.status === 'success' ) {
										$link.next( '.qodef-plugin-installing-spinner' ).removeClass( 'active' );
										$link.text( $response.message );
										$link.data(
											'plugin-action',
											'activate'
										);
										$link.data(
											'plugin-action-label',
											$response.data.action_label
										);
									}
								} else {
									if ( $response.status === 'success' ) {
										$link.next( '.qodef-plugin-installing-spinner' ).removeClass( 'active' );
										$link.addClass( 'qodef-disabled' );
										$link.text( $response.message );
										$link.attr(
											'data-plugin-action',
											'activated'
										);
									}
								}

								$allLinks.removeClass( 'qodef-disabled' );
								qodefEnableImportSubmitButton.init();
							},
							error: function () {

							}
						}
					);
					return false;
				}
			);
		}
	};

	window.qiTemplatesAdmin.qodefInstallPlugin = qodefInstallPlugin;

	let qodefEnableImportSubmitButton = {
		init: function () {
			let qodefImportBtn          = $( '#qodef-import-demo-data' ),
				essentialPluginsHolders = $( '.qodef-essential-plugin' ),
				buttonEnabled           = true;

			if ( essentialPluginsHolders.length ) {
				essentialPluginsHolders.each( function () {
					let thisEssentialPluginsHolder = $( this ),
						essentialPluginInstallLink = thisEssentialPluginsHolder.find( '.qodef-install-plugin-link' );

					if ( essentialPluginInstallLink.attr( 'data-plugin-action' ) !== 'activated' ) {
						buttonEnabled = false;
						return;
					}
				} );
			}

			if ( buttonEnabled ) {
				qodefImportBtn.removeClass( 'qodef-disabled' );
				$( document.body ).trigger(
					'qi-templates-import-all-essential-plugins-activated'
				);
			}
		}
	};

	window.qiTemplatesAdmin.qodefEnableImportSubmitButton = qodefEnableImportSubmitButton;

	let qodefImport = {
		importDemo: '',
		importAction: 'complete',
		importImages: 0,
		attachmentBlocks: 0,
		attachmentCounter: 0,
		totalPercent: 0,
		numberOfAdditionalFiles: 2,
		numberOfRequests: 1,
		nextStep: '',
		stepPercent: 0,
		init: function () {
			qodefImport.holder = $( '.qodef-import-form' );

			if ( qodefImport.holder.length ) {
				qodefImport.holder.each(
					function () {
						let qodefImportBtn    = $( '#qodef-import-demo-data' ),
							importDemoElement = $( '.qodef-import-form .qodef-import-demo' ),
							confirmMessage    = qodefImport.holder.data( 'confirm-message' );

						qodefImportBtn.on(
							'click',
							function ( e ) {
								e.preventDefault();
								qodefImport.reset();
								qodefImport.importImages = $( '.qodef-import-attachments' ).is( ':checked' ) ? 1 : 0;
								qodefImport.importDemo   = importDemoElement.val();

								if ( confirm( confirmMessage ) ) {
									$( '.qodef-form-section-progress' ).show();
									$( this ).addClass( 'qodef-import-demo-data-disabled' );
									$( this ).attr(
										'disabled',
										true
									);
									qodefImport.initImportType();
								}
							}
						);
					}
				);
			}
		},

		initImportType: function () {
			qodefImport.nextStep = 'terms';
			qodefImport.importAll();
		},

		importAll: function () {
			switch (qodefImport.nextStep) {
				case 'options':
					qodefImport.importOptions();
					break;
				case 'settings-pages':
					qodefImport.importSettingsPages();
					break;
				default:
					qodefImport.importContent();
			}
		},

		countStep: function () {
			qodefImport.stepPercent = (100 / qodefImport.numberOfRequests);

		},

		setNumberOfRequests: function () {
			/**
			 * 1 - for posts, terms is not included because number is set after terms imported
			 */
			qodefImport.numberOfRequests += 1 + qodefImport.attachmentBlocks;
			if ( 'complete' === qodefImport.importAction ) {
				qodefImport.numberOfRequests += qodefImport.holder.data( 'other-files' );
			}
			qodefImport.countStep();
		},

		importOptions: function () {
			let data = {
				action: 'options',
				demo: qodefImport.importDemo
			};
			qodefImport.importAjax( data );
		},

		importSettingsPages: function () {
			let data = {
				action: 'settings-page',
				demo: qodefImport.importDemo
			};
			qodefImport.importAjax( data );
		},

		importContent: function () {
			if ( 'terms' === qodefImport.nextStep ) {
				qodefImport.importTerms();
			}
			if ( 'attachments' === qodefImport.nextStep ) {
				qodefImport.importAttachments();
			}
			if ( 'posts' === qodefImport.nextStep ) {
				qodefImport.importPosts();
			}
		},

		importTerms: function () {
			let data = {
				action: 'content',
				contentType: 'terms'
			};

			qodefImport.importAjax( data );

		},

		importPosts: function () {
			let data = {
				action: 'content',
				contentType: 'posts'
			};
			qodefImport.importAjax( data );
		},

		importAttachments: function () {
			for ( let i = 1; i <= qodefImport.attachmentBlocks; i++ ) {
				let data = {
					action: 'content',
					contentType: 'attachments',
					attachmentNumber: i,
					images: qodefImport.importImages
				};
				qodefImport.importAjax( data );
			}
		},

		importAjax: function ( options ) {
			let defaults = {
				demo: qodefImport.importDemo,
				nonce: $( '#qi_templates_import_nonce' ).val()
			};
			$.extend(
				defaults,
				options
			);

			$.ajax(
				{
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'qi_templates_import_action',
						options: defaults
					},
					success: function ( data ) {
						let response = JSON.parse( data );
						qodefImport.ajaxSuccess(
							response,
							options
						);
					},
					error: function ( data ) {
						let response = JSON.parse( data );
						qodefImport.ajaxError(
							response,
							options
						);
					}
				}
			);
		},

		importProgress: function () {
			qodefImport.totalPercent += qodefImport.stepPercent;

			if ( 100 < qodefImport.totalPercent ) {
				qodefImport.totalPercent = 100;
			}

			$( '#qodef-progress-bar' ).val( Math.round( qodefImport.totalPercent ) );
			$( '.qodef-progress-percent' ).html( Math.round( qodefImport.totalPercent ) + '%' );

			if ( 100 === Math.round( qodefImport.totalPercent ) ) {
				$( '#qodef-import-demo-data' ).remove( '.qodef-import-demo-data-disabled' );
				$( '.qodef-import-is-completed' ).show();
			}
		},

		ajaxSuccess: function ( response, options ) {
			if ( typeof response.status !== 'undefined' && response.status == 'success' ) {
				if ( options.action === 'content' ) {

					switch (options.contentType) {
						case 'terms':
							qodefImport.proccedTermsResponse( response );
							break;
						case 'attachments':
							qodefImport.proccedAttachmentsResponse( response );
							break;
						case 'posts':
							qodefImport.proccedPostsResponse( response );
							break;
					}
				} else if ( 'complete' === qodefImport.importAction ) {

					switch (options.action) {
						case 'options':
							qodefImport.nextStep = 'settings-pages';
							qodefImport.importAll();
							break;
						case 'settings-pages':
							qodefImport.nextStep = '';
							break;
					}

				}

				qodefImport.importProgress();
			} else {
				qodefImport.holder.find( '#qodef-import-demo-data' ).remove( '.qodef-import-demo-data-disabled' );
				qodefImport.holder.find( '.qodef-import-went-wrong' ).show();
			}
		},

		ajaxError: function ( response, options ) {
			console.log( 'error' );
			console.log( response );
		},

		proccedTermsResponse: function ( response ) {
			if ( typeof response.data.number_of_blocks !== 'undefined' ) {
				qodefImport.attachmentBlocks = response.data.number_of_blocks;
				qodefImport.nextStep         = 'attachments';

				qodefImport.setNumberOfRequests();
			}
			qodefImport.importContent();
		},

		proccedAttachmentsResponse: function ( response ) {
			if ( typeof response.data.attachment_block !== 'undefined' ) {
				qodefImport.attachmentCounter++;
			}

			if ( qodefImport.attachmentCounter === qodefImport.attachmentBlocks ) {
				qodefImport.nextStep = 'posts';
				qodefImport.importContent();
			}
		},

		proccedPostsResponse: function ( response ) {
			if ( 'complete' === qodefImport.importAction ) {
				qodefImport.nextStep = 'options';
				qodefImport.importAll();
			}

		},

		reset: function () {
			qodefImport.totalPercent = 0;
			$( '#qodef-progress-bar' ).val( 0 );
		}
	};

	window.qiTemplatesAdmin.qodefImport = qodefImport;


	let qodefReloadDemos = {
		init: function () {
			qodefReloadDemos.holder = $( '.qodef-import-demos' );

			if ( qodefReloadDemos.holder.length ) {
				qodefReloadDemos.holder.each(
					function () {
						let thisHolder = $(this),
							trigger = thisHolder.find( '.qodef-import-top-reload-button' ),
							nonceHolder = thisHolder.find( '#qi_templates_reload_demo_import' ),
							listHolder = thisHolder.find( '.qodef-import-masonry-list-holder' );

						if( trigger.length && nonceHolder.length ) {
							trigger.on( 'click', function(e) {
								e.preventDefault();

								$.ajax(
									{
										type: 'POST',
										url: ajaxurl,
										data: {
											action: 'qi_templates_reload_demo_import',
											nonce: nonceHolder.val()
										},
										success: function ( data ) {
											let response = JSON.parse( data );

											if( 'success' === response.status ) {
												listHolder.html( response.data );
												qodefDemos.init();
												qodefLazyImages.init();
												qodefImport.init();
												qodefInitSingleDemo.init();
												qodefInitSingleDemo.closeDemo();
											}
										},
										error: function ( data ) {
											// let response = JSON.parse(data);
											// qodefImport.ajaxError(response, options);
										}
									}
								);
							} )
						}
					} )
			}
		}
	};

	window.qiTemplatesAdmin.qodefReloadDemos = qodefReloadDemos;

})( jQuery );

(function ( $, window, wp ) {

	if ( typeof qiTemplatesAdmin !== 'object' ) {
		window.qiTemplatesAdmin = {};
	}

	$( document ).ready( function () {
		qodefImportPanel.init();
	} );

	let qodefImportPanel = {
		shouldReloadPage: false,
		init: function () {
			this.holder = $( '#qi-templates-import-modal' );

			if ( this.holder.length ) {
				qodefImportPanel.initImportButton();
				qodefImportPanel.reloadImportData();
				qodefImportPanel.initListTabs();
			}
		},
		initImportButton: function () {
			if ( typeof wp === 'object' && typeof wp.data === 'object' ) {
				wp.data.subscribe( function () {
					let editor             = $( '#editor' ),
						importButtonScript = $( '#qodef-import-modal-button-trigger' );

					if ( ! editor.length || ! importButtonScript.length ) {
						return;
					}

					let editorToolbar      = editor.find( '.edit-post-header-toolbar' ),
						importButtonHtml   = importButtonScript.html(),
						importButtonHolder = $( '#qi-templates-import-button-holder' ),
						importModalInner   = qodefImportPanel.holder.find( '.qi-templates-import-modal-inner' ),
						importModalCloser  = qodefImportPanel.holder.find( '.qi-templates-import-modal-close' );


					if ( editorToolbar.length && ! importButtonHolder.length ) {
						editorToolbar.append( importButtonHtml );
					} else if ( importButtonHolder.length && ! importButtonHolder.hasClass( 'qi-templates-import-button-initialized' ) ) {
						let importButton = importButtonHolder.find( '#qi-templates-import-button' );

						if ( importButton.length ) {
							importButton.on(
								'click',
								function () {
									qodefImportPanel.openModal( qodefImportPanel.holder );
									qodefImportPanel.initializeImportList();
								}
							);
						}

						qodefImportPanel.holder.on(
							'click',
							function () {
								qodefImportPanel.closeModal( qodefImportPanel.holder );
							}
						);

						importModalCloser.on(
							'click',
							function () {
								qodefImportPanel.closeModal( qodefImportPanel.holder );
							}
						);

						importModalInner.on(
							'click',
							function ( e ) {
								e.stopPropagation();
							}
						);

						importButtonHolder.addClass( 'qi-templates-import-button-initialized' );
					}
				} );
			}
		},
		reloadImportData: function () {
			let reloadButton = qodefImportPanel.holder.find( '.qi-templates-import-modal-reload' );

			if ( reloadButton.length ) {
				reloadButton.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefImportPanel.showLoadingSpinner();
						qodefImportPanel.resetImportListCategoryAndSearchFilters();

						let importTypeFilter       = $( '.qodef-im-import-type-filter' ),
							activeImportTypeFilter = importTypeFilter.filter( '.qodef--active' ),
							importTypeValue        = 'patterns',
							nonceHolder            = qodefImportPanel.holder.find( '#qi_templates_reload_import_data_nonce' ),
							ajaxData               = {
								action: 'qi_templates_action_reload_import_data',
								nonce: nonceHolder.val()
							};

						if ( activeImportTypeFilter.length ) {
							importTypeValue = activeImportTypeFilter.data( 'import-type' );
						}

						$.ajax( {
							type: 'POST',
							url: ajaxurl,
							cache: ! 1,
							data: ajaxData,
							success: function ( data ) {
								let response = $.parseJSON( data );

								if ( response.status === 'success' ) {
									qodefImportPanel.initTabFilterList( importTypeValue );
									qodefImportPanel.initImportItem();
								}

								if ( response.status === 'fail' ) {
									qodefImportPanel.hideLoadingSpinner();
									alert( response.message );
								}
							}
						} );
					}
				);
			}
		},
		initListTabs: function () {
			let listHolder        = qodefImportPanel.holder.find( '.qi-templates-import-modal-content-list-inner' ),
				demosImportHolder = qodefImportPanel.holder.find( '.qi-templates-import-modal-demos-import' ),
				importTypeFilter  = qodefImportPanel.holder.find( '.qodef-im-import-type-filter' ),
				importTypeValue   = 'patterns';


			if ( importTypeFilter.length ) {
				importTypeFilter.on(
					'click',
					function ( e ) {
						e.preventDefault();

						if ( ! $( this ).hasClass( 'qodef--active' ) ) {
							importTypeFilter.filter( '.qodef--active' ).removeClass( 'qodef--active' );
							$( this ).addClass( 'qodef--active' );
							importTypeValue = $( this ).data( 'import-type' );
							qodefImportPanel.resetImportListCategoryAndSearchFilters();

							if ( $( this ).data( 'import-type' ) !== 'demos' ) {
								listHolder.fadeIn( 'fast' );
								demosImportHolder.fadeOut( 'fast' );
								qodefImportPanel.initTabFilterList( importTypeValue );
							} else {
								qodefImportPanel.showLoadingSpinner();
								listHolder.fadeOut( 'fast' );
								demosImportHolder.fadeIn(
									'fast',
									function () {
										qodefImportPanel.hideLoadingSpinner();
									}
								);
							}
						}
					}
				);
			}
		},
		initializeImportList: function () {
			let listInnerHolder = qodefImportPanel.holder.find( '.qi-templates-import-modal-content-list-inner' ),
				nonceHolder     = qodefImportPanel.holder.find( '#qi_templates_list_nonce' ),
				ajaxData        = {
					action: 'qi_templates_action_import_list',
					type: 'initialize',
					nonce: nonceHolder.val()
				};

			if ( ! qodefImportPanel.holder.hasClass( 'qodef-import-list-initialized' ) ) {
				qodefImportPanel.showLoadingSpinner();

				$.ajax( {
					type: 'POST',
					url: ajaxurl,
					cache: ! 1,
					data: ajaxData,
					success: function ( data ) {
						let response = $.parseJSON( data );

						if ( response.status === 'success' ) {
							listInnerHolder.html( response.data );
							qodefImportPanel.adjustLazyImages();
							setTimeout(
								function () {
									window.qiTemplatesAdmin.qodefDemos.init();
									qodefImportPanel.templateScrollingAnimation( qodefImportPanel.holder );
									qodefImportPanel.hideLoadingSpinner();
									qodefImportPanel.adjustLazyImages();
								},
								500
							);
							qodefImportPanel.initImportItem();
							qodefImportPanel.holder.addClass( 'qodef-import-list-initialized' );
						}

						if ( response.status === 'fail' ) {
							qodefImportPanel.hideLoadingSpinner();
							alert( response.message );
						}
					}
				} );
			}
		},
		initTabFilterList: function ( importTypeValue ) {
			let listHolder      = qodefImportPanel.holder.find( '.qi-templates-import-modal-content-list-holder' ),
				listInnerHolder = listHolder.find( '.qi-templates-import-modal-content-list-inner' ),
				nonceHolder     = qodefImportPanel.holder.find( '#qi_templates_list_nonce' ),
				ajaxData        = {
					action: 'qi_templates_action_import_list',
					type: 'filter',
					import_type: importTypeValue,
					nonce: nonceHolder.val()
				};

			qodefImportPanel.showLoadingSpinner();

			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				cache: ! 1,
				data: ajaxData,
				success: function ( data ) {
					let response = $.parseJSON( data );

					if ( response.status === 'success' ) {
						listInnerHolder.html( response.data );
						qodefImportPanel.adjustLazyImages();
						setTimeout(
							function () {
								window.qiTemplatesAdmin.qodefDemos.init();
								qodefImportPanel.templateScrollingAnimation( qodefImportPanel.holder );
								qodefImportPanel.hideLoadingSpinner();
								qodefImportPanel.adjustLazyImages();
							},
							500
						);
						qodefImportPanel.initImportItem();
					}

					if ( response.status === 'fail' ) {
						qodefImportPanel.hideLoadingSpinner();
						alert( response.message );
					}
				}
			} );
		},
		initImportItem: function () {
			let importButton = qodefImportPanel.holder.find( '.qi-templates-import-item-button' );

			if ( importButton.length ) {
				importButton.each( function () {
					let thisImportButton = $( this );

					thisImportButton.on(
						'click',
						function ( e ) {
							e.preventDefault();

							let importType   = $( this ).data( 'import-type' ),
								importItemId = $( this ).data( 'import-item-id' );

							qodefImportPanel.showLoadingSpinner();
							qodefImportPanel.importItem(
								importType,
								importItemId
							);
						}
					);
				} );
			}
		},
		importItem: function ( importType, importItemId ) {
			let noticeHolder  = qodefImportPanel.holder.find( '.qi-templates-import-modal-notice-holder' ),
				noticeContent = noticeHolder.find( '.qi-templates-import-modal-notice-content' ),
				noticeAdditionalInfo = noticeHolder.find( '.qi-templates-import-modal-notice-additional-info > p' ),
				nonceHolder   = qodefImportPanel.holder.find( '#qi_templates_item_nonce' ),
				ajaxData      = {
					action: 'qi_templates_action_import_item',
					import_type: importType,
					import_item_id: importItemId,
					nonce: nonceHolder.val(),
					post_type: 'post',
					post_id: ''
				};

			let searchParams = new URLSearchParams( window.location.search );

			if( searchParams.has( 'post_type' ) ) {
				ajaxData.post_type = searchParams.get( 'post_type' )
			}

			if( searchParams.has( 'post' ) ) {
				ajaxData.post_id = searchParams.get( 'post' )
			}

			$.ajax( {
				type: 'POST',
				url: ajaxurl,
				cache: ! 1,
				data: ajaxData,
				success: function ( data ) {
					let response = $.parseJSON( data );

					if ( response.status === 'success' ) {
						let responseData = response.data,
							content = responseData.content ? responseData.content : '',
							template = responseData.template ? responseData.template : '',
							append  = importType === 'patterns' || importType === 'wireframes';

						if ( typeof content === 'string' ) {
							qodefImportPanel.insertPostContentInEditor(
								content,
								append
							);
						}

						qodefImportPanel.setPageTemplate( template );
						qodefImportPanel.hideLoadingSpinner();
						qodefImportPanel.closeModal( qodefImportPanel.holder );

						if ( qodefImportPanel.shouldReloadPage ) {
							qodefImportPanel.updateAndReloadPage();
						}
					}

					if( response.status === 'warning' ) {
						let responseData = response.data,
							content 	 = responseData.content,
							additionalInfo = responseData.additional_info;

						if ( noticeHolder.length && noticeContent.length && noticeAdditionalInfo.length ) {
							noticeContent.html( content );
							noticeAdditionalInfo.html( additionalInfo );
							qodefImportPanel.openModal( noticeHolder );
							qodefImportPanel.closeNoticeFunctionality( noticeHolder );
						}
					}

					if ( response.status === 'install-plugins' ) {
						let responseData = response.data,
							content 	 = responseData.content,
							additionalInfo = responseData.additional_info;

						qodefImportPanel.shouldReloadPage = true;

						if ( noticeHolder.length && noticeContent.length && noticeAdditionalInfo.length ) {
							noticeContent.html( content );
							noticeAdditionalInfo.html( additionalInfo );
							qodefImportPanel.initPluginsNotice(
								noticeHolder,
								importType,
								importItemId
							);
						}
					}

					if ( response.status === 'fail' ) {
						qodefImportPanel.hideLoadingSpinner();
						alert( response.message );
					}
				}
			} );
		},
		initPluginsNotice: function ( noticeHolder, importType, importItemId ) {
			qodefImportPanel.openModal( noticeHolder );
			window.qiTemplatesAdmin.qodefInstallPlugin.init();
			qodefImportPanel.closeNoticeFunctionality( noticeHolder );

			$( document ).on(
				'qi-templates-import-all-essential-plugins-activated',
				function () {
					qodefImportPanel.importItem(
						importType,
						importItemId
					);
					qodefImportPanel.closeModal( noticeHolder );
				}
			);
		},
		adjustLazyImages: function() {
			window.qiTemplatesAdmin.qodefLazyImages.init();

			var scrollableHolder = qodefImportPanel.holder.find( '.qi-templates-import-modal-inner' );

			if( scrollableHolder.length ) {
				scrollableHolder.on( 'scroll', function() {
					qodefImportPanel.triggerLazyLoadAndMasonryLayout();
				} )
			}

			$( document ).on(
				'qi-templates-import-list-filtered',
				function () {
					qodefImportPanel.triggerLazyLoadAndMasonryLayout();
				}
			);
		},
		triggerLazyLoadAndMasonryLayout: function () {
			let masonry = qodefImportPanel.holder.find( '.qodef-grid-inner' );

			window.qiTemplatesAdmin.qodefLazyImages.init();

			if( masonry.length && 'function' === typeof masonry.isotope ) {
				masonry.isotope();
			}
		},
		templateScrollingAnimation: function ( $holder ) {
			var initAnimation = function ( $thisHolder ) {
				var $imageHolder    = $thisHolder.find( 'article.qi-templates-import-item-templates .qi-templates-import-item-image' ),
					$scrollingFrame = $thisHolder.find( 'article.qi-templates-import-item-templates .qi-templates-import-item-image > img' );

				//scroll animation on hover
				$imageHolder.on(
					'mouseenter',
					function () {
						var $scrollingImage = $(this).find( '.qi-templates-import-item-image-media img' );
						var state 			= qodefImportPanel.sizing( $scrollingImage, $scrollingFrame );

						$scrollingImage.css(
							{
								'transition-property': 'transform',
								'transition-duration': state.timing + 's',
								'transform': 'translate3d(0px, -' + state.delta + 'px, 0px)',
							}
						);
					}
				);

				//scroll animation reset
				$imageHolder.on(
					'mouseleave',
					function () {
						var $scrollingImage = $(this).find( '.qi-templates-import-item-image-media img' );
						var state 			= qodefImportPanel.sizing( $scrollingImage, $scrollingFrame );

						if ( state.scrollable ) {
							$scrollingImage.css(
								{
									'transition-property': 'transform',
									'transition-duration': Math.min( state.timing / 3, 3 ) + 's',
									'transform': 'translate3d(0px, 0px, 0px)',
								}
							);
						}
					}
				);
			};

			initAnimation( $holder );

			$( window ).resize( function () {
				initAnimation( $holder );
			} );
		},
		sizing: function( $scrollingImage, $scrollingFrame ) {
			var scrollingFrameHeight = $scrollingFrame.height(),
				scrollingImageHeight = $scrollingImage.height(),
				delta,
				timing,
				scrollable = false;

			delta = Math.round(scrollingImageHeight - scrollingFrameHeight);
			timing = Math.round(scrollingImageHeight / scrollingFrameHeight) * 1.7;

			if (scrollingImageHeight > scrollingFrameHeight) {
				scrollable = true;

			}

			return {
				delta: delta,
				timing: timing,
				scrollable: scrollable,
			}
		},
		openModal: function ( modal ) {
			! modal.hasClass( 'qodef--open' ) ? modal.addClass( 'qodef--open' ) : '';
		},
		closeModal: function ( modal ) {
			modal.hasClass( 'qodef--open' ) ? modal.removeClass( 'qodef--open' ) : '';
		},
		showLoadingSpinner: function () {
			let loadingSpinner = qodefImportPanel.holder.find( '.qi-templates-import-modal-spinner-holder' );

			qodefImportPanel.holder.addClass( 'qodef--loading' );
			loadingSpinner.addClass( 'qodef--visible' );
		},
		hideLoadingSpinner: function () {
			let loadingSpinner = qodefImportPanel.holder.find( '.qi-templates-import-modal-spinner-holder' );

			qodefImportPanel.holder.hasClass( 'qodef--loading' ) ? qodefImportPanel.holder.removeClass( 'qodef--loading' ) : '';
			loadingSpinner.hasClass( 'qodef--visible' ) ? loadingSpinner.removeClass( 'qodef--visible' ) : '';
		},
		resetImportListCategoryAndSearchFilters: function () {
			let searchInput        = qodefImportPanel.holder.find( '.qodef-im-search-input' ),
				allCategoryFilters = qodefImportPanel.holder.find( '.qodef-filter-item' );

			searchInput.length ? searchInput.val( '' ) : '';

			if ( allCategoryFilters.length ) {
				allCategoryFilters.filter( '.qodef--active' ).removeClass( 'qodef--active' );
				allCategoryFilters.first().addClass( 'qodef--active' );
			}
		},
		insertPostContentInEditor: function ( content, append = true ) {
			let currentContent = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'content' ),
				newContent     = append ? currentContent + content : content;

			if ( newContent ) {
				wp.data.dispatch( 'core/block-editor' ).resetBlocks( wp.blocks.parse( newContent ) );
				qodefImportPanel.closeModal( qodefImportPanel.holder );
			}
		},
		setPageTemplate: function ( template ) {
			let templateToSet = template ? template : 'wp-custom-template-qi-blocks-full-width';

			wp.data.dispatch( 'core/editor' ).editPost( { template: templateToSet } );
		},
		closeNoticeFunctionality: function ( noticeHolder ) {
			let closeButton = noticeHolder.find( '.qi-templates-import-modal-notice-close' );

			if ( closeButton.length ) {
				closeButton.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefImportPanel.closeModal( noticeHolder );
						qodefImportPanel.hideLoadingSpinner();
						$( document ).off( 'qi-templates-import-all-essential-plugins-activated' );
					}
				);
			}
		},
		updateAndReloadPage: function () {
			let isPostSaveable = wp.data.select( 'core/editor' ).isEditedPostSaveable();

			if ( isPostSaveable ) {
				wp.data.dispatch( 'core/editor' ).savePost().then(
					function () {
						location.reload();
					}
				);
			}
		}
	};

	window.qiTemplatesAdmin.qodefImportPanel = qodefImportPanel;

})(
	jQuery,
	window,
	wp
);
