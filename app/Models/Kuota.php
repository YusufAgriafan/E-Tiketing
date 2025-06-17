<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuota extends Model
{
    protected $fillable = [
        'peserta',
        'kuota',
        'status',
    ];
}
