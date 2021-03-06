<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<title>Online Scoring</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/index.css">

		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="//cdn.ckeditor.com/4.11.1/basic/ckeditor.js"></script>
		<script src="assets/js/index.js"></script>
	</head>
	<body>
		<div class="container">
			<div id="head" class="row">
				<div id="logo" class="col">
					<img src="assets/img/logo.png" alt="logo">
				</div>
				<div class="col">&nbsp;</div>
				<div id="setting" class="col">
					<span>
						<?php
						if ($this->session->userdata('is_login'))
							echo "<a href='#'>".$this->session->userdata('nickname')."</a> | <a href='/auth/logout'>Logout</a>";
						else
							echo "<a href='/auth/signup'>Signup</a> | <a href='/auth/login'>Login</a>";
						?>
					</span>
				</div>
			</div>
			<hr>
			<div id="content" class="row">
				<div id="group" class="col-2 mainbox">
					<div class="mainbox_liner">
						<div class="mainbox_title">
							<span>Group</span>
						</div>
						<div class="mainbox_content">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search">
							  <div class="input-group-append">
							    <button class="btn btn-outline-secondary" type="button"><span class="fas fa-search"></span></button>
							  </div>
							</div>
							<div class="list">
								<ul>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 1</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo group 2</li>
								</ul>
							</div>
							<a href="/group/new"><button type="button" class="btn btn-outline-success">New Group</button></a>
						</div>
					</div>
				</div>
				<div id="problem" class="col-2 mainbox">
					<div class="mainbox_liner">
						<div class="mainbox_title">
							<span>Problem</span>
						</div>
						<div class="mainbox_content">
							<div class="list">
								<ul>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 1</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo Problem 2</li>
								</ul>
							</div>
							<a href="#"><button type="button" class="btn btn-outline-success">New Problem</button></a>
						</div>
					</div>
				</div>
				<div id="explain" class="col-5 mainbox">
					<div class="show_problem">
						<div class="mainbox_liner">
							<div class="mainbox_title">
								<span>Explain</span>
							</div>
							<div class="mainbox_content">
								<h3>Title</h2> <hr>
								<p>Question content area</p>
							</div>
						</div>
					</div>
					<div class="make_problem">
						<div class="mainbox_liner">
							<div class="mainbox_title">
								<span>Explain</span>
							</div>
							<div class="mainbox_content">
								<form method="POST" id="q_form" enctype="multipart/form-data">
									<div class="form-group">
										<input type="text" class="form-control" name="title" placeholder="Enter title">
									</div>
									<div class="form-group">
										<textarea name="content" id="q_content"></textarea>
									</div>
									<div class="form-check form-check-inline">
										<input type="radio" class="form-check-input" name="level" value="1">
										<label class="form-check-label">Very Easy</label>&nbsp;
										<input type="radio" class="form-check-input" name="level" value="2">
										<label class="form-check-label">Easy</label>&nbsp;
										<input type="radio" class="form-check-input" name="level" value="3">
										<label class="form-check-label">Normal</label>&nbsp;
										<input type="radio" class="form-check-input" name="level" value="4">
										<label class="form-check-label">Hard</label>&nbsp;
										<input type="radio" class="form-check-input" name="level" value="5">
										<label class="form-check-label">Very Hard</label>
									</div>
									<div class="form-group">
										<label for="inputfile">Input file for test</label>
										<input type="file" class="form-control-file" name="inputfiles[]" id="inputfile" multiple>
									</div>
									<div class="form-group">
										<label for="outputfile">Output file for test</label>
										<input type="file" class="form-control-file" name="outputfiles[]" id="outputfile" multiple>
									</div>
								</form>
								<a href="#"><button type="button" class="btn btn-outline-success" id="submit">Submit</button></a>
								<small class="text-muted">버튼을 누르면 작성한 내용이 초기화됩니다.</small>
							</div>
						</div>
					</div>
				</div>
				<div id="control" class="col-3 mainbox">
					<div id="upload">
						<label>&nbsp;<span class="fas fa-caret-right"></span>&nbsp;&nbsp;Upload your source code</label>
						<form method="post">
							<div class="input-group mb-3">
								<div class="custom-file">
									<input type="file" class="custom-file-input" accept=".c" name="assignment">
									<label class="custom-file-label">Choose File</label>
								</div>
								<div class="input-group-append">
									<span class="input-group-text"><span class="fas fa-upload"></span></span>
								</div>
							</div>
						</form>
					</div>
					<div id="result">
						<ol>
							<li>Compile : <span class="text-success">Success</span></li>
							<li>Run 1 : <span class="text-success">Success</span></li>
							<li>Run 2 : <span class="text-success">Success</span></li>
							<li>Run 3 : <span class="text-danger">Fail</span></li>
						</ol>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script>
		$(document).ready(function() {
			if ($("#setting > span > a:nth-child(2)").text() == "Logout") {
				// Get group list when login
				set_group();

				// Search group list
				search_group();
				
				// Reset group list when erase all word in search input text
				reset_group();
			}

			$("#problem li").click(function() {
				$(this).siblings().removeClass('selected p_select');
				$(this).addClass('selected p_select');
			});

			$("#problem .mainbox_content a button").hide();
			$("#problem .mainbox_content a button").click(function() {
				$("#explain .show_problem").hide();
				$("#explain .make_problem").show();
			});

			$("#submit").click(function() {
				var url = "/problem/make/" + $(".g_select").text().trim().replace(/ /g, "_");
				$("#q_form").attr("action", url);
				$("#q_form").submit();
			});
		});
		CKEDITOR.replace('q_content');
	</script>
</html>
