<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Magiamgia extends Model
{
    public $table = "magiamgia";
    protected $primaryKey='id';
    protected $fillable=['magiamgia','sotien','loai','thoihan','trangthai'];
}
