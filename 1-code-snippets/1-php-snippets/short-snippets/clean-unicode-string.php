<?php

function clean( $str ) {
	return remove_slashes( sanitize_title_with_dashes( strtr(
		utf8_decode( $str ),
		utf8_decode( 'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),
		'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy'
	), 'save' ) );
}