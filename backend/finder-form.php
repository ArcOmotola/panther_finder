<?php
session_start();
require_once('../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');

$db = new Database();

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
if (isset($_POST['submit'])) {
    $item_name =  trim(filter_input(INPUT_POST, "item_name", FILTER_SANITIZE_SPECIAL_CHARS));
    $item_address =  trim(filter_input(INPUT_POST, "item_address", FILTER_SANITIZE_SPECIAL_CHARS));
    $item_phone =  trim(filter_input(INPUT_POST, "item_phone", FILTER_SANITIZE_SPECIAL_CHARS));
    $time_found =  trim(filter_input(INPUT_POST, "time_found", FILTER_SANITIZE_SPECIAL_CHARS));
    $date_found =  trim(filter_input(INPUT_POST, "date_found", FILTER_SANITIZE_SPECIAL_CHARS));
    $description =  trim(filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS));
    $visibility =  trim(filter_input(INPUT_POST, "visibility", FILTER_SANITIZE_SPECIAL_CHARS));
    $category_id =  trim(filter_input(INPUT_POST, "category_id", FILTER_SANITIZE_SPECIAL_CHARS));
    $color_id =  trim(filter_input(INPUT_POST, "color_id", FILTER_SANITIZE_SPECIAL_CHARS));
    $images = $_FILES['images'];

    if ($item_name == "" || $item_address == "" || $item_phone == "" || $time_found == "" || $description == "" || $visibility == "") {
        $error_message = "Required fields cannot be empty";
        header("Location: ../finder-form.php?error=" . $error_message);
        exit;
    } else {
        //check if email already exists
        try {


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
                    header("Location: ../finder-form.php?error=" . $error_message);
                    exit;
                }
                if (file_exists($target_file)) {
                    $error_message = "Sorry, file already exists";
                    header("Location: ../finder-form.php?error=" . $error_message);
                    exit;
                }
                if ($image['size'] > 2000000) {
                    $error_message = "Sorry, your file is too large";
                    header("Location: ../finder-form.php?error=" . $error_message);
                    exit;
                }
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed";
                    header("Location: ../finder-form.php?error=" . $error_message);
                    exit;
                }
                //check if directory exists else create it
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                if (!move_uploaded_file($image["tmp_name"], $target_file)) {
                    $error_message = "Sorry, there was an error uploading your file";
                    header("Location: ../finder-form.php?error=" . $error_message);
                    exit;
                }
                $image_path = "uploads/finder/" . $image_name;
            }

            $register_sql = "INSERT INTO finder_reports (
            user_id,title,description,image,
            phone,category_id,color_id,visibility,
            date_found,time_found) 
            VALUES (
            :user_id,:title,:description,
            :image,:phone,:category_id,:color_id,
            :visibility,:date_found,:time_found
            )";
            $params = [
                'user_id' => $user_id,
                'title' => $item_name,
                'description' => $description,
                'image' => $image_path,
                'phone' => $item_phone,
                'category_id' => $category_id,
                'color_id' => $color_id,
                'visibility' => $visibility,
                'date_found' => $date_found,
                'time_found' => $time_found
            ];
            $insert = $db->execute($register_sql, $params);
            if (!$insert) {
                $error_message = ".";
                header("Location: ../project.php?error=" . $error_message);
            } else {
                $success_message = "Submission successful";
                header("Location: ../project.php?success=" . $success_message);
            }
        } catch (\Throwable $th) {
            // log($th->getMessage());
            $error_message = "Submission failed,Kindly check." . $th->getMessage();
            header("Location: ../project.php?error=" . $error_message);
        }
    }
} else {
    $error_message = "get method not allowed";
    header("Location: ../project.php?error=" . $error_message);
}
