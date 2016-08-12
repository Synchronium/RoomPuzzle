<?php
namespace Synchronium\Puzzle;
use ArrayObject;

	class InstructionCollection extends ArrayObject
	{

		public function addItem( Instruction $instruction )
		{

			parent::append( $instruction );

		}

	}

?>
