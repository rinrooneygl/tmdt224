<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

use Image;
use App\SanPham;
use App\LoaiSanPham;
use App\ThuocTinh;
use App\AnhSanPham;

class SPController extends Controller
{
    public function themsp(Request $request)
    {
    	if ($request->isMethod('post')) {
    		$data=$request->all();
            // echo "<pre>";print_r($data);die;
            if (empty($data['id_loaisp'])) {
                return redirect()->back()->with('flash_message_error','Lỗi');
            }

    		$sanpham=new SanPham;
    		$sanpham->id_loaisp=$data['id_loaisp'];
            $sanpham->ten_sanpham=$data['ten_sanpham'];
            $sanpham->code_sanpham=$data['code_sanpham'];
            $sanpham->url_sp=$data['url_sp'];
            $sanpham->mieuta=$data['mieuta'];
            $sanpham->price=$data['price'];
            if ($request->hasFile('anh')) {
                $anh_tmp=$request->anh;
                if ($anh_tmp->isValid()) {
                    $extension=$anh_tmp->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='SanPham/large/'.$filename;
                    $medium_image_path='SanPham/medium/'.$filename;
                    $small_image_path='SanPham/small/'.$filename;
                    Image::make($anh_tmp)->save($large_image_path);
                    Image::make($anh_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($anh_tmp)->resize(300,300)->save($small_image_path);
                    $sanpham->anh=$filename;
                }
            }
    		$sanpham->save();
            return redirect('/admin/xemsp')->with('flash_message_success','Thêm thành công');


    		
    	}
    	$loaisanpham=LoaiSanPham::where(['parent_id_loaisp'=>0])->get();
    	$loaisanpham_dropdown="<option value='' selected disabled>Select</option>";
    	foreach ($loaisanpham as $loai) {
    		$loaisanpham_dropdown.="<option value='".$loai->id_loaisp."'>".$loai->tenloai."</option>";
    		$sub_loaisanpham=LoaiSanPham::where(['parent_id_loaisp'=>$loai->id_loaisp])->get();
    		foreach ($sub_loaisanpham as $sub_loai) {
    			$loaisanpham_dropdown.="<option value='".$sub_loai->id_loaisp."'>&nbsp;--&nbsp;".$sub_loai->tenloai."</option>";
    		}
    	}

    	return view('admin.sanpham.them_sp')->with(compact('loaisanpham_dropdown'));
    	
    }
    public function suasp(Request $request,$id=null)
    {
        if ($request->isMethod('post')) {
        $data=$request->all();
        // echo "<pre>";print_r($data);die;
        if ($request->hasFile('anh')) {
                $anh_tmp=$request->anh;
                if ($anh_tmp->isValid()) {
                    $extension=$anh_tmp->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='SanPham/large/'.$filename;
                    $medium_image_path='SanPham/medium/'.$filename;
                    $small_image_path='SanPham/small/'.$filename;
                    Image::make($anh_tmp)->save($large_image_path);
                    Image::make($anh_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($anh_tmp)->resize(300,300)->save($small_image_path);
                    
                }
            }
            else{
                $filename=$data['current_image'];
            }
        
        SanPham::where(['id_sanpham'=>$id])->update(['ten_sanpham'=>$data['ten_sanpham'],'code_sanpham'=>
            $data['code_sanpham'],'mau_sanpham'=>$data['mau_sanpham'],'mieuta'=>$data['mieuta'],'price'=>$data['price'],'anh'=>$filename]);
        return redirect('/admin/xemsp')->with('flash_message_success','Sửa thành công');
    }

        $chitiet_sp=SanPham::where(['id_sanpham'=>$id])->first();
        $loaisanpham=LoaiSanPham::where(['parent_id_loaisp'=>0])->get();
        $loaisanpham_dropdown="<option value='' selected disabled>Select</option>";
        foreach ($loaisanpham as $loai) {
            if ($loai->$id==$chitiet_sp->id_loaisp) {
                $selected="selected";
            }
            else
            {
                $selected="";
            }
            $loaisanpham_dropdown.="<option value='".$loai->id."'".$selected.">".$loai->tenloai."</option>";
            $sub_loaisanpham=LoaiSanPham::where(['parent_id_loaisp'=>$loai->id])->get();
            foreach ($sub_loaisanpham as $sub_loai) {
                if ($sub_loai->$id==$chitiet_sp->id_loaisp) {
                $selected="selected";
            }
            else
            {
                $selected="";
            }
                $loaisanpham_dropdown.="<option value='".$sub_loai->id."'".$selected.">&nbsp;--&nbsp;".$sub_loai->tenloai."</option>";
            }
        }
        
        return view('admin.sanpham.sua_sp')->with(compact('chitiet_sp','loaisanpham_dropdown'));
    }
    public function xoaanh($id=null)
    {
        $anh_sanpham=SanPham::where(['id_sanpham'=>$id])->first();
        $large_image_path='SanPham/large/';
        $medium_image_path='SanPham/medium/';
        $small_image_path='SanPham/small/';
        if (file_exists($large_image_path.$anh_sanpham->anh)) {
            unlink($large_image_path.$anh_sanpham->anh);
        }
        if (file_exists($medium_image_path.$anh_sanpham->anh)) {
            unlink($medium_image_path.$anh_sanpham->anh);
        }
        if (file_exists($small_image_path.$anh_sanpham->anh)) {
            unlink($small_image_path.$anh_sanpham->anh);
        }
        SanPham::where(['id_sanpham'=>$id])->update(['anh'=>'']);
        return redirect()->back()->with('flash_message_success','Xóa thành công');
    }
    public function xoasp($id=null)
    {
       if(!empty($id))
        {
            SanPham::where(['id_sanpham'=>$id])->delete();
            return redirect()->back()->with('flash_message_success','Xóa thành công');
        }
    }
    public function xemsp()
    {
        $sanpham=SanPham::join('LoaiSanPham','loaisanpham.id_loaisp','sanpham.id_loaisp')->get();
        return view('admin.sanpham.xem_sp')->with(compact('sanpham'));
    }
    public function themthuoctinh(Request $request,$id=null)
    {
        $chitiet_sp =SanPham::with('thuoctinh')->where(['id_sanpham'=>$id])->first();
        // $chitiet_sp=json_decode(json_encode($chitiet_sp));
        // echo "<pre>";print_r($chitiet_sp);die;

       
        
        
            if ($request->isMethod('post')) {
            $data=$request->all();


            
            foreach ($data['ma_sanpham'] as $key => $val) {
                if (!empty($val)) {
                    $thuoctinh=new ThuocTinh;
                    $thuoctinh->id_sanpham=$id;
                    $thuoctinh->ma_sanpham=$val;
                    $thuoctinh->size=$data['size'][$key];
                    $thuoctinh->giatien=$data['giatien'][$key];
                    $thuoctinh->soluong=$data['soluong'][$key];
                    $thuoctinh->cannang=$data['cannang'][$key];
                    if ($request->hasFile('anh')) {
                $anh_tmp=$request->anh;
                if ($anh_tmp->isValid()) {
                    $extension=$anh_tmp->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='SanPham/large/'.$filename;
                    $medium_image_path='SanPham/medium/'.$filename;
                    $small_image_path='SanPham/small/'.$filename;
                    Image::make($anh_tmp)->save($large_image_path);
                    Image::make($anh_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($anh_tmp)->resize(300,300)->save($small_image_path);
                    $thuoctinh->anh=$filename;
                }
            }
                    
                    $thuoctinh->save();
                }
            }

            

        }
        
        $thuoctinh=ThuocTinh::where('id_sanpham',$id)->get();
        // $product=ThuocTinh::findOrFail($id);

        return view('admin.sanpham.them_thuoctinh')->with(compact('chitiet_sp','thuoctinh'));

    }
    public function xemthuoctinh($id=null)
    {
        $attributes=ThuocTinh::where('id_sanpham',$id)->get();
        $product=ThuocTinh::findOrFail($id);
        return view('admin.sanpham.them_thuoctinh',compact('product','attributes'));
    }
    public function themanh(Request $request,$id=null)
    {
        $chitiet_sp =SanPham::with('thuoctinh')->where(['id_sanpham'=>$id])->first();
        if ($request->isMethod('post')) {
            $data=$request->all();
            if ($request->hasFile('anh')) {
                $file=$request->file('anh');
                foreach ($file as $file) {
                    
                $anh=new AnhSanPham;
                $extension=$file->getClientOriginalExtension();
                    $filename=rand(111,99999).'.'.$extension;
                    $large_image_path='SanPham/large/'.$filename;
                    $medium_image_path='SanPham/medium/'.$filename;
                    $small_image_path='SanPham/small/'.$filename;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);
                    $anh->anh=$filename;
                    $anh->id_sanpham=$data['id_sanpham'];
                    $anh->save();
                }
                
            }
            return redirect('/admin/themanh/'.$id)->with('success','Thêm ảnh thành công');
            
        }
        $anh_sanpham=AnhSanPham::where(['id_sanpham'=>$id])->get();
        return view('admin.sanpham.them_anh',compact('chitiet_sp','anh_sanpham'));
    }
    public function xoaanhsp($id=null)
    {
       if(!empty($id))
        {
            AnhSanPham::where(['id'=>$id])->delete();
            return redirect()->back()->with('success','Xóa thành công');
        }
    }
    
    
}

