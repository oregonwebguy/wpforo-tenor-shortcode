<?php
/////////////////////////////////////////////////////////////////////////////
// wpForo Tenor: Display legacy forum Tenor GIFs from wpForo via shortcode //
/////////////////////////////////////////////////////////////////////////////

add_filter( 'bbp_get_topic_content', 'wbcom_render_forum_gifs', 99, 2 );
add_filter( 'bbp_get_reply_content', 'wbcom_render_forum_gifs', 99, 2 );
function wbcom_render_forum_gifs( $content, $id ) {
	$lazy = false;
	return preg_replace_callback(
		'#\[wpftenor[^\[\]]+?\]#isu',
		function( $match ) use ( $lazy ) {
			$match[0] = stripslashes( $match[0] );
			$match[0] = str_replace( '&#8221;', '"', $match[0] );

			$tenorid     = preg_match( '#\stenorid=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '';
			$title       = preg_match( '#\stitle=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : 'GIF';
			$alt         = preg_match( '#\salt=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : 'GIF';
			$analsent    = preg_match( '#\sanalsent=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '';
			$src         = preg_match( '#\ssrc=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '';
			$srcwidth    = preg_match( '#\ssrcwidth=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '200';
			$srcheight   = preg_match( '#\ssrcheight=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '200';
			$still       = preg_match( '#\sstill=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '';
			$stillwidth  = preg_match( '#\sstillwidth=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '200';
			$stillheight = preg_match( '#\sstillheight=[\"\']([^\"\']+)[\"\']#isu', $match[0], $m ) ? $m[1] : '200';

			return sprintf(
				'<figure class="wpf-gif-figure" contenteditable="false" 
                        data-tenorid="%1$s"
                        data-analsent="%4$s">
                    <img class="%13$s" style="width: %6$dpx; height: %7$dpx; background-color: %11$s"
                         src="%12$s"
                         title="%2$s"
                         alt="%3$s"
                         data-src="%5$s"
                         data-srcwidth="%6$d"
                         data-srcheight="%7$d"
                         data-still="%8$s"
                         data-stillwidth="%9$d"
                         data-stillheight="%10$d"
                    >
                </figure>',
				esc_attr( $tenorid ),
				esc_attr( $title ),
				esc_attr( $alt ),
				esc_attr( $analsent ),
				esc_attr( $src ),
				esc_attr( $srcwidth ),
				esc_attr( $srcheight ),
				esc_attr( $still ),
				esc_attr( $stillwidth ),
				esc_attr( $stillheight ),
				generate_color( 2 ),
				( $lazy ? esc_attr( WPFOROTENOR_URL . '/assets/ico/transparent.png' ) : esc_attr( $src ) ),
				( $lazy ? 'wpf-gif-lazy' : 'wpf-gif-not-lazy' )
			);
		},
		$content
	);
}

function generate_color( $index = null ) {
	$colors = [
		"#399DEF",
		"#007ADD",
		"#9B9B9B",
		"#EFF6F9",
		"#3F3F3F",
		"#76B7EE",
		"#90B58C",
		"#9686B3",
	];

	return ( is_null( $index ) || intval( $index ) > 7 ) ? $colors[ rand( 0, 7 ) ] : $colors[ intval( $index ) ];
}

?>
