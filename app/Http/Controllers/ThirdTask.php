<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class ThirdTask
 * @package App\Http\Controllers
 */
class ThirdTask extends TaskController
{

	/**
	 * @param $object
	 * @return bool
	 */
	protected function isValid(&$object) : bool
	{
		if (!parent::isValid($object)) {
			return false;
		} else {
			$objectDate = new \DateTime($object->created);
			return (($objectDate->format('Y.d H:s') == '2014.02 21:30'));
		}
	}
}
