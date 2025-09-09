<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaseModel extends Model
{
    protected $table = 'leases';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['user_id', 'room_id', 'start_date', 'end_date','rent_amount','deposit_amount','status','contract_file_url','create_at','update_at'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = false;
}
