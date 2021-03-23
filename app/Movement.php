<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{

    protected $fillable = [
        'id',
        'transaction',
        'date',
        'amount',
        'coin',
        'description',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_movement', 'movement_id', 'account_id')->withPivot('type');
    }
}
