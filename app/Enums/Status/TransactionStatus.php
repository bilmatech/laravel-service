<?php namespace App\Enums\Status;

enum TransactionStatus: string
{
	/** Transaction succeeded */
	case SUCCESS = "success";
	/** Transaction failed */
	case FAILED = "failed";
	/** Transaction is beeing processed. */
	case PENDING = "pending";
	/** Transaction was abandoned by the user. */
	case ABANDONED = "abandoned";
	/** Transaction encountered an error. */
	case ERROR = "error";
}