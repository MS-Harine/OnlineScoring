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
        <?php echo form_open('group/new'); ?>
          <div class="form-group">
            <label for="name">New Group name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter name" id="name">
          </div>
          <button type="submit" class="btn btn-outline-dark">Make</button>
        </form>
      </div>
    </div>
  </body>
</html>
