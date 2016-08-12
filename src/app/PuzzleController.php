<?php
namespace Synchronium\Puzzle;

use Twig_Loader_Filesystem;
use Twig_Environment;


	Class PuzzleController extends Controller
	{

		public function index()
		{

			// get instructions file path from registry
			$instructions_file = $this->registry->instructionsFile;
			// Generate instructions collection from factory
			$instructions = InstructionsFactory::generate( $instructions_file );
			// store instructions collection back in registry

			if ( sizeof( $instructions ) < 1 ) {
				return false;
			}
			$this->registry->instructions = $instructions;

			// fire up Twig templating engine
			$loader = new Twig_Loader_Filesystem(__DIR__ . DIRECTORY_SEPARATOR .'../template');
			$twig = new Twig_Environment($loader);

			// Load template for part-answer and final answer
			$part_answer_template = $twig->loadTemplate('PartAnswer.txt');
			$full_answer_template = $twig->loadTemplate('FullAnswer.txt');

			// Populate array to pass to final answer template:
			// Answers for both parts of the question are generated from the
			// part answer template
			$answers = array(
				'part1' => $part_answer_template->render( array(
					'part' => 1,
					'answer' => $this->partOne()
				) ),
				'part2' => $part_answer_template->render( array(
					'part' => 2,
					'answer' => $this->partTwo()
				) ),

			);

			// OUTPUT FINAL ANSWER!
			$full_answer_template->display( array( 'answers' => $answers ) );

		}

		// Action to calculate Part One of the question
		public function partOne()
		{
			/***
			 * SUMMARY:
			 * Man enters ground floor of apartment building;
			 * follows friend's instructions to find floor friend lives on
			 ***/

			// Start at floor zero
			$current_floor = 0;

			// Loop through collection of Instruction objects in registry
			foreach ( $this->registry->instructions as $instruction )
			{
					// get mathematical value of each instruction and apply it
					// to the current floor to move up or down
					$current_floor += $instruction->getValue();
			}

			// All instructions have been followed, so the current floor is the
			// correct destination
			return $current_floor;

		}

		// Action to calculate Part Two of the question
		public function partTwo()
		{
			/***
			 * SUMMARY:
			 * Which instruction first enters the basement?
			 ***/

			/***
			 * NOTE:
			 * It would have been more efficient to loop through the instructions
			 * once and set a flag in the registry when the man enters the basement
			 * ( ie $current_floor == -1 ), while continuing to follow instructions
			 * to answer Part One, then simply outputting that flag in answer to Part Two
			 * ...but where's the fun in that?!
			 ***/

			// Start at floor zero
			$current_floor = 0;

			// First instruction is defined at position one
			$instruction_index = 1;

			// Loop through collection of Instruction objects in registry
			foreach ( $this->registry->instructions as $instruction )
			{

					// Calculate current floor, as per part one
					$current_floor += $instruction->getValue();

					// Check if current floor is the basement...
					if ( $current_floor < 0 ) {

						// ...it is, hurray! So break out of foreach loop
						// No point continuing, as we're only interested in the
						// first occurance of basement entry
						break;

					}

					// If we're still here, then we're not in the basement.
					// This loop will iterate at least once more
					// so increment the instruction counter
					$instruction_index++;

			}

			// Output the position of the basement instruction
			return $instruction_index;

		}

	}

?>
