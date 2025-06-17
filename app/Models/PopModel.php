<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopModel extends Model
{
    //

    protected $table = 'proof_of_payments';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
}
