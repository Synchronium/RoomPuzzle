<?php
namespace Synchronium\Puzzle;

	class Registry
	{

		private $_vars = array();

		public function __set( $key, $value )
		{
			$this->_vars[ $key ] = $value;
		}

		public function __get( $key )
		{
			return $this->_vars[ $key ];
		}

	}

?>
