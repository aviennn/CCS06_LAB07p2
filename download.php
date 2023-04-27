<?php

require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$score = null;
$answers = [];
$verify = [];
$show = null;

try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }

    $answers = $_SESSION['answers'];
    $score = $manager->computeScore($answers);
    $verify = $manager->verify($answers);

    $file = "results.txt";
    $filew = fopen($file, "w");

    $ans = 1;
    foreach ($verify as $answer) {
        if ($answer[1] == 1) {
            $show .= $ans . ". " . $answer[0] . " (correct) \n";
        } else {
            $show .= $ans . ". " . $answer[0] . " (incorrect) \n";
        }
        $ans++;
    }
    
    header('Content-Disposition: attachment; filename='.basename($file));
    fwrite ($filew, "Complete Name: ");
    fwrite ($filew, $_SESSION['user_fullname']."\n");
    fwrite ($filew, "Email: ");
    fwrite ($filew, $_SESSION['user_email']."\n");
    fwrite ($filew, "Birthdate: ");
    fwrite ($filew, $_SESSION['user_birthdate']."\n");
    fwrite ($filew, "Score: ");
    fwrite ($filew, $score." out of ".$manager->getQuestionSize()."\n");
    fwrite ($filew, "Answers:\n");
    fwrite ($filew, $show);
    fclose($filew);
    readfile($file);
    exit;

} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}