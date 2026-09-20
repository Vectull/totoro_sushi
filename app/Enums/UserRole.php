<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
    case Manager = 'manager';
    case Operator = 'operator';
    case Kitchen = 'kitchen';

    public function canAccessAdmin(): bool
    {
        return $this !== self::Customer;
    }
}
