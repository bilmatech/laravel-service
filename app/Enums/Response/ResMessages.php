<?php namespace App\Enums\Response;

enum ResMessages: string
{
	case DB_ERR = "Something went wrong while processing storage.";
	case DB_NOT_FOUND = "Unable to retreive storage item.";
	case OTP_EXP = "Invalid token provided. Please ensure you've entered the correct confirmation code from your email.";
	case PASSWORD_RESET_EXP = "The password reset operation has expired. Please initiate a new request to reset your password.";
	case ENCRYPT_ERR = "Invalid token provided.";
	case INCOR_PWD = "Incorrect login password. Please double-check and try again.";
	case SERVICE_ERR = "Sorry, we encounted a service error while processing your request.";
	case ACC_NOT_FOUND = "The provided account ID was not found.";
	case CUS_CODE_NOT_FOUND = "We couldn't locate the requested customer code.";
	case CREDIT_ERR = "Unable to credit user wallet.";
	case DEBIT_ERR = "Unable to debit user wallet.";
	case ACCESS_UNAUTHORIZED = "Access to this resource is restricted due to insufficient privileges. Thank you for your understanding.";
	case INVALIDE_PIN = "Please verify the PIN entered and try again; it appears to be invalid.";
	case INSUFF_BALANCE = "Your current balance is insufficient to process this transaction.";
	case INSUFF_E_BALANCE = "Your current earnings balance is insufficient to process this transaction.";
	case INSUFF_P_BALANCE = "Your current points balance is insufficient to process this transaction.";
	case TARNS_PROCESSED = "Transaction has already been processed.";
	case PHONE_REQ = "To proceed, please update your phone number in the settings.";
	case EMAIL_REQ = "To proceed, please update your email address in the settings.";
	case PAYOUT_BANK_REQ = "To proceed, please update your banking details in the settings.";
	case PROFILE_PARAMS_REQ = "To proceed, please update your profile in the settings.";
	case WALLET_FUNDING_ERR = "Wallet funding could not be completed.";
	case INVALID_TRANS_AMOUNT = "Invalid transaction amount.";
	case METER_EXISTS = "Sorry this meter number is already taken.";
}
