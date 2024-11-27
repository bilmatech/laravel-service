<?php namespace App\Http\Handlers;

use BilmaPay\Http\Handlers\Verification\VerificationHandler;
use Illuminate\Http\Request;

class Handlers
{


	public static function Verification(Request $request)
	{
		return new VerificationHandler($request);
	}


}
