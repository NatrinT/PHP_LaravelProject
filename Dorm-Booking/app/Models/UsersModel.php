<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsersModel extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'pass_hash', 'full_name', 'phone','role','status','created_at','updated_at'];
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->pass_hash; // ต้องตรงกับ column รหัสผ่านใน DB
    }
}
