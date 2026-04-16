<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case Admin = 'admin';
    case DataProvider = 'data_provider';
}
