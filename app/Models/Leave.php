<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'reports';

    protected $fillable = ['pass_id', 'reason', 'status'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
