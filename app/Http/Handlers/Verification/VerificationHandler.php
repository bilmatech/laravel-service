<?php namespace BilmaPay\Http\Handlers\Verification;

use App\Enums\Response\ResCodes;

use App\Http\Handlers\Core\BaseHandler;
use Exception;
use Illuminate\Support\Facades\Log;
use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;


class VerificationHandler
{
	use BaseHandler;

	public function resolvePhoneNumber()
	{
		try {
			$testNumbers = ["08011111111"];

			$params = $this->request->all(["phone_number", "country_code"]);

			if (!in_array($params["phone_number"], $testNumbers)) {
				/* instanciate number info */
				$NumberUtil = PhoneNumberUtil::getInstance();
				$number = $NumberUtil->parse($params["phone_number"], $params["country_code"]);

				/* Get user geo coding */
				$geoCoder = PhoneNumberOfflineGeocoder::getInstance();
				$countryName = $geoCoder->getDescriptionForNumber($number, "en");

				/* get the network provider or carrier */
				$carrierMapper = PhoneNumberToCarrierMapper::getInstance();
				$carrier = $carrierMapper->getNameForNumber($number, "en");

				/* Get country calling code */
				$countryCallingCode = $NumberUtil->getCountryCodeForRegion($params["country_code"]);

				/* format number for mobile dailing */
				$mobileDaillingFormat = $NumberUtil->formatNumberForMobileDialing($number, $params["country_code"], true);

				/* format Number as international number */
				$intldailingFormat = $NumberUtil->format($number, PhoneNumberFormat::INTERNATIONAL);
				$intlNumber = $NumberUtil->format($number, PhoneNumberFormat::E164);

				/* Format number prefixing tel: to the number */
				$formatLinkDailing = $NumberUtil->format($number, PhoneNumberFormat::RFC3966);

				/* determin if number is valid */
				$isValid = $NumberUtil->isValidNumber($number);
				$isValidForRegion = $NumberUtil->isValidNumberForRegion($number, $params["country_code"]);

				/* Get regional code */
				$regionalCode = $NumberUtil->getRegionCodeForNumber($number);

				/* format the payload response */
				$validationPayload["number"] = $params["phone_number"];
				$validationPayload["carrier_name"] = $carrier;
				$validationPayload["slugs"] = ["airtime_slug" => strtolower($carrier), "data_slug" => strtolower($carrier ) . "-data"];

				$validationPayload["country"] = [
					"name" => $countryName,
					"dail_code" => $countryCallingCode,
					"code" => $regionalCode,
				];
				$validationPayload["mobile"] = [
					"local_dailing" => $mobileDaillingFormat,
					"intl_dailing" => $intldailingFormat,
					"intl_number" => $intlNumber,
					"html_link" => $formatLinkDailing,
				];
				$validationPayload["is_valid"] = $isValid;
				$validationPayload["is_valid_for_region"] = $isValidForRegion;
				$validationPayload["icon"] = "/images/icons/{$carrier}.png";
			} else {
				/* randomly get the Network type  */
				$netWorks = ["MTN", "Airtel", "Glo", "9mobile"];
				$networkPs = random_int(0, count($netWorks) - 1);

				/* format the payload response */
				$validationPayload["number"] = $params["phone_number"];
				$validationPayload["carrier_name"] = $netWorks[$networkPs];
				$validationPayload["slugs"] = ["airtime_slug" => strtolower($netWorks[$networkPs]), "data_slug" => strtolower($netWorks[$networkPs]) . "-data"];

				$validationPayload["country"] = [
					"name" => "Nigeria",
					"dail_code" => "+234",
					"code" => "NG",
				];

				$validationPayload["is_valid"] = true;
				$validationPayload["is_valid_for_region"] = true;
				$validationPayload["icon"] = "images/icons/{$netWorks[$networkPs]}.png";
			}

			//-----------------------------------------------------

			/** Request response data */
			$responseMessage = "Success, phone number resolved successfully!";
			$response["type"] = "verification";
			$response["body"] = $validationPayload;
			$responseCode = ResCodes::OK->value;

			return $this->response($response, $responseMessage, $responseCode);
		} catch (Exception $th) {
			Log::error($th->getMessage(), ["Line" => $th->getLine(), "file" => $th->getFile()]);

			return $this->raise($th->getMessage(), null, 400);
		}
	}

}
