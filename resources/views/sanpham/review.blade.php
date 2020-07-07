@extends('layouts.frontLayout.index')
@section('content')
<div class="services-breadcrumb">
		
	</div>
	<!-- //page -->
	<!-- checkout page -->
	<div class="privacy">
		<div class="container">
			<!-- tittle heading -->
			<h3 class="tittle-w3l">Checkout
				<span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
			</h3>
			<!-- //tittle heading -->
			<div class="checkout-right">
				<h4>Vận chuyển đến :
					
				</h4>
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>Tên</th>
								<th>Địa chỉ</th>
								<th>Số điện thoại</th>
								
							</tr>
						</thead>
						<tbody>
							<tr class="rem1">
								@if(!empty($chitiet_ship))
								<td>{{$chitiet_ship->ten}}</td>
								<td>{{$chitiet_ship->diachi}}</td>
								<td>{{$chitiet_ship->sdt}}</td>
								@endif
							</tr>
							
						</tbody>
					</table>
				</div>

			</div>
			<div class="checkout-left">
				<div class="table-responsive">
					<table class="timetable_sub">
						<thead>
							<tr>
							    <th>Sản phẩm</th>
								<th>Ảnh</th>
							    <th>Màu sắc</th>
								<th>Size</th>
								<th>Giá</th>
								<th>Số lượng</th>
							</tr>
						</thead>
						<tbody>
							<?php $tong=0; ?>
							@foreach($cart as $cart)
							<tr class="rem1">
								<td class="invert">{{$cart->ten_sanpham}}</td>
								<td class="invert"><img src="{{asset('SanPham/small/'.$cart->anh)}}" alt="" style="width: 100px;"></td>
								
								<td class="invert">{{$cart->mau_sanpham}}</td>
								<td class="invert">{{$cart->size}}</td>
								<td class="invert">{{$cart->gia}},000đ</td>
								<td class="invert">
								{{$cart->soluong}}
								</td>
		                    </tr>
							<?php $tong=$tong+($cart->gia*$cart->soluong);?>
							@endforeach
							
						</tbody>
					</table>

				<table>
					<tr>
						<td>Tổng tiền :</td>
						<td>{{$tong}},000đ</td>
					</tr>
					<tr>
						<td>Phí ship :</td>
						<td>30,000đ</td>
					</tr>
					<tr>
						<td>Mã giảm giá :</td>
						<td>@if(!empty(Session::get('CouponAmount')))
							{{Session::get('CouponAmount')}},000đ
							@else 0 đ
							@endif
						</td>
					</tr>
					<tr>
						<td>Tổng tiền :</td>
						<td>{{$tong-Session::get('CouponAmount') +30}},000đ</td>

						
					</tr>

				</table>
				<form name="paymentForm" id="paymentForm" action="{{url('/dathang')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="tongtien" value="{{$tong-Session::get('CouponAmount') +30}}">
                
                
                <span>
                	<label for=""><strong>Phương thức thanh toán :</strong></label>
                	
                </span>

					<input type="radio" name="phuongthuc" id="COD" value="COD">COD
				
				<span>
					
					<button type="submit" class="btn btn-outline-primary" onclick="return selectPaymentMethod();">Đặt hàng</button>
				</span>
				</form>
				
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	
	
@endsection