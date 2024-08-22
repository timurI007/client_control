<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'birthdate'
    ];

    protected $casts = [
        'birthdate' => 'date'
    ];

    protected function birthdateFormatted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birthdate->format('d.m.Y'),
        );
    }
}
