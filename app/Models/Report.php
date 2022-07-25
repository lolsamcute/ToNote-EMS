<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class Report extends Model
{
    use UuidTraits;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'reports';

    protected $fillable = ['pass_id', 'subject', 'messsage'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
