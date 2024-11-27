<?php namespace App\Enums\Events;

enum AppEvents: string
{
	case WALLET_EVENT = "BP:wallet";
	case AIRTIME_EVENT = "BP:mobile_airtime";
	case APP_TRANS_EVENT = "BP:socket_trans_event";
}
