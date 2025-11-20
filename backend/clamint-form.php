<?php
session_start();
require_once('../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
//require_once('job/item-matcher.php');

$db = new Database();

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
if (isset($_POST['submit'])) {
    $item_name =  trim(filter_input(INPUT_POST, "item_name", FILTER_SANITIZE_SPECIAL_CHARS));
    $item_address =  trim(filter_input(INPUT_POST, "item_address", FILTER_SANITIZE_SPECIAL_CHARS));
    $item_phone =  trim(filter_input(INPUT_POST, "item_phone", FILTER_SANITIZE_SPECIAL_CHARS));
    $lost_time =  trim(filter_input(INPUT_POST, "lost_time", FILTER_SANITIZE_SPECIAL_CHARS));
    $lost_date =  trim(filter_input(INPUT_POST, "lost_date", FILTER_SANITIZE_SPECIAL_CHARS));
    $description =  trim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id =  trim(filter_input(INPUT_POST, "category_id", FILTER_SANITIZE_SPECIAL_CHARS));
    $color_id =  trim(filter_input(INPUT_POST, "color_id", FILTER_SANITIZE_SPECIAL_CHARS));
    $pick_up_id =  trim(filter_input(INPUT_POST, "pick_up_id", FILTER_SANITIZE_SPECIAL_CHARS));
    $images = $_FILES['images'];
    $finder_id = trim(filter_input(INPUT_POST, "finder_id", FILTER_SANITIZE_SPECIAL_CHARS));
    if ($item_name == "" || $item_address == "" || $item_phone == "" || $lost_time == "" || $lost_date == "" || $description == "") {
        $error_message = "Required fields cannot be empty";
        header("Location: ../claimant-form.php?error=" . $error_message);
        exit;
    } else {
        //check if email already exists
        try {
            $finder_report_sql = "SELECT * FROM finder_reports WHERE id = :id LIMIT 1";
            $finder_result = $db->fetch($finder_report_sql, ['id' => $finder_id]);
            if ($finder_result['user_id'] == $user_id) {
                $error_message = "Sorry, you cannot claim your own finder report";
                header("Location: ../claimant-form.php?error=" . $error_message);
                exit;
            }
            // $images_path = "uploads/";
            if (isset($_FILES['images']) && $_FILES['images']['error'] == 0) {
                $image = $_FILES['images'];
                $image_name = $image['name'];

                //upload image
                $target_dir = "../uploads/finder/";
                $target_file = $target_dir . basename($image_name);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($image["tmp_name"]);
                if ($check === false) {
                    $error_message = "File is not an image";
                    header("Location: ../claimant.php?error=" . $error_message);
                    exit;
                }

                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                    header("Location: ../claimant.php?error=" . $error_message);
                    exit;
                }
                //check if directory exists else create it
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                    $error_message = "Sorry, there was an error uploading your file";
                    header("Location: ../claimant.php?error=" . $error_message);
                    exit;
                }
                $image_path = "uploads/finder/" . $image_name;
            }

            $register_sql = "INSERT INTO claimant_reports (user_id,title,description,image,phone,category_id,color_id,visibility,lost_time,lost_date,pick_up_id) VALUES (:user_id,:title,:description,:image,:phone,:category_id,:color_id,:visibility,:lost_time,:lost_date,:pick_up_id)";
            $params = [
                'user_id' => $user_id,
                'title' => $item_name,
                'description' => $description,
                'image' => $image_path,
                'phone' => $item_phone,
                'category_id' => $category_id,
                'color_id' => $color_id,
                'visibility' => 'public',
                'lost_time' => $lost_time,
                'lost_date' => $lost_date,
                'pick_up_id' => $pick_up_id
            ];
            $insert = $db->execute($register_sql, $params);
            if (!$insert) {
                $error_message = ".";
                header("Location: ../claimant.php?error=" . $error_message);
            } else {
                $last_id = $db->lastInsertId();
                header("Location: /backend/claimant-ai-match.php?claimant_report_id=" . $last_id . "&finder_report_id=" . $finder_id);
            }
        } catch (\Throwable $th) {
            // log($th->getMessage());
            $error_message = "Submission failed,Kindly check." . $th->getMessage();
            header("Location: ../claimant.php?error=" . $error_message);
        }
    }
} else {
    $error_message = "get method not allowed";
    header("Location: ../claimant.php?error=" . $error_message);
}
