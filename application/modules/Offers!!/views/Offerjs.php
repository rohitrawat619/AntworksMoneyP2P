<script>
	$("#coupon_code_type").change(function (){

		$("#coupon_code_type_input_parameter").html("");
		if($("#coupon_code_type").val() == 'Single')$("#coupon_code_type_input_parameter").html("<div class='col-md-6'><div class='form-group'><label>Coupon Code</label><input type='text' name='coupon_code' id='coupon_code' class='form-control' placeholder='Coupon Code'  /></div></div>");


		if($("#coupon_code_type").val() == 'Multiple')$("#coupon_code_type_input_parameter").html("<div class='col-md-6'><div class='form-group'><label>Coupon Code List</label><input type='file' name='coupon_code_list' id='coupon_code_list' class='form-control' placeholder='Coupon Code'  /></div></div>");

	})
</script>
<script>
	$("#addCategory").click(function (){
		if($("#add_category_name").val() == "")
		{
          alert("Please enter category name");
          return false;
		}
		else{
			var add_category_name = $("#add_category_name").val();
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL + "offers/addCategory",
				data: {add_category_name:add_category_name},
				success: function (data) {
					var response = $.parseJSON(data);
					if (response.status == 1) {
						alert(response.msg);
						$('#modal').modal('toggle');
					} else {
						alert(response.msg);
					}
				}
			});
		}
	})
	$("#addApppage").click(function (){
		if($("#add_app_page").val() == "")
		{
			alert("Please enter APP page");
			return false;
		}
		else{
			var add_app_page = $("#add_app_page").val();
			$.ajax({
				async: true,
				type: "POST",
				url: baseURL + "offers/addApppage",
				data: {add_app_page:add_app_page},
				success: function (data) {
					var response = $.parseJSON(data);
					if (response.status == 1) {
						alert(response.msg);
						$('#modal').modal('toggle');
					} else {
						alert(response.msg);
					}
				}
			});
		}
	})

</script>
<script>
	$(document).ready(function () {
		var i = 0;
		$(".add-app-page-multiple").click(function () {
			i = i + 1;
			var domElement = $('<div class="col-md-12"><div class="col-md-4"><div class="form-group"><select name="app_page_name[]" class="form-control"><option value="">Select Page Name</option><? foreach ($app_pages as $app_page) { ?><option value="<?= $app_page["app_page"]; ?>"><?= $app_page["app_page"]; ?></option><? } ?></select></div></div><div class="col-md-4"><div class="form-group"><select name="app_page_position[]" id="" class="form-control"><option value="">Select Position</option><? for ($i = 1; $i <= $total_positions; $i++) { ?><option value="<?= $i; ?>"><?= $i; ?></option><? } ?></select></div></div></div>');
			$('.multiple_pages').before(domElement);
		});


	});
</script>
