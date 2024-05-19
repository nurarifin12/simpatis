<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap nilai-nilai dari formulir
    $survey_id = $_POST['survey_id'];
    $tahun = $_POST['tahun'];
    $answers = $_POST['answer'];


    $stmt = $conn->prepare("INSERT INTO answers (survey_id, tahun, question_id, answer) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $survey_id, $tahun, $question_id, $answer);

    foreach ($answers as $question_id => $answer) {
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    header("Location: index.php?success=1");
    exit();
} else {
    header("Location: index.php");
    exit();
}
