<?php namespace App\Enums\Configs;

enum BilmaConfigs: string
{
	/**
	 * BilmaPay monthly commission charges that is debited from users wallet every end of the month.
	 */
	case MONTHLY_CHARGE = "50";
	case POINTS_EARN_RATES = "0.15";
	case POINTS_CONV_RATES = "0.16";
	case VTP_FUNDING_ACC = "8634818963";
	case VTP_FUNDING_BANK = "Wema Bank";
	case VTP_FUNDING_BANK_CODE = "035";
	case VTP_MIN_BAL = "5000";
	case VTP_FUNDING_BAL = "1100";
}
