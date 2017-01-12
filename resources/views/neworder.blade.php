@section('title','neworder')
@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<style>  
	body{
		overflow: auto !important;
	}
</style>
@endsection
@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="session-message">
			
		</h1>
	</div>
</div>

<div class="row" >
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<button type="button" id="new_item_button" class="pull-left">
			<i class="glyphicon glyphicon-plus"></i>

		</button>  
	</div>

	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h1 class="text-center">Place New Order</h1>  
	</div>
	
	<form method="POST" action="{{URL::to('/')}}/neworder">
		{{ csrf_field() }} 

			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 10px">
					<label for="phone_no" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >Serial</label>
					<input type="text" value="{{$counter}}" id="order_serial" name="order_serial" class="col-lg-8 col-md-8 col-sm-8 col-xs-8" readonly=""> 
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="margin-bottom: 10px">
					<label for="phone_no" class="col-lg-4 col-md-4 col-sm-4 col-xs-4" >Phone</label>
					<input type="text" placeholder="phone" id="user_phone" name="user_phone" class="col-lg-8 col-md-8 col-sm-8 col-xs-8" required> 
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 10px">
					<label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Name</label>
					<input type="text" placeholder="Name" id="user_name" name="user_name" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" required> 
				</div> 
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-bottom: 10px">
					<label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Address</label>
					<input type="text" placeholder="Address" id="user_address" name="user_address" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" required> 
				</div>     	   	
			</div>
			<div class="row order_panel" style="margin: 0px;padding-top: 50px">
			</div>
			<div class="row bill_panel" style="margin: 0px;padding-top: 50px">
				<div class="col-lg-12" style="margin-top: 10px">
					<label class="col-lg-2">Total Price</label>
					<input type="text" name="total_price" id="total_price" placeholder="Total" readonly="">
				</div> 

				<div class="col-lg-12" style="margin-top: 10px">
					<label class="col-lg-2">Discount</label>
					<input type="number" min="0" name="total_discount" id="total_discoun" placeholder="Discount"> 
				</div>
				<div class="col-lg-12" style="margin-top: 10px">
					<label class="col-lg-2">Advance </label>
					<input type="number" min="0" name="total_advance" id="total_advance" placeholder="Advance"> 
				</div>
				<div class="col-lg-12" style="margin-top: 10px">
					<label class="col-lg-2">Due </label>
					<input type="number" name="total_due" id="total_due" placeholder="Due" readonly=""> 
				</div>
				<div class="col-lg-12" style="margin-top: 10px">
					<label class="col-lg-2">Delivery date</label>
					<input type="text" name="delivery_date" id="delivery_date" placeholder="Delivery" required> 
				</div>

			</div>

			<div class="row" style="padding-top: 30px">
				<div class="col-lg-12">
					<button type="submit" class="pull-right btn btn-primary">Place order</button> 
				</div>
			</div>
		</form>

	</div>











	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog"> 
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Item List</h4>
				</div>
				<div class="modal-body">
					<p>
						@if(isset($products) && !empty($products))
						@foreach($products as $product)

						<button class="btn btn-sm btn-default btn_new_{{$product->product_code}}" value="{{$product->product_code}}">{{$product->name}}
							<input type="hidden" class="hidden_item_price" value={{$product->default_price}} name="hidden_item_price[]">
							<input type="hidden" class="hidden_item_type" value={{$product->id}} name="hidden_item_type[]">
						</button>
						@endforeach
						@endif
					</p>
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>
	@endsection

	@section('scripts')
	<script>
		$(document).ready(function(){ 
			$( "#delivery_date" ).datepicker({
				changeMonth: true, 
				changeYear: true, 
				dateFormat: 'yy-mm-dd',
				minDate: 'today'


			});
			var item_counter=1; 
			$('#new_item_button').on('click',function(){ 
				$('#myModal').modal("show"); 
			});

			$('body').on('click', '.delete_this_item', function() { 
				$(this).closest('.single_element').fadeOut("slow").html(""); 
			});
			$('body').on('click', '.duplicate_this_item', function() {  
				var text=$(this).closest('.single_element').html();	 
				$('.order_panel').append('<div class="row single_element" style="margin: 0px;margin-top:10px">'+text+'</div>');
			});


			$('.btn_new_un_hs').on('click',function(){
				var price=$(this).find('.hidden_item_price').val(); 
				var type=$(this).find('.hidden_item_type').val();
				var product_code=$(this).val(); 
				$('.order_panel').append('<div class="row single_element" style="margin: 0px;margin-top: 10px"><div class="col-lg-12" style="border: 1px solid white"><div class="row" style="margin:0px"> <button type="button" style="color: red;margin-left: 10px" class="pull-right delete_this_item glyphicon glyphicon-remove"></button><button type="button"  style="color:blue" class="pull-right duplicate_this_item glyphicon glyphicon-repeat"></button> </div><div class="row" style="margin: 0px"><div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><h4>Item : Half Shirt</h4>  </div><div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><h4>Item Code: '+product_code+'</h4> </div><input type="hidden" name="item_type[]" id="item_type[]" value="'+type+'" ></div><div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Price</label> <input type="text" placeholder="Price" class="price" name="price" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" value="'+price+'">  </div><div class="row" style="margin: 0px;margin-top:10px"><div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Length</label> <input type="number" min="0" placeholder="length" id="hs_length[]" name="hs_length[]" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" required>  </div> <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Width</label><input type="number" min="0" placeholder="width" id="hs_width[]" name="hs_width[]" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" required>  </div> 	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"><label for="name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3" >Size</label><input type="number" min="0" placeholder="size" id="hs_size[]" name="hs_size[]" class="col-lg-9 col-md-9 col-sm-9 col-xs-9" required> </div></div></div></div>');
				$('#myModal').modal("hide"); 
			});
			function priceIncrease(amount){

			}
 });//end of document ready

</script>
@endsection