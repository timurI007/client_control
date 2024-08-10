<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory;

    protected $casts = [
        'birthdate' => 'date'
    ];

    protected function birthdate(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('d.m.Y', strtotime($value)),
        );
    }
}
