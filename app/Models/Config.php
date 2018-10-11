<?php

namespace Omega\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //
    protected $fillable = [
        'key', 'value'
    ];
}
