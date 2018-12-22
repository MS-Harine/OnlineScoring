<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<title>Online Scoring</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="assets/css/index.css">
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
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 3</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 4</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 5</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 6</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo group 7</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 8</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 9</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 10</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 11</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo group 12</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo group 13</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 14</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 15</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo group 16</li>
								</ul>
							</div>
							<a href="/group/make"><button type="button" class="btn btn-outline-success">New Group</button></a>
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
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 3</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 4</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 5</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 6</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo Problem 7</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 8</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 9</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 10</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 11</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo Problem 12</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo Problem 13</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 14</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 15</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 16</li>
									<li><span class="fas fa-check text-success"></span>&nbsp;&nbsp;Demo Problem 17</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 18</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 19</li>
									<li><span class="fas fa-spinner"></span>&nbsp;&nbsp;Demo Problem 20</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div id="explain" class="col-5 mainbox">
					<div class="mainbox_liner">
						<div class="mainbox_title">
							<span>Explain</span>
						</div>
						<div class="mainbox_content">
							Question content area
						</div>
					</div>
				</div>
				<div id="control" class="col-3 mainbox">
					<div id="upload">
						<label>&nbsp;<span class="fas fa-caret-right"></span>&nbsp;&nbsp;Upload your source code</label>
						<div class="input-group mb-3">
						  <div class="custom-file">
						    <input type="file" class="custom-file-input">
								<label class="custom-file-label">Choose File</label>
						  </div>
						  <div class="input-group-append">
						    <span class="input-group-text"><span class="fas fa-upload"></span></span>
						  </div>
						</div>
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
</html>