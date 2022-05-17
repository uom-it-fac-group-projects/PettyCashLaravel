<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imprest extends Model
{
    protected $fillable = [
        'imprest_amount'
    ];

    use HasFactory;
}
