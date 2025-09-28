<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcement';
    protected $primaryKey = 'id'; // ตั้งให้ตรงกับชื่อจริงใน DB
    protected $fillable = ['title', 'body', 'link', 'image','created_at','updated_at'];
    public $incrementing = true; // ถ้า primary key เป็นตัวเลข auto increment
    public $timestamps = true;
}
