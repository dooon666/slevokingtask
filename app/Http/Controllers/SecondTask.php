<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class SecondTask
 * @package App\Http\Controllers
 */
class SecondTask extends TaskController
{
	/**
	 * @param $object
	 * @return bool
	 */
	public function isValid(&$object) :bool
	{
		return parent::isValid($object) &&
			(!(($object->third % 20) && ($object->third % 12)) &&
			  (($object->third * $object->second) === $object->first));
	}
}
