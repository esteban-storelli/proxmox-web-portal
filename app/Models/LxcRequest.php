<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LxcRequest extends Model
{
    protected $table = 'lxc_requests';
    protected $fillable = [
        'machine_power',
        'details',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
