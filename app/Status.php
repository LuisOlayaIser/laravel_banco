<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        'id',
        'name',
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
