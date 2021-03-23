<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    
    
    
protected $fillable = [
    'id',
    'alias',
    'account_id',
    'user_id',
];

public function account()
{
    return $this->belongsTo(Account::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
