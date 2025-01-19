<?php

namespace App\Core\Enums;

enum UserRole: string
{
	case user = "user";
	case admin = "admin";
}