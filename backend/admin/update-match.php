<?php
session_start();
require_once('../../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
$db = new Database();

if (isset($_POST['submit'])) {
    $match_id = $_GET['id'];
    $match_status =  trim(htmlspecialchars($_POST['match_status'], ENT_QUOTES, "UTF-8"));
    //$cover_image =  trim(htmlspecialchars($_POST['cover_image'], ENT_QUOTES, "UTF-8"));

    if ($match_status == "" && $match_id == '') {
        $error_message = "Required field can not be empty";
        header("Location: ../../admin/match-edit.php?error=" . $error_message);
        exit;
    } else {
        $check_match = "SELECT * FROM finder_claimants WHERE id = :id";
        $check_match_result = $db->fetch($check_match, ['id' => $match_id]);
        if (!$check_match_result) {
            $error_message = "No match found";
            header("Location: ../../admin/match-report.php?error=" . $error_message);
            exit;
        } else {

            //Check if Image is valid
            if ($match_status == "approved") {
                $pick_up = $_POST['pick_up_locations'];
                $smart_pin = rand(1000, 9999);
                $admin_comment = $_POST['admin_comment'];
                $update_match = "UPDATE finder_claimants SET match_status = :match_status, pick_up_locations = :pick_up_locations, smart_pin = :smart_pin, admin_comment = :admin_comment WHERE id = :id";
                $up =  $db->execute($update_match, [
                    'match_status' => $match_status,
                    'pick_up_locations' => $pick_up,
                    'smart_pin' => $smart_pin,
                    'admin_comment' => $admin_comment,
                    'id' => $match_id
                ]);
                //Update Claimant Report
                $update_claimant = "UPDATE claimant_reports SET status = :status WHERE id = :id";
                $up =  $db->execute($update_claimant, ['status' => "delivered", 'id' => $check_match_result['claimant_report_id']]);

                //Update Finder Report
                $update_finder = "UPDATE finder_reports SET status = :status WHERE id = :id";
                $up =  $db->execute($update_finder, ['status' => "delivered", 'id' => $check_match_result['finder_report_id']]);
                if ($up) {
                    $error_message = "match updated successfully";
                    header("Location: ../../admin/match-report.php?success=" . $error_message);
                    exit;
                } else {
                    $error_message = "Failed update match";
                    header("Location: ../../admin/match-report.php?error=" . $error_message);
                    exit;
                }
            } else {
                $admin_comment = $_POST['admin_comment'];
                $update_match = "UPDATE finder_claimants SET match_status = :match_status, admin_comment = :admin_comment WHERE id = :id";
                $up =  $db->execute($update_match, [
                    'match_status' => $match_status,
                    'admin_comment' => $admin_comment,
                    'id' => $match_id
                ]);

                if ($match_status == "declined") {
                    //Update Claimant Report
                    $update_claimant = "UPDATE claimant_reports SET status = :status WHERE id = :id";
                    $up =  $db->execute($update_claimant, ['status' => "declined", 'id' => $check_match_result['claimant_report_id']]);

                    //Update Finder Report
                    $update_finder = "UPDATE finder_reports SET status = :status WHERE id = :id";
                    $up =  $db->execute($update_finder, ['status' => "declined", 'id' => $check_match_result['finder_report_id']]);
                }
                if ($up) {
                    $error_message = "match updated successfully";
                    header("Location: ../../admin/match-report.php?success=" . $error_message);
                    exit;
                } else {
                    $error_message = "Failed update match";
                    header("Location: ../../admin/match-report.php?error=" . $error_message);
                    exit;
                }
            }
        }
    }
} else {
    $error_message = "method not allowed";
    header("Location: ../../admin/match-report. ?error=" . $error_message);
}
