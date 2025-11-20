<?php
session_start();
require_once('../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
require_once('Job/item-matcher.php');

$db = new Database();

if (isset($_GET['claimant_report_id']) && isset($_GET['finder_report_id'])) {
    $claimant_report_id = $_GET['claimant_report_id'];
    $finder_id = $_GET['finder_report_id'];
    //Check the claimant report
    $claimant_report = 'SELECT * FROM claimant_reports WHERE id = :claimant_report_id';
    $claimant_result = $db->fetch($claimant_report, ['claimant_report_id' => $claimant_report_id]);
    $last_id = $claimant_result['id'];
    $descriptionB = $claimant_result['description'];

    //Finder report
    $finder_report = 'SELECT * FROM finder_reports WHERE id = :finder_id';
    $finder_result = $db->fetch($finder_report, ['finder_id' => $finder_id]);
    $descriptionA = $finder_result['description'];

    // 1. Get Embeddings
    //echo "Fetching embedding for Sentence A...\n";
    $embeddingA = getEmbedding($descriptionA);
    //echo "Fetching embedding for Sentence B...\n";
    $embeddingB = getEmbedding($descriptionB);

    // Check if embeddings were retrieved successfully
    if (empty($embeddingA) || empty($embeddingB)) {
        $error_message = "Could not retrieve one or both embeddings. Check API key and network connection.\n";
        header("Location: ../claimant.php?error=" . $error_message);
        exit;
    }

    $similarityScore = cosineSimilarity($embeddingA, $embeddingB);

    // 3. Convert to Percentage
    $accuracyPercentage = round($similarityScore * 100, 2);


    // $last_id = $db->lastInsertId();
    $finder_claimant_sql = "INSERT INTO finder_claimants (finder_report_id,claimant_report_id,match_percentage) VALUES (:finder_report_id,:claimant_report_id,:match_percentage)";
    $params = [
        'finder_report_id' => $finder_id,
        'claimant_report_id' => $last_id,
        'match_percentage' => $accuracyPercentage
    ];
    $insert = $db->execute($finder_claimant_sql, $params);
    if (!$insert) {
        $error_message = ".";
        header("Location: ../claimant.php?error=" . $error_message);
    } else {
        //If accuracy is greater than 70%
        if ($accuracyPercentage > 70) {
            $match_status = "approved";
            $smart_pin = rand(1000, 9999);
            $admin_comment = "Perfect Match";
            $update_match = "UPDATE finder_claimants SET match_status = :match_status, smart_pin = :smart_pin, admin_comment = :admin_comment WHERE id = :id";
            $up =  $db->execute($update_match, [
                'match_status' => $match_status,
                'smart_pin' => $smart_pin,
                'admin_comment' => $admin_comment,
                'id' => $db->lastInsertId()
            ]);

            $update_claimant = "UPDATE claimant_reports SET role = :role WHERE id = :id";
            $up =  $db->execute($update_claimant, ['role' => "delivered", 'id' => $last_id]);

            //Update Finder Report
            $update_finder = "UPDATE finder_reports SET status = :status WHERE id = :id";
            $up =  $db->execute($update_finder, ['status' => "delivered", 'id' => $finder_id]);
        }
        $success_message = "Submission successful";
        header("Location: ../claimant.php?sucess=" . $success_message);
        exit;
    }
} else {
    $error_message = "Missing required parameters";
    header("Location: ../claimant.php?error=" . $error_message);
    exit;
}
