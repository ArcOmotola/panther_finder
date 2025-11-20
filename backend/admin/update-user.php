<?php
session_start();
require_once('../../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
$db = new Database();


if (isset($_POST['submit'])) {
    $user_id = $_GET['id'];
    $role =  trim(htmlspecialchars($_POST['role'], ENT_QUOTES, "UTF-8"));
    //$cover_image =  trim(htmlspecialchars($_POST['cover_image'], ENT_QUOTES, "UTF-8"));

    if ($role == "" && $user_id == '') {
        $error_message = "Required field can not be empty";
        header("Location: ../../admin/users.php?error=" . $error_message);
        exit;
    } else {
        $check_match = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $check_user_result = $db->fetch($check_match, ['id' => $user_id]);
        if (!$check_user_result) {
            $error_message = "No user found";
            header("Location: ../../admin/users.php?error=" . $error_message);
            exit;
        } else {

            //Check if Image is valid
            $role = $_POST['role'];
            $update_match = "UPDATE users SET role = :role WHERE id = :id";
            $up =  $db->execute($update_match, [
                'role' => $role,
                'id' => $user_id
            ]);

            if ($up) {
                $error_message = "user updated successfully";
                header("Location: ../../admin/users.php?success=" . $error_message);
                exit;
            } else {
                $error_message = "Failed update users";
                header("Location: ../../admin/users.php?error=" . $error_message);
                exit;
            }
        }
    }
} else {
    $error_message = "method not allowed";
    header("Location: ../../admin/users.php?error=" . $error_message);
}
