<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * @param $object
	 * @return bool
	 */
	protected function isValid(&$object) : bool
	{
		return is_object($object);
	}

	/**
	 * @return mixed
	 */
	private function getObjects()
	{
		return json_decode(file_get_contents('https://fecko.org/php-test'));
	}

	/**
	 * Show the profile for the given user.
	 *
	 * @param  array $objects
	 * @return Response
	 */
	public function __invoke()
	{
		$objects = $this->getObjects();
		$validObjects = [];
		$invalidObjectsCount = 0;
		$validObjectsCount = 0;
		foreach ($objects as $object){
			if($this->isValid($object)){
				array_push($validObjects, $object);
				$validObjectsCount++;
			} else {
				$invalidObjectsCount++;
			}
		}
		$user = ['ip' => request()->getClientIp(), 'locale' => request()->getLocale(), 'userAgent' => request()->server('HTTP_USER_AGENT')];
		return view('tasks')
			->with('validObjects', $validObjects)
			->with('validObjectsCount', $validObjectsCount)
			->with('invalidObjectsCount', $invalidObjectsCount)
			->with('userInfo', $user);
	}

}
