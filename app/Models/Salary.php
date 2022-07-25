<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class Salary extends Model
{
    use UuidTraits;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'salaries';

    protected $fillable = ['pass_id','amount'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
