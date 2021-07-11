<?php
function create_block_custom_next_page_block_init() {
	$dir = __DIR__;

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "create-block/newsletter-button" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'create-block-custom-next-page-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);

	wp_localize_script(
		'create-block-custom-next-page-block-editor',
		'image_data',
		array(
			'customNextPageImage' => plugins_url( 'includes/tinymce/plugins/customnextpage/img/custom-next-page.png', __FILE__ )
		)
	);

	$style_css = 'build/index.css';
	wp_register_style(
		'create-block-custom-next-page-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	wp_set_script_translations( 'create-block-custom-next-page-block-editor', 'custom-next-page' );

	register_block_type( 'create-block/custom-next-page', [
		'editor_script'     => 'create-block-custom-next-page-block-editor',
		'editor_style'      => 'create-block-custom-next-page-block-editor',
		'style'             => 'create-block-custom-next-page-block',
		'render_callback'   => 'custom_next_page_render',
		'attributes'        => [
			'linkText'      => [
				'type'      => 'strong',
				'default'   => '',
			],
		],
	] );
}
add_action( 'init', 'create_block_custom_next_page_block_init' );
