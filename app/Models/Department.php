<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'departments';

    protected $fillable = ['pass_id', 'name'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
