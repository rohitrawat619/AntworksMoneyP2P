<div class="mytitle row">
		<div class="left col-md-4">
			<h1><?=$pageTitle;?></h1>
		</div>
	</div>
	
	
	<div class="white-box">
		<div class="col-md-12">
			<div class="col-md-12 upld-img-box">
				<div class="col-md-4">
				<p class="upld-img-hd">Upload your Image</p>	
						<div class="input-group">
							<span class="input-group-btn">
								<span class="btn btn-default btn-file">
									Browse… <input type="file" id="imgInp">
								</span>
							</span>
							<input type="text" class="form-control up-inpt" readonly>
						</div>
						<img id='img-upload'/>
				</div>
			</div>
			<div class="col-md-12 upld-img-box">
				<div class="col-md-12">
					<p class="upld-img-hd">Click by Camra</p>
					<!--input type="file" accept="image/*;capture=camera"-->
					<input type="file" accept="image/*" id="file-input">
				</div>
			</div>
			
		</div>
	</div>
<script>
  const fileInput = document.getElementById('file-input');
  fileInput.addEventListener('change', (e) => doSomethingWithFiles(e.target.files));
</script>