<?php
        $huyen=DB::table('diachi')->where(['parent_id',0])->first();
?>
<select>
	<option>Mời bạn chọn quận/huyện</option>
	@foreach($tinh as $tinh)
	<option value="">{{$huyen->ten}}</option>
	@endforeach
</select>
