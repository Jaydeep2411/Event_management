<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class eventLog extends Model
{
    protected $fillable = [
        'event_id',
        'admin_id',
        'action',
        'old_values',
        'new_values',
    ];
}
