<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class FirstTask
 * @package App\Http\Controllers
 */
class FirstTask extends TaskController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	/**
	 *
	 */
	/**
	 *
	 */
	const LARAVEL = 'larave',
		  ENVOYER = 'envoye';

	/**
	 * @param $name
	 * @param $checkedWord
	 * @return bool
	 */
	private function checkReverse($name, $checkedWord) : bool
	{
		for($i = 1; $i < 7; $i++)
		{
			if(!isset($name[$i]) || ($name[$i] !== $checkedWord[6 - $i]))
				return false;
		}
		return true;
	}

	/**
	 * @param $object
	 * @return bool
	 */
	protected function isValid(&$object) : bool
	{
		return parent::isValid($object) &&
				($object->name[0] === 'l'
				? $this->checkReverse($object->name, self::LARAVEL)
				: $this->checkReverse($object->name, self::ENVOYER));
	}


}
