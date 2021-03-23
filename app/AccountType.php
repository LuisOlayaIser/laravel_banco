<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
}
