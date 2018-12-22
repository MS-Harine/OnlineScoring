<!DOCTYPE html>
<html lang="ko" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Online Scoring</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <style>
      #box {
        margin: 25vh auto;
        width: 40vw;
        border: 2px solid black;
        border-radius: 5px;
        padding: 10px;
      }
      #box span {
        float: right;
        color: red;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div id="box">
        <?php validation_errors(); ?>
        <?php if (isset($signup)) echo form_open('auth/signup'); else echo form_open('auth/login'); ?>
          <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" name="email" class="form-control" placeholder="Enter email" id="email">
          </div>

          <?php if (isset($signup))
            echo ""
              ."<div class='form-group'>"
                ."<label for='nickname'>Nickname</label>"
                ."<input type='text' name='nickname' class='form-control' placeholder='Enter nickname' id='nickname'>"
              ."</div>";
          ?>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" id="password">
          </div>
          <button type="submit" class="btn btn-outline-dark"><?php if (isset($signup)) echo "SignUp"; else echo "Login"; ?> </button>
          <span><?php if ($this->session->flashdata('errorMessage')) echo $this->session->flashdata('errorMessage'); ?></span>
        </form>
      </div>
    </div>
  </body>
</html>
