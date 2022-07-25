<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory, HasApiTokens, UuidTraits;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pass_id',
        'first_name', 
        'last_name', 
        'email',
        'role',
        'department',
        'age',
        'address',
        'is_verified',
        'image',
        'leave_status'


    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function reports()
	{
		return $this->hasMany('App\Models\Report', 'pass_id');
	}

    public function salaries()
	{
		return $this->hasMany('App\Models\Salary', 'pass_id');
	}
}
