<?php

	if ( ! defined( 'ABSPATH' ) ) {

		exit;

	}

	function get_cat_api() {

		$api = 'https://cataas.com/cat/says/';
		$tag = 'TEMPL == FISH';
		$cat = wp_remote_get( $api . $tag . '?font=Impact&fontSize=30&fontColor=%23fff&type=square&position=center&html=false' );

		if ( !is_wp_error( $cat ) ) {

			return base64_encode( wp_remote_retrieve_body( $cat ) );

		}
	}


	add_filter( 'query_vars' , fn( $qv ) => array_merge( $qv, [ 'cats' ] ) );
	add_filter( 'woocommerce_account_menu_items' , function( $tabs ) {

		$tabs[ 'cats' ] = __( 'Cats' , 'woocommerce' );
		return $tabs;

	} );


	add_action( 'init' , fn() => add_rewrite_endpoint( 'cats' , EP_ROOT | EP_PAGES ) );
	add_action( 'woocommerce_account_cats_endpoint' , fn() => echo '<img style="width:100%;" src="data:image/jpeg;base64,' . get_cat_api() . '"/><a href="./">Meow…</a>' );
