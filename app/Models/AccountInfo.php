<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AccountInfo
 *
 * @property $id
 * @property $username
 * @property $name
 * @property $sex
 * @property $birthday
 * @property $email
 * @property $remark
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AccountInfo extends Model
{
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['username','name','sex','birthday','email','remark'];



}
