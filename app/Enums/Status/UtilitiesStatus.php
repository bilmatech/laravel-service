<?php namespace App\Enums\Status;

enum UtilitiesStatus: string
{
	case DELIVERED = "delivered";
	case SUCCESS = "success";
	case FAILED = "failed";
	case PENDING = "pending";
	case REVERSED = "reversed";
}
