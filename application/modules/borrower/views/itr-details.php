<style>
.btn-toggle {margin: 0 10px; padding: 0; position: relative; border: none; height: 24px; width: 64px; border-radius: 24px; color: #6b7381; background: #bdc1c8;}
.btn-toggle:focus, .btn-toggle.focus, .btn-toggle:focus.active, .btn-toggle.focus.active {outline: none;}
.btn-toggle:before, .btn-toggle:after {line-height: 24px; width: 64px; text-align: center; font-weight: 600; font-size: 16px; text-transform: uppercase; letter-spacing: 2px; position: absolute; bottom: 0; transition: opacity 0.25s;}
.btn-toggle:before {content: 'Off'; left: -64px;}
.btn-toggle:after {content: 'On'; right: -64px; opacity: 0.5;}
.btn-toggle > .handle {position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 24px; background: #fff; transition: left 0.25s;}
.btn-toggle.active {transition: background-color 0.25s;}
.btn-toggle.active > .handle {left: 42px; transition: left 0.25s;}
.btn-toggle.active:before {opacity: 0.5;}
.btn-toggle.active:after {opacity: 1;}
.btn-toggle.btn-sm:before, .btn-toggle.btn-sm:after {line-height: -8px; color: #fff; letter-spacing: 0.75px; left: 6.6px; width: 52px;}
.btn-toggle.btn-sm:before {text-align: right;}
.btn-toggle.btn-sm:after {text-align: left; opacity: 0;}
.btn-toggle.btn-sm.active:before {opacity: 0;}
.btn-toggle.btn-sm.active:after {opacity: 1;}
.btn-toggle.btn-xs:before, .btn-toggle.btn-xs:after {display: none;}
.btn-toggle:before, .btn-toggle:after {color: #6b7381;}
.btn-toggle.active {background-color: #29b5a8;}
.itr-details .form-group {margin-bottom:5px; min-height:54px;}
</style>
<div class="mytitle row">
	<div class="left col-md-4">
		<h1><?=$pageTitle;?></h1>
	</div>
</div>
	
<div class="white-box">
	<div class="col-md-12">
		<div class="col-md-2"></div>
		<div class="col-md-6 p-t-40 p-b-30 m-t-30 m-b-30">
			<form class="form-horizontal itr-details text-left">
			  <div class="form-group">
				<label for="pan" class="col-sm-4 control-label">PAN Number</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="pan">
				</div>
			  </div>
			  <div class="form-group">
				<label for="pan" class="col-sm-4 control-label">DOB*</label>
				<div class="col-sm-8">
				  <div class="input-group date" data-provide="datepicker">
						<input type="text" class="form-control">
						<div class="input-group-addon">
							<span class="glyphicon glyphicon-th"></span>
						</div>
				  </div>
				</div>
			  </div>
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">Fetch Form26AS*</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="years" placeholder="1">
				</div>
			  </div>
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">No of Years for Form26AS*</label>
				<div class="col-sm-8">
				  <button type="button" class="btn btn-sm btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
					<div class="handle"></div>
				  </button>
				</div>
			  </div>
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">Fetch ITR*</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="years" placeholder="1">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">No of Years for ITR*</label>
				<div class="col-sm-8">
				  <button type="button" class="btn btn-sm btn-toggle active" data-toggle="button" aria-pressed="true" autocomplete="off">
					<div class="handle"></div>
				  </button>
				</div>
			  </div>
			  <div class="form-group">
				<label for="years" class="col-sm-4 control-label">Secret Key*</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="years">
				</div>
			  </div>
			  
			  
			  <div class="form-group">
				<div class="col-sm-offset-2 col-sm-10 text-right">
				  <button type="submit" class="btn btn-success">Submit</button>
				  <button type="reset" class="btn btn-default">Reset</button>
				</div>
			  </div>
			</form>
		</div>
	</div>
</div>