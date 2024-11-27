<?php namespace App\Enums\Response;

enum ResCodes: int
{
	case DB_ERR = 400;
	case CLIENT_ERR = 422;
	case OK = 200;
	case CREATED = 201;
	case VOID = 204;
	case UNAUTHORIZED = 401;
	case FORBIDDEN = 403;
	case SERVER_ERR = 500;
	case NOT_FOUND = 404;
}