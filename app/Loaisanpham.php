<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaisanpham extends Model
{
    public $table = "loaisanpham";
    protected $primaryKey='id_loaisp';
    protected $fillable=['parent_id_loaisp','tenloai','anh_loai','url'];
    public function loaisanpham()
    {
    	return $this->hasMany('App\Loaisanpham','parent_id_loaisp');
    }
}
