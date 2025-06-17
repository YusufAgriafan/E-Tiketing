<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jaket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','nama', 'email', 'tshirt_data', 'status'];

    protected $casts = [
        'tshirt_data' => 'array',
        'status' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
