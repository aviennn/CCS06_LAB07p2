<?php

require "vendor/autoload.php";

session_start();

// 4.

use App\QuestionManager;

$score = null;
try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }
    $score = $manager->computeScore($_SESSION['answers']);
} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz</title>
</head>
<body>

<h1>Thank You</h1>

<p style="color: gray">
    You've completed the exam.
</p>

<h3>
Congratulations <?php echo $_SESSION['user_fullname']; ?>

<?php echo "(". $_SESSION[ 'user_email' ]. ")"; ?><br>

Score: <?php echo "<font color='blue'>".$score."</font>"; ?> out of <?php echo $manager->getQuestionSize() ;?> items<br>

Your Answers <br>

<?php $display = $manager->Display($_SESSION["answers"]);?> 

<p> <a href="download.php" download >Click here to download the results.</a> </p>

</h3>

</body>
</html>

<!-- DEBUG MODE -->
<pre>
<?php
var_dump($_SESSION);
?>
</pre>