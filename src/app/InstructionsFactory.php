<?php
namespace Synchronium\Puzzle;

	abstract class InstructionsFactory
	{

		public function generate( $filename )
		{

				// Permitted instructions
				$permitted = array( '>' => -1, '<' => 1 );

				$instructions_string = self::_load( $filename );

				// Check instructions string contains only valid instructions
				// and is at least one instruction long
				if ( ! preg_match('/^[' . implode( '', array_keys( $permitted ) ) . ']+$/', $instructions_string) ) {

					throw new Exception( "Instructions file contains invalid instructions. Valid instructions are: " . implode( ', ', array_keys( $permitted ) ) );

				}

				// split instructions string into char array
				$instructions_chars = str_split( $instructions_string );

				// empty collection of parsed instructions
				$instructions = new InstructionCollection();

				// loop through char array and create Instruction objects
				foreach ( $instructions_chars as $key => $char ) {

					$instruction = new Instruction( $char, $permitted[ $char ] );
					$instructions->addItem( $instruction );

				}

				return $instructions;

		}

		private function _load( $filename )
		{

			// Check if file exists and we can read from it
			if ( ! is_readable( $filename ) ) {
				throw new Exception( "Instructions file does not exist or cannot be read: {$filename}");
			}

			$data = file_get_contents( $filename );

			if ( $data === false || strlen( $data ) < 1 ) {
				throw new Exception( "Instructions file is empty or cannot be read: {$filename}");
			}

			return $data;

		}


	}


?>
