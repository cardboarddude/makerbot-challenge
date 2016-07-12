<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/jquery-3.0.0.min.js" ></script>
    <script src="js/script.js" ></script>
</head>
<body>
<section id="header">
<h1 id="title"><?php echo Config::get('PROJECT_NAME'); ?></h1>
<ol id="main-menu">
    <li id="main-menu-index">Home</li>
    <li id="main-menu-login">Login</li>
    <li id="main-menu-register">Register</li>
</ol>
<span id="login-welcome"><?php echo LoginController::getLoginWelcome(); ?></span>
</section>
<?php echo Feedback::wrapFeedbackList(Feedback::getFeedbackList('ERR')); ?>
<?php echo Feedback::wrapFeedbackList(Feedback::getAllFeedbackList()); ?>