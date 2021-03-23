<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'id',
        'number',
        'alias',
        'balance',
        'bank_id',
        'account_type_id',
        'user_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function movements()
    {
        return $this->belongsToMany(Movement::class, 'account_movement', 'account_id', 'movement_id')->withPivot('type');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}
