<!DOCTYPE html>
<html lang="ko">
	<head>
		<meta charset="utf-8">
		<title>Online Scoring</title>
	</head>
    <body>
        <ul>
            <?php foreach ($problems as $problem): ?>
            <li><a href="/visual/problem/<?php echo $problem['id'] ?>"><span><?php echo $problem['id'] ?></span>&nbsp;<span><?php echo $problem['title'] ?></span></a></li>
            <?php endforeach; ?>
        </ul>
        <ul>
            <?php foreach ($problem_result as $log): ?>
            <li><?php echo $log['nickname'].": ".$log['date_try'] ?></li>
            <?php endforeach; ?>
        </ul>
        <ul>
            <?php foreach ($users as $user): ?>
            <li><a href="/visual/user/<?php echo $user['id'] ?>"><span><?php echo $user['id'] ?></span>&nbsp;<span><?php echo $user['nickname'] ?></span></a></li>
            <?php endforeach; ?>
        </ul>
        <ul>
            <?php foreach ($user_result as $log): ?>
            <li><?php echo $log['title'].": ".$log['date_try']." / ".$log['solve'] ?></li>
            <?php endforeach; ?>
        </ul>
    </body>
</html>