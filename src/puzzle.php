<?php
namespace Synchronium\Puzzle;

	include __DIR__ . DIRECTORY_SEPARATOR . "../vendor/autoload.php";


	// Registry object for registering app-wide stuff
	// (gets passed to controllers)
	$registry = new Registry();

	// Location of instructions file
	$registry->instructionsFile = __DIR__ . '/instructions.txt';

	// run the app!
	$puzzle = new Application( $registry, 'Puzzle/Index' );

?>
