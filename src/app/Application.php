<?php
namespace Synchronium\Puzzle;

	class Application
	{

		private $controller = 'index';
		private $action = 'index';
		private $namespace = 'Synchronium\Puzzle\\';

		public function __construct( Registry $registry, $route = null )
		{

			// This will set controller & action properties
			// perhaps not so useful for a CLI app?
			$this->_determineRoute( $route );

			// define required class and class file path from controller property
			$controller_class = $this->controller . 'Controller'; // eg. IndexController

			// check controller exists
			if ( class_exists( $controller_class ) ) {

				// load controller file
				// require $controller_class_file;

				// Create new instance of controller
				$controller = new $controller_class( $registry );

				// check if we can run the action for this controller
				if ( method_exists( $controller, $this->action ) ) {

					// All good! Let's run the requested action!
					$controller->{$this->action}();

				} else {

					// Action specified is not a valid action, so give up all hope
					// (or fire off a 404 error in the case of a web app)
					// (or possibly call the index() method present in every controller? )
					die( "Cannot run \"{$this->action}\" from $controller_class" );

				}

			} else {

				// Route requested doesn't exist, so give up all hope
				// (or fire off a 404 error in the case of a web app)
				die( "$controller_class does not exist." );

			}

		}

		private function _determineRoute( $route = null )
		{

			// This would normally pull info from the request URL
			// to determine which controlelr and action to use
			// as well as process any params/query string

			// instead, this will parse an optional route string
			// in the format "Controller/Action" or get the controller from
			// script filename

			if ( is_null( $route ) ) {

				// no route manually specified, so extract filename without extension
				// to use as the controller
				if ( preg_match( '/^(.*?)\.php$/', $_SERVER['PHP_SELF'], $match ) ) {
					$this->controller = $this->namespace . $match[1];
				}

			} else {

				// Split routing string
				$route = explode( '/', $route );

				// Set controller
				if ( isset( $route[0] ) )
				{
					$this->controller = $this->namespace . ucfirst( $route[0] );
				}

				// Set action
				if ( isset( $route[1] ) )
				{

					$this->action = $route[1];

				}

			}
		}

	}

?>
