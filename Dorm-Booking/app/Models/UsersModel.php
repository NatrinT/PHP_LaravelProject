<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UsersModel extends Authenticatable
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = ['email', 'pass_hash', 'full_name', 'phone', 'role', 'status', 'created_at', 'updated_at'];
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->pass_hash; // ต้องตรงกับ column รหัสผ่านใน DB
    }

    // (ทางเลือก) ความสัมพันธ์กับสัญญาเช่า — จะได้เช็คสัญญายกเลิกห้อง ฯลฯ
    public function leases(): HasMany
    {
        return $this->hasMany(LeaseModel::class, 'user_id', 'id');
    }

    // (ทางเลือก) Scope สำหรับกรองเฉพาะผู้ใช้ที่ active
    public function scopeActive($q)
    {
        return $q->where('status', 'ACTIVE');
    }
}
