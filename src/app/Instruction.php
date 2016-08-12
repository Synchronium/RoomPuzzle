<?php
namespace Synchronium\Puzzle;

	class Instruction
	{

		private $_string;
		private $_value;

		public function __construct( $instruction, $value )
		{

			// Check if instruction given is valid and throw exception if not
			if ( strlen( $instruction ) != 1 ) {
				throw new Exception( 'TL;DR: Instructions should be a single character' );
			}

			if ( ! is_numeric( $value ) ) {
				throw new Exception( 'Instructions should have a numerical value' );
			}

			// Instruction must be valid, so set properties accordingly
			$this->setString( $instruction );
			$this->setValue( $value );

		}

		public function setString( $str ) {

			$this->_string = $str;

		}

		public function setValue( $val ) {

			$this->_value = $val;

		}

		public function getString()
		{

			return $this->_string;

		}

		public function __toString()
		{
			return $this->getString();
		}

		public function getValue()
		{

			return $this->_value;

		}

	}



?>
