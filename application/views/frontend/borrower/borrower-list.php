<?php error_reporting(0); ?>
<link href="<?=base_url();?>assets-admin/css/bid-list.css" rel="stylesheet">
<style>

	.panel-filter {background-color:#91bc37;}
	.panel-filter .panel-body {padding: 25px 25px 15px 25px;}
	.panel-filter .panel-body:last-child {padding-bottom: 30px;}
	.panel-filter .panel-body hr {margin-top:10px; margin-bottom:20px;}
	.panel-filter .panel-body .box-title {margin:0; line-height:0; padding-bottom: 10px;}
	.scrollable{min-height:500px;}
	.btn-anchor {background-image: url(../plugins/images/icons.png);}
	.inner-container{background: #ffffff; padding: 25px; margin-bottom: 15px; float: left; width: 100%;}
	.table-responsive.borrower-list tr td a > img{ width:40px}
	.white-box {background: #ffffff; padding: 25px; margin-bottom: 15px; float: left; width: 100%;}
	.info-text{padding-left: 0px; margin-bottom: 0px;}
	.info-text li { display: inline-block; padding: 3px 22px 2px 0px; /*border-left: 1px solid #c7c2c2;*/ margin-bottom: 5px}
	.info-text li:first-child{border-left:none;padding-left: 0px;}
	.panel .panel-footer {background: #ffffff; border-radius: 0; padding: 20px 25px; float: left; display: block; width: 100%;}
	.ellipsis {white-space: nowrap; overflow: hidden; text-overflow: ellipsis; -o-text-overflow: ellipsis; -ms-text-overflow: ellipsis; width: 100px; margin: 0 0 0px;}
	.search-box{ text-align:center}
	dt {font-weight: 500; color: #5e7bcc; float: left; padding-right: 13px; width: 106px; margin-left: 7px;}
	.label-info {background-color: #20a571; float: right; padding: 7px 15px; font-size: 11px;}
	/* .panel .panel-heading {border-radius: 0; font-weight: 300; text-transform: uppercase; padding: 3px 0px; font-size: 17px;} */
	.light-logo {max-width:224px!important;}
	.navbar-header {padding:0 17px;}
	.dashbox {box-shadow: 0px 1px 15px #dedede; width: 100%; float: left; border-radius:2px; overflow:hidden;}
	.white-box .col-in i{font-size:42px;}
	.col-in-bg {background:#00518c; padding:12px 10px; color:#fff; text-align:center;}
	.counter {color:#333; line-height:22px;}
	.col-in h3 {font-size: 42px; font-weight: 300;}
	.text-muted {font-weight:400; letter-spacing: .8px; width: 100%; float: left; margin: 5px 0 0 0;}
	.row-in-br {border-right: none;}

	#page-wrapper .container-fluid {padding-left: 15px !important; padding-right: 15px !important;}
	.form-material .form-control {border: 1px solid #e4e7ea; padding:5px 10px;}
	.form-bg {padding:10px 30px; /*box-shadow: 0px 0px 6px rgba(0,0,0,.1);*/ width:100%; float:left; margin-top:15px;}
	.box {box-shadow: 0 0 10px #d5d5d5; padding: 30px; border: 1px solid #d5d5d5;}
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {padding: 4px;}
	.table td {font-size: 12px; font-weight: 300; color:#000;}
	.table th {background: #01548f; font-size:12px;	 font-weight:600; color: #fff; /*border:1px solid #00477a!important;*/}
	.table td .btn {padding:1px 5px; font-size:10px; border-radius:4px;}
	table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting::after {color:#fff;}
	table.dataTable thead .sorting, table.dataTable thead .sorting_asc, table.dataTable thead .sorting_desc, table.dataTable thead .sorting_asc_disabled, table.dataTable thead .sorting_desc_disabled {background:#01548f;}
	.footable-odd {background-color: transparent;}
	.p2ploans tr th {background: #fff; color: #000000; font-size: 13px; font-weight: 600;}
	#Amount {width:60%; float:left;}
	.btnp2p {width:38%; float:left; margin-top: 0; margin-left:2px;}
	#proposel-submit-data .modal-content {background: rgb(128, 174, 195);}
	#proposel-submit-data .modal-header .modal-title {color:#fff;}
	#proposel-submit-data .control-label {color:#fff;}
	#proposel-submit-data .modal-header {border-bottom: 1px solid #5f95ad;}
	#proposel-submit-data .modal-footer {border-top: 1px solid #5f95ad;}
	#proposel-submit-data .modal-dialog {margin-top:20%; transform: translateY(-10%);}

	.pas-updt {margin-top:22px;}
	#page-wrapper {margin-left: 214px;}
	/*Proposal Listing Thumbs*/
	.proposal-listing {margin:0px; padding:20px 0; list-style:none;}
	.proposal-listing > li .disabled {opacity:0.5;}
	.proposal-listing > li .disabled .title a.status {display:none;}
	.proposal-listing > li .disabled .loan a.bid {background-color:#989898; cursor:default;}
	.proposal-listing > li .disabled .actions ul li a.express {background-color:#989898; cursor:default;}
	.proposal-listing > li .disabled .actions ul li a.info {background-color:#989898; cursor:default;}
	.proposal-listing > li .disabled .actions ul li a.star {background-color:#989898; color:#fff; border-color:#989898; cursor:default;}
	.proposal-listing > li .disabled .actions ul li a.video {background-color:#989898; color:#fff; border-color:#989898; cursor:default;}
	.proposal-listing > li {display:inline-block; margin-right:-4px; width:25%; vertical-align:top;}
	.proposal-listing > li {padding-left:10px; padding-right:10px; margin-bottom:20px;}
	.proposal-listing > li:nth-child(even) {margin-right:0;}
	.proposal-listing .title {position:relative;}
	.proposal-listing .title .name {font-size:26px; margin-right:100px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
	.proposal-listing .title .count {position:absolute; right:0; top:4px; font-size:22px; line-height:26px; color:#9dcb3b;}
	.proposal-listing .title a.status {width:25px; color:#01adee; font-size:22px; position:absolute; top:0; right:0;}
	.proposal-listing .loan {position:relative; border-top:solid 1px #ccc; border-bottom:solid 1px #ccc; padding:10px 0px; margin:10px 0px;}
	.proposal-listing .loan .amount {font-size:22px;}
	.proposal-listing .loan .amount span {display:block; font-size:12px; font-weight:bold;}
	.proposal-listing .loan a.bid {position:absolute; right:0; background-color:#00adef; color:#fff; padding:5px 10px; font-size:12px; font-weight:bold; bottom:17px;}
	.proposal-listing .desc {/*border-bottom:solid 1px #ccc;*/ padding-bottom:10px; margin-bottom:20px;}
	.proposal-listing .desc ul {margin:0px; padding:0px; list-style:none; font-size:12px;}
	.proposal-listing .desc ul li {margin-bottom:10px; display: inline-block; border-right: 1px solid #6c6c6c; padding-right: 3px; font-size: 11px; line-height: 8px;}
	.proposal-listing .actions ul {margin:0px; padding:0px; list-style:none; display:block;}
	.proposal-listing .actions ul li {display:inline-block; padding-right:5px;}
	.proposal-listing .actions ul li:last-child {padding-right:0px;}
	.proposal-listing .actions ul li a.express {background-color:#9dcb3b; color:#fff;font-size:12px; font-weight:bold;}
	.proposal-listing .actions ul li a.info {background-color:#00adef; color:#fff; padding:5px 10px; font-size:12px; font-weight:bold;}
	.proposal-listing .actions ul li a.star {background-color:#fff; color:#00adef; padding:5px 8px; font-size:12px; font-weight:bold; border:solid 1px #00adef;}
	.proposal-listing .actions ul li a.video {background-color:#fff; color:red; padding:5px 8px; font-size:12px; font-weight:bold; border:solid 1px red;}
	.panel-filter {width:100%;}
	.panel-filter .form-control {background-color:transparent; border:1px solid #fff; color:#fff; border-radius:5px;}
	.panel-filter select.form-control {background-color:transparent; border:1px solid #fff; color:#fff; border-radius:5px;}
	.panel-filter select.form-control:focus, .panel-filter select.form-control:active {color:#000;}
	.panel-filter .form-control::-webkit-input-placeholder {color:#fff;}
	.panel-filter .form-control::-moz-placeholder {color:#fff;}
	.panel-filter .form-control:-ms-input-placeholder {color:#fff;}
	.panel-filter .form-control:-moz-placeholder {color:#fff;}
	.panel-filter, .panel-filter label, .panel-filter h2, .panel-filter h5 {color:#fff;}
	.panel-filter hr {border-color:#fff;}
	.forbidnow .btn-success.btn-outline {color: #fff !important; border: none; padding: 4px 7px; font-size: 12px; font-weight: 600;}
	.forbidnow {position: absolute; right: 0; background-color: #00adef; color: #fff; font-size: 12px; font-weight: bold; bottom: 25px;}
	.express .btn.btn-block.btn-outline.btn-success {background-color: rgb(158,203,60);}
	.info-bidding .btn.btn-block.btn-outline.btn-primary {background-color:  rgb(0,173,239); color: #fff;}
	.star-shortlisted .btn.btn-block.btn-outline.btn-success {background-color: rgb(0,173,239); color: #fff;}
	/*Proposal Listing Thumbs End*/
	.main-hd {font-size: 28px; font-weight: 600; color: #000;}
	.flex-parent {display: flex; flex-direction: column; justify-content: center; align-items: center; width: 100%; height: 100%; margin:100px 0 30px;}
	.input-flex-container {display: flex; justify-content: space-around; align-items: center; width: 80vw; height: 100px; max-width: 1000px; position: relative; z-index: 0;}
	#lenderprocess .input-flex-container {display: flex; justify-content: space-around; align-items: center; width: 56vw; height: 100px; max-width: 1000px; position: relative; z-index:0;}
	.input {width: 25px; height: 25px; background-color: #00518c; position: relative; border-radius: 50%;}
	.input:hover {cursor: pointer;}
	.input::before, .input::after {content: ""; display: block; position: absolute; z-index: -1; top: 50%; transform: translateY(-50%); background-color: #00518c; width: 30vw; height: 5px; max-width: 80px;}
	.input::before {left: calc(-4vw + 12.5px);}
	.input::after {right: calc(-4vw + 12.5px);}
	.input.active {background-color: #00518c;}
	.input.active::before {background-color: #00518c;}
	.input.active::after {background-color: #AEB6BF;}
	.input.active span {font-weight: 700;}
	.input.active span::before {font-size: 14px;}
	.input.active span::after {font-size: 15px;}
	.input.active ~ .input, .input.active ~ .input::before, .input.active ~ .input::after {background-color: #AEB6BF;}
	.input span {width: 90px; height: 1px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); visibility: hidden;}
	.input span::before, .input span::after {visibility: visible; position: absolute; left: 50%;}
	.input span::after {content: attr(data-year); top: 25px; transform: translateX(-50%); font-size: 14px;}
	.input span::before {content: attr(data-info); top: -70px; width: 70px; transform: translateX(-5px) rotateZ(-45deg); font-size: 12px; text-indent: -10px; color:#333; font-weight:bold;}
	.sucs-icon {text-align:center;}
	.sucs-icon i {font-size:80px; color:#27c976;}
	.thnks-pay {font-size:42px; font-weight:100; color:#27c976;}
	.unsucs-icon {text-align:center;}
	.unsucs-icon i {font-size:90px; color:#f10027;}
	.btn-retry {background:#5cb85c; color:#fff; padding:7px 30px;}
	.btn-retry:hover {color:#fff;}
	.pay-f {font-size:24px; font-weight:100; color:#f10027;}
	.up-inpt {height:38px;}
	.upld-img-box {border: 1px dashed #ccc; padding: 0px 15px 15px 15px; margin-bottom:30px;}
	.upld-img-hd {margin-top: -12px; background: #fff; display: block; max-width: 140px; padding: 0 5px; border: 1px dashed #ccc;}
	.prsnl-dtls span {font-weight:700;}
	.prsnl-dtls .panel-heading {background:#004566;}
	.prsnl-dtls .form-horizontal .form-group {min-height: 30px;}
	.prsnl-dtls .panel .panel-body:first-child h3 {margin:15px 0 10px;}
	.prsnl-dtls .form-horizontal .control-label {text-align:left; padding-left:10px;}
	.prsnl-dtls .panel .panel-heading .panel-title {color:#fff; font-weight:600;}
	.prsnl-dtls .panel-default .panel-body {background:rgba(0, 0, 0, 0.03) !important;}
	.prsnl-dtls label {min-height:24px; line-height: 1.8; font-weight:bold;}
	.prsnl-dtls label span {float:right; padding-right:5px;}
	.prsnl-dtls .form-control-static {min-height:24px; padding:0;}
	.livefeed h4 {text-align:center; font-size:36px; margin-bottom:50px;}
	.livefeed {color:#000;}

	.stat-item {text-transform:uppercase;}
	.m-r {margin-right:10px;}
	.borrower-prof-hd, .lender-prof-hd {font-size:16px; color: #434a54; font-weight:300; text-transform:uppercase; border-bottom: 1px solid #eaeaea; padding-bottom: 5px; margin-bottom: 15px;}
	.borrower-prof-hd, .lender-prof-hd i {font-size:20px;}
	.borrower-record .table > thead > tr > th, .borrower-record .table > tbody > tr > td {border:none; padding:5px; color:#505264;}
	.borrower-record .table > tbody > tr > td:nth-child(odd) {font-weight:600;}
	.bdr-rite {border-right: 1px solid #eaeaea;}
	.borrowerdtls {border:1px solid #004566; background:#004566; color:#fff; font-size:18px; padding:0px 7px; position:absolute; right:-30px; top:0;}
	#borrowerdtls {margin-top:7px;}
	.documnt-verify {padding:0;}
	.documnt-verify li {display:inline-block; padding:5px 15px;}
	.documnt-verify i{color: #5fb600;}
	.proposal-h .tab-content {margin-top: 0; border: 1px solid #071b2f; width: 100%; float: left; padding: 15px; margin-top:-1px;}
	.proposal-h .nav-tabs > li > a {background:#071b2f; font-size:12px; color:#fff; padding: 5px 15px; border-radius: 5px 5px 0 0; overflow: hidden; border-color:#071b2f;}
	.proposal-h .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {background:#b51e37; border-color:#b51e37;}
	.kyc-main td {vertical-align: middle!important;}
	.btn-primary:hover, .btn-primary.disabled:hover, .btn-primary:focus, .btn-primary.disabled:focus, .btn-primary.focus, .btn-primary.disabled.focus {background: #003b57; opacity: .8; border: 1px solid #003b57;}
	.rateinfo {position:absolute; right:0px; top:18px; cursor:pointer;}
	.myproposal-listing .box .name {position:relative; display:inline-block; margin-right:0; width: 50%; float:left;}
	.myproposal-listing .box .cscore {position:relative; font-size:12px; color:#000; margin-top:0px; display:inline-block; padding:0; width: 25%;}
	.myproposal-listing .box .cscore span {color: #9dcb3b; font-size:20px; font-weight: 400;}
	.cscore span {font-size:14px; font-weight:600; width:100%; float:left;}
	.myproposal-listing .box .count span {display:block; font-size:12px; color:#000;}
	.myproposal-listing .box .count {top: 10px; font-size:20px; line-height: 18px;}
	.myproposal-listing .loan .amount {display:inline-block; margin-right:10px; font-size:16px;}
	.proposal-listing .loan .amount:nth-last-child {margin:0;}
	.fund-grph {display:inline-block; width:120px;}
	.fund-grph p {font-size:11px; font-weight:300; position:relative; left:10px;}
	.fund-grph .peity {float:left; width:35px; height:35px; position:relative;}
	.lefttime {position: absolute; right: 0; line-height:14px; font-size: 11px; font-weight: 400; top: -5px;}
	.lefttime p {margin:0; font-size:11px; color: #686868; font-weight: bold;}
	.lefttime p span {color:#f20;}
	.btn-details {float:right;}
	.loanagreement {text-align:center;}
	.search-container {width: 750px; display: block; margin: 0 auto;}
	input#search-bar {margin: 0 auto; width: 100%; height: 45px; padding: 0 20px; font-size: 14px; border: 1px solid #D0CFCE; outline: none;}
	input#search-bar:focus {border: 1px solid #008ABF; transition: 0.35s ease; color: #008ABF;}
	input#search-bar:focus::-webkit-input-placeholder {transition: opacity 0.45s ease; opacity: 0;}
	input#search-bar:focus::-moz-placeholder {transition: opacity 0.45s ease; opacity: 0;}
	input#search-bar:focus:-ms-placeholder {transition: opacity 0.45s ease; opacity: 0;}
	.search-icon {position: relative; float: right; width: 56px; height: 45px; top: -45px; right: 0px;}
	.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {background-color: #fff;}

	.actions {margin-right: -30px; margin-left: -30px; margin-top: -20px; margin-bottom: -30px;}
	.bidnow-form {padding:20px 30px; background:#eaeaea;}
	.bankdetails {border-top:1px solid #ccc; margin-top:20px; padding-top:25px;}
	.bankdetails .form-group {margin-bottom:10px;}
	.onlinefund {padding-top:100px; text-align:center;}
	.payamount {font-size:24px; color:#000; padding-bottom:5px; margin-bottom:25px; border-bottom:1px solid #eee;}
	.payamount i {font-size:20px;}

	@media (min-width: 1250px) {
		.input::before {left: -64.5px;}
		.input::after {right: -64.5px;}
	}
	@media (max-width: 850px) {
		.input {width: 17px; height: 17px;}
		.input::before, .input::after {height: 3px;}
		.input::before {left: calc(-4vw + 8.5px);}
		.input::after {right: calc(-4vw + 8.5px);}
	}
	@media (max-width: 600px) {
		.flex-parent {justify-content: initial; margin:20px 0;}
		.input-flex-container {flex-wrap: wrap; justify-content: center; width: 85vw !important; height: auto; margin-top: 0;}
		.input {width: 35px; height: 35px; margin: 0 10px 30px; background-color: #AEB6BF;}
		.input::before, .input::after {content: none;}
		.input span {width: 100%; height: 100%; display: block; text-align: center;}
		.input span::before {top: calc(100% + 5px); transform: translateX(-50%); text-indent: 0; text-align: center; width: 70px;}
		.input span::after {top: 50%; transform: translate(-50%, -50%); color: #ECF0F1; font-size: 12px; line-height: 14px;}
		.pay-f {font-size: 18px;}
	}
	/*Borrower Screens*/
	/*Borrower Screens*/
	@media (max-width:480px){
		.label-info {float: none; padding: 2px 7px !important; line-height: 26px;}
		.panel .panel-heading {font-size: 11px;}
	}
	@media (max-width:1800px){
		.proposal-listing > li {width:50% !important;}
	}
	@media (max-width:1150px){
		.proposal-listing > li {width:50% !important;}
	}
	@media (max-width:769px){
		.mytitle {padding:20px 10px 10px 10px;}
		.mytitle h1 {font-size:20px !important; margin-bottom:10px !important;}
		ul.mytop-nav-filter li, ul.mytop-nav-filter li button {display:block; width:100%; text-align:left;}
		ul.mytop-nav li, ul.mytop-nav li a, ul.mytop-nav li button {display:block; width:100%; text-align:left;}
		.white-box {padding:10px;}
		.form-material .form-control, .form-material .form-control.focus, .form-material .form-control:focus {border:solid 1px #ccc; padding:0 5px;}
		.form-bg {padding: 7px;}
		.basic-details .form-group {margin-bottom: 7px;}
		.pas-updt {margin-top:0; float:right;}
		.box {padding: 15px;}
		.proposal-listing .box .name {width:100%; font-size:24px;}
		.myproposal-listing .box .cscore {width:100%; padding:5px 0;}
		.myproposal-listing .box .cscore span {width: 50%; float: inherit;}
		.lefttime {position:relative; top: 0;}
		.lefttime p {position:relative; font-size:12px;}
		.myproposal-listing .box .count {position: relative; padding-bottom:10px;}
		.myproposal-listing .box .count span {display: inline-block;}
		.myproposal-listing .loan .amount {margin-right: 0; margin-bottom: 10px;}
		.rateinfo {top:0;}
		.fund-grph {width:100%;}
		.forbidnow {position: relative; bottom:0;}
		.forbidnow .btn-success.btn-outline {background-color: #00adef;}
		.btn-details {padding:9px 5px; font-size: 9px;}
		.proposal-listing .actions ul li {padding-right: 2px;}
		.btn {padding: 3px 12px; font-size:12px;}
		.prof-pic {margin-right:0;}
		.light-logo {max-width: 150px !important;}
		.profile-username {font-size: 18px; margin-top: 10px !important;}
		#update_lender_image p {margin: 0;}
		.box-profile p {margin: 0;}
		.browse-btn .table {margin-bottom: 0;}
		body:not(.sf-close) .side-fixed {width:100%; padding-right:53px;}
		body:not(.sf-close) .side-fixed-btn {margin-left:auto; right:0; display:block;}
		.proposal-listing {padding:10px !important;}
		.proposal-listing > li {width:100% !important;}
		.proposal-listing > li > div {margin: 0px 10px 30px 10px !important;}
		body.sf-close .side-fluid {margin-left:20px;}
		#profile {top: 0px !important; width:120px!important; height:120px!important;}
		#update_image {margin-top: 40px!important;}
		.modal-profile-pic {height: 120px!important;}
	}
	.box.fade-div {	pointer-events: none; opacity: 0.4;}
	.btn-success, .btn-success.disabled {padding: 5px 15px; margin-top: 5px;}
	.btn-shortlist {margin-right: 5px; margin-top: 5px;}
	.bid_now{font-size: 11px; padding: 7px 7px; width:100%;}
	.bidnow-form .col-md-3, .bidnow-form .col-md-2 {padding-left: 0px;}
	.bidnow-form .form-control{padding: 6px 6px;}

	.dropdown-submenu {position:relative;}
	.dropdown-submenu>.dropdown-menu {top:0; left:100%; margin-top:-6px;}

	/*List Type Design*/
	.box-list li {display:block;}
	.box-list>li {width: 100% !important;}
	.box-list .box .cscore span {width: inherit; display: inline-block; float: none;}
	.box-list .box .count {padding-right: 25px;}
	.box-list .box .count span {display: inline-block;}
	.box-list .box .rateinfo {right: 0; top:0;}
	.box-list .desc ul li {border-right: 1px solid #ccc; padding:0 7px; display: inline-block;}
	.box-list .desc ul li:last-child {border-right: none;}
	.box-list .loan .amount {width:auto; min-width:220px;}
	.box-list .loan .amount br {display:none;}
	.box-list > li > div {margin-right: 0;}


</style>
	<div class="container">
		<div class="white-box">
			<ul id="proposal_list_ul" class="proposal-listing myproposal-listing">
				<?php foreach ($proposal_list AS $proposal) { ?>
					<li class="column">
						<div class="box" <?php if ($proposal['time_left'] < 0) {
							echo 'style="pointer-events: none; background-color: #e7dfdf;"';
						} ?>>
							<div class="title">
								<div class="name"><?php $fname = explode(' ', $proposal['name']);
									echo ucfirst(strtolower($fname[0])); ?>
									<div class="borrower-id text-left">
										<span>Borrower ID:</span><?php echo $proposal['b_borrower_id'] ?>
									</div>
									<ul class="prs-n-dtls">
										<li><?php echo $proposal['age'] ?></li>
										<li><?php if ($proposal['gender'] == 1) {
												echo "Male";
											}
											if ($proposal['gender'] == 2) {
												echo "Female";
											} ?>
										</li>
										<li><?php echo $proposal['r_city']; ?></li>
									</ul>
								</div>
								<?php
								$experian = $this->Biddingmodel->getExperainscoere($proposal['borrower_id']);
								$userrating = $this->Biddingmodel->getUserrating($proposal['borrower_id']);
								?>
								<div class="cscore">Credit Score
									<span><?php echo $experian['experian_score'] ?></span>
								</div>
								<div class="lefttime">
									<p>Time Left :
										<span><?php if ($proposal['time_left'] < 0) echo 'expired'; else echo $proposal['time_left'] . ' Days'; ?>
                    </span>
									</p>
								</div>
								<div class="count">
									<?php if ($userrating['antworksp2p_rating'] > 0) {?>
										<i class="fa fa-question-circle rateinfo" data-html="true" data-container="body"
										   data-toggle="popover" data-placement="top" data-content="Our proprietary algorithm analyses various parameters derived from customers credit records, KYC and Banking Details such as leverage ratio, credit utilization, outstanding amount, delinquencies etc. It then assigns weightage to each parameters based on reliability of information and independent verifiability of the data and judge the overall profile and rate it on a scale of 1-10 points. Higher the rating, stronger is the borrower profile.
								<div>1-3<b>Very High</b></div><div>4-7<b>Moderate</b></div><div>8-10<b>Very Low</b></div>">
										</i>
									<? } ?>
									<span>Antworks Rating</span><?php if ($userrating['antworksp2p_rating'] == 0) {
										echo "N/A";
									} else { ?>(<? echo round($userrating['antworksp2p_rating'], 1, PHP_ROUND_HALF_UP) . "/10)";
									} ?>
								</div>
							</div>
							<div class="purpose-loan"><span>Loan Purpose:</span><?= $proposal['loan_purpose'] ?></div>

							<div class="loan">
								<div class="amount">
									<span>Loan Required</span>Rs. <?php echo $proposal['loan_amount'] ?>
								</div>
								<div class="amount fund-grph">
							<span class="pie"
								  data-peity="{ &quot;fill&quot;: [&quot;#99d683&quot;, &quot;#f2f2f2&quot;]}"
								  style="display: none;"><?php echo $proposal['total_bid_amount']; ?>,<?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?></span>
									<p><?php echo round(($proposal['total_bid_amount'] * 100) / $proposal['loan_amount'], 2); ?>
										% Funded
										<br>
										<i class="fa fa-inr"
										   aria-hidden="true"></i> <?php echo $proposal['loan_amount'] - $proposal['total_bid_amount'] ?>
										Needed
									</p>
								</div>
								<a href="<?=base_url('login/user-login')?>" class="btn btn-details btn-success">Details</a>
							</div>

							<div class="desc">
								<ul>
									<li>
										<b>Borrower Interest Prefrence (%)</b> - <?php echo $proposal['min_interest_rate'] ?> %
									</li>
									<li>
										<b>Recommended Interest (%)</b> - <?php echo $proposal['prefered_interest_min'] ?>
										-<?php echo $proposal['prefered_interest_max'] ?> %
									</li>
									<li>
										<b>Tenor</b> - <?php echo $proposal['tenor_months'] ?> months
									</li>
									<!--li><b>Purpose</b> - Appliance Purchase</li-->
									<li>
										<b>Monthly Income</b>
										-<?php echo $proposal['occuption_details']['net_monthly_income'] ?>
									</li>
									<li>
										<b>Current EMI's</b> - <?php echo $proposal['occuption_details']['current_emis'] ?>
									</li>
								</ul>
							</div>
							<div class="actions">
								<div class="bidnow-form">
									<div class="row">
										<div class="col-md-4">
											<label>Amount</label>
											<input type="text" placeholder="Enter Amount" name="loan_amount"
												   id="loan_amount_<?php echo $proposal['proposal_id'] ?>"
												   class="form-control <? if ($proposal['p2p_product_id'] == 2) {
													   echo "consumer_loan_bid_loan_amount";
												   } else {
													   echo "bid_loan_amount";
												   } ?>"
												   onkeypress="return isNumberKey(event)" <? if ($proposal['p2p_product_id'] == 2) {
												echo "value = '" . $proposal['loan_amount'] . "'";
												echo 'readonly';
											} ?>>
											<span id="error_loan_amount_<?php echo $proposal['proposal_id'] ?>"
												  class="error-validation">
                            </span>
										</div>
										<div class="col-md-3">
											<label>Interest Rate</label>
											<select class="form-control" name="interest_rate"
													id="interest_rate_<?php echo $proposal['proposal_id'] ?>" <? if ($proposal['p2p_product_id'] == 2) {
												echo "disabled";
											} ?>>
												<option value="">Interest Rate</option>
												<?php for ($i = 12; $i <= 36; $i += 3) { ?>
													<option
															value="<?= $i; ?>" <? if ($proposal['p2p_product_id'] == 2 && $i == 18) {
														echo "selected";
													} ?>><?= $i; ?>%
													</option>
												<?php } ?>
											</select>
											<span id="error_interest_rate_<?php echo $proposal['proposal_id'] ?>"
												  class="error-validation"></span>
										</div>
										<div class="col-md-3">
											<label>Tenor</label>
											<select class="form-control" name="accepted_tenor"
													id="accepted_tenor_<?php echo $proposal['proposal_id'] ?>" <? if ($proposal['p2p_product_id'] == 2) {
												echo "disabled";
											} ?>>
												<option value="">Tenor</option>
												<?php for ($j = 6; $j <= 36; $j += 3) { ?>
													<option
															value="<?= $j; ?>" <? if ($proposal['p2p_product_id'] == 2 && $j == 6) {
														echo "selected";
													} ?>><?= $j; ?> Months
													</option>
												<?php } ?>
											</select>
											<span id="error_accepted_tenor_<?php echo $proposal['proposal_id'] ?>"
												  class="error-validation">
                        </span>
										</div>
										<div class="col-md-2">
											<label></label>
											<input type="hidden" name="proposal_id"
												   id="proposal_id_<?php echo $proposal['proposal_id'] ?>"
												   value="<?php echo $proposal['proposal_id'] ?>">
											<input type="hidden" name="loan_required"
												   id="loan_required_<?php echo $proposal['proposal_id'] ?>"
												   value="<?php echo $proposal['loan_amount'] ?>">
											<input type="hidden" name="p2p_product_id"
												   id="p2p_product_id<?php echo $proposal['proposal_id'] ?>"
												   value="<?php echo $proposal['p2p_product_id'] ?>">
											<a href="<?=base_url('login/user-login')?>"> <input type="submit" name="bid_now" id="bid_now" value="Bid Now"
												   class="btn btn-primary bid_now"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
				<? } ?>
			</ul>
			<?php echo $pagination; ?>
		</div>
  </div>

<script>
$(document).ready(function(){
    if ($(window).width() < 1150) {
        $("body").addClass('sf-close');
    } else { 
		$("body").removeClass('sf-close');
	}
});
$(window).resize(function () {
        if ($(window).width() < 1150) {
            $("body").addClass('sf-close');
        } else { 
		$("body").removeClass('sf-close');
	}
});
</script>
<script>
$(document).ready(function(){
    $(".side-fixed-btn").click(function(){
        $("body").addClass('sf-close');
        //$(".side-fixed").css("width", "0px");
		//$(".side-fluid").css("margin-left", "25px");
		//$(".side-fixed-btn-active").css("margin-left", "7px");
		//$(this).css("margin-left", "7px");
		//$(this).hide();
		//$(".side-fixed-btn-active").show();
    });
	$(".side-fixed-btn-active").click(function(){
        $("body").removeClass('sf-close');
		//$(".side-fixed").css("width", "340px");
		//$(".side-fluid").css("margin-left", "340px");
		//$(".side-fixed-btn").css("margin-left", "330px");
		//$(this).css("margin-left", "330px");
		//$(this).hide();
		//$(".side-fixed-btn").show();
    });
});
</script>
<script>
$(window).load(function() {
	$('li').removeClass('active1');
	$('.bidding div').removeClass('collapse');
	$('.proposal-list').addClass('sidebarmenu-active');
	$('.bidding').addClass('sidebarmenu-panel-active');
});

function submit_form(ii,sid)
{
	$.ajax({
	type:"POST",
	url: "<?=base_url();?>bidding/proposal_listing_shortlist/",
	data:"sid="+sid,
	success: function(result){
		$("#short-ajax-id"+ii).html('<button class="btn btn-block btn-primary">Shortlisted</button>');
	}});
}

function total_amount(ii,amt)
{
	var amt_per = $("#loan_amount"+ii).val();
	var total_pay = (amt*amt_per/100);
	
	$("#amt-rs"+ii).html("Amount = "+total_pay+"in Lacs");
	$("#amt-rs"+ii).show();
}
</script>

<script>
	$(document).ready(function(){
		$("#loan_amount").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					// Allow: Ctrl+A, Command+A
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
					// Allow: home, end, left, right, down, up
				(e.keyCode >= 35 && e.keyCode <= 40)) {
				// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
		$("#proposel-submit-data").submit(function(){
          var remainingAmount = '<?php echo $remaining_amount;  ?>';
          var loan_amount = $("#loan_amount").val();
			if(loan_amount == "")
			{
				$("#error_amount_max").html('<p style="color: red">* Required</p>');
				return false;
			}
			if(loan_amount > 50000)
			{
				$("#error_amount_max").html('<p style="color: red">Loaning Amount : Maximum 50000</p>');
				return false;
			}


			else{
				return true;
			}
		});

	});
</script>
<script src="https://www.jqueryscript.net/demo/Pie-Donut-Chart-SVG-jChart/src/js/jchart.js?v3"></script>
<script>
    let jchart1;
    $(function () {
        jchart1 = $("#element3").jChart({
            data: [
                {
                    value: 150,
                    color: {
                        normal: '#607eac',
                        active: '#333',
                    },
                },
                {
                    value: 10,
                    color: {
                        normal: '#ff9e16',
                        active: '#333',
                    },
                },
                {
                    value: 20,
                    color: {
                        normal: '#fdc634',
                        active: '#333',
                    },
                },
                {
                    value: 30,
                    color: {
                        normal: '#f7e62d',
                        active: '#333',
                    },
                },
                {
                    value: 60,
                    color: {
                        normal: '#90db24',
                        active: '#333',
                    },
                },
                {
                    value: 90,
                    color: {
                        normal: '#74b23e',
                        active: '#333',
                    },
                },

                {
                    value: 200,
                    color: {
                        normal: '#77cbe0',
                        active: '#333',
                    },
                    draw: true, //false
                    push: true, //false
                },
            ],
            appearance: {
                type: 'pie',
                baseColor: '#ddd',
            }

        });

    });
</script>
