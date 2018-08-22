<?php

namespace App\Http\Controllers;

use App\Enums\EquationEnum;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class FourthTask
 * @package App\Http\Controllers
 */
class FourthTask extends TaskController
{

	/**
	 * @var array
	 */
	private $outputQueue = [];

	/**
	 * @var array
	 */
	private $operatorStack = [];

	/**
	 * @var array
	 */
	private $resultStack = [];

	/**
	 * @return array
	 */
	private function add()
	{
		$second = array_pop($this->resultStack)['string'];
		$first = array_pop($this->resultStack)['string'];
		array_push($this->resultStack, ['string' => ($first + $second)]);
		return $this->resultStack;
	}

	/**
	 * @return array
	 */
	private function substract()
	{
		$second = array_pop($this->resultStack)['string'];
		$first = array_pop($this->resultStack)['string'];
		array_push($this->resultStack, ['string' => ($first - $second)]);
		return $this->resultStack;
	}

	/**
	 * @return array
	 */
	private function divide()
	{
		$second = array_pop($this->resultStack)['string'];
		$first = array_pop($this->resultStack)['string'];
		array_push($this->resultStack, ['string' => ($first / $second)]);
		return $this->resultStack;
	}

	/**
	 *
	 */
	private function multiply()
	{
		$second = array_pop($this->resultStack)['string'];
		$first = array_pop($this->resultStack)['string'];
		array_push($this->resultStack, ['string' => ($first * $second)]);
	}

	/**
	 * @param string $equationArray
	 * @param int $index
	 * @return int
	 */
	private function evaluateOperand(string $equationArray, int $index) : int
	{
		$number = '';
		$numberLoaded = false;
		while($equationArray[$index] !== ' '){
			if(($equationArray[$index] === '-') || is_numeric($equationArray[$index])){
				$number .= $equationArray[$index];
			} else if ($equationArray[$index] === '(') {
				array_push($this->operatorStack, ['string' => $equationArray[$index], 'type' => EquationEnum::LEFT_BRACKET]);
			} else {
				array_push($this->outputQueue, ['string' => $number, 'type' => EquationEnum::OPERAND]);
				while(($operator = array_pop($this->operatorStack)) && ($operator['type'] !== EquationEnum::LEFT_BRACKET)){
					array_push($this->outputQueue, $operator);
				}
				$numberLoaded = true;
			}
			$index++;
		}
		if(!$numberLoaded){
			array_push($this->outputQueue, ['string' => $number, 'type' => EquationEnum::OPERAND]);
		}
		return ++$index;
	}

	/**
	 *
	 */
	private function lowPrecedenceEval()
	{
		while(($operator = array_pop($this->operatorStack)) && ($operator !== EquationEnum::LEFT_BRACKET)){
			array_push($this->outputQueue, $operator);
		}
		if($operator)
		{
			array_push($this->operatorStack, $operator);
		}
	}

	/**
	 *
	 */
	private function highPrecedenceEval()
	{
		while(($operator = array_pop($this->operatorStack)) &&
			 (($operator['type'] === EquationEnum::MULTIPLICATION) ||
			  ($operator['type'] === EquationEnum::DIVISION))){
			array_push($this->outputQueue, $operator);
		}
		if($operator)
		{
			array_push($this->operatorStack, $operator);
		}
	}

	/**
	 * @param string $equationArray
	 * @param int $index
	 * @return int
	 */
	private function evaluateOperator(string $equationArray, int $index) : int
	{
		switch($equationArray[$index]){
			case '+':
				$this->lowPrecedenceEval();
				array_push($this->operatorStack, [$equationArray[$index], 'type' => EquationEnum::ADDITION]);
				break;
			case '-':
				$this->lowPrecedenceEval();
				array_push($this->operatorStack, [$equationArray[$index], 'type' => EquationEnum::SUBSTRACTION]);
				break;
			case '*':
				$this->highPrecedenceEval();
				array_push($this->operatorStack, [$equationArray[$index], 'type' => EquationEnum::MULTIPLICATION]);
				break;
			case '/':
				$this->highPrecedenceEval();
				array_push($this->operatorStack, [$equationArray[$index], 'type' => EquationEnum::DIVISION]);
				break;
		}
		return $index + 2;
	}


	/**
	 *
	 */
	private function calculateResult()
	{
		while($element = array_shift($this->outputQueue)){
			switch($element['type']){
				case EquationEnum::OPERAND:
					array_push($this->resultStack, $element);
					break;
				case EquationEnum::MULTIPLICATION:
					$this->multiply();
					break;
				case EquationEnum::DIVISION:
					$this->divide();
					break;
				case EquationEnum::ADDITION:
					$this->add();
					break;
				case EquationEnum::SUBSTRACTION:
					$this->substract();
					break;
			}
		}
	}

	/**
	 * @param $object
	 * @return bool
	 */
	private function validEquation($object)
	{
		$this->operatorStack = [];
		$this->outputQueue = [];
		$equationArray = explode('= ', $object->math);
		$equationLength = strlen($equationArray[0]);
		for($i = 0; $i < strlen($equationArray[0]);){
			$i = $this->evaluateOperand($equationArray[0], $i);
			if(!($i < $equationLength))
				break;
			$i = $this->evaluateOperator($equationArray[0], $i);
		}
		while(($operator = array_pop($this->operatorStack))) {
			array_push($this->outputQueue, $operator);
		}
		$this->calculateResult();
		$result = array_pop($this->resultStack)['string'];
		return $equationArray[1] == $result;
	}

	/**
	 * @param $object
	 * @return bool
	 */
	protected function isValid(&$object) : bool
	{
		return parent::isValid($object) &&
			$this->validEquation($object);
	}
}
