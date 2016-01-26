<?php namespace App\Http\Controllers;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

	use AuthorizesRequests,
		DispatchesJobs,
		ValidatesRequests;

}
