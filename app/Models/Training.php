<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'trainings';

    protected $fillable = ['pass_id', 'name', 'reason', 'status'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
