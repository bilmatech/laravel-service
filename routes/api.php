<?php

use App\Http\Controllers\Verification\VerificationApis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v1", "controller" => VerificationApis::class], function () {
	Route::prefix("verification")->group(function () {
		/**
		 * @todo Verify phone number
		 * @api /api/v1/verification/phone
		 */
		Route::get("phone", "phoneNumber");

	});
});
