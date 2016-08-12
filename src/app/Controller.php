<?php
namespace Synchronium\Puzzle;

	Abstract Class Controller {

			protected $registry;

			function __construct( Registry $registry ) {

				$this->registry = $registry;

			}

			/**
			 * @all controllers must contain an index method
			 */
			abstract function index();

	}

?>
