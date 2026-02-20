<?php

header( 'Access-Control-Allow-Origin: *' );

$received = json_decode( file_get_contents( 'php://input' ), true );


// Create the main folder
if ( mkdir( $received[ 'folderName' ] ) === false )
{
	echo "Can't create the main folder.";
	exit();
}

// Make the main file
if ( file_put_contents( $received[ 'folderName' ] . '/' . $received[ 'fileName' ], $received[ 'content' ] ) === false )
{
	echo "Can't create the main file.";
	exit();
}


// Create CSS file
if ( $received[ 'CSSFile' ] !== false )
{
	$piecesCSS = explode( '/', $received[ 'CSSFile' ] );

	$folderCSS = $piecesCSS[ 0 ];
	for ( $i = 0; $i < count( $piecesCSS ) - 1; $i++ )
	{
		if ( mkdir( $received[ 'folderName' ] . '/' . $folderCSS ) === false )
		{
			echo "Can't create the sub folder for CSS file.";
			exit();
		}
		$folderCSS = $folderCSS . '/' . $piecesCSS[ $i + 1 ];
	}

	if ( file_put_contents( $received[ 'folderName' ] . '/' . $folderCSS, '' ) === false )
	{
		echo "Can't create the CSS file.";
		exit();
	}
}


// Create the JavaScript file
if ( $received[ 'JSFile' ] !== false )
{
	$piecesJS = explode( '/', $received[ 'JSFile' ] );

	$folderJS = $piecesJS[ 0 ];
	for ( $j = 0; $j < count( $piecesJS ) - 1; $j++ )
	{
		// Make the folder only if it doesn't exist
		if ( !file_exists( $received[ 'folderName' ] . '/' . $folderJS ) )
		{
			if ( mkdir( $received[ 'folderName' ] . '/' . $folderJS ) === false )
			{
				echo "Can't create the sub folder for JavaScript file.";
				exit();
			}
		}
		$folderJS = $folderJS . '/' . $piecesJS[ $j + 1 ];
	}

	if ( file_put_contents( $received[ 'folderName' ] . '/' . $folderJS, '' ) === false )
	{
		echo "Can't create the JavaScript file.";
		exit();
	}
}

// Create git repository
if ( $received[ 'gitRepo' ] === true )
{
	$output = $retval = null;
	exec( 'cd ' . $received[ 'folderName' ] . ' && git init', $output, $retval );
	echo "Returned with status $retval and output:\n";
	print_r( $output );
}
