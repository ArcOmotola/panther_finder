<?php
require_once('../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');

$db = new Database();

if (isset($_POST['submit'])) {
    $full_name =  trim(filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS));
    $email =  trim(filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS));
    $address =  trim(filter_input(INPUT_POST, "address", FILTER_SANITIZE_SPECIAL_CHARS));
    $phone =  trim(filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS));
    $country =  trim(filter_input(INPUT_POST, "country", FILTER_SANITIZE_SPECIAL_CHARS));
    $state =  trim(filter_input(INPUT_POST, "state", FILTER_SANITIZE_SPECIAL_CHARS));
    $password =  trim(filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS));
    $role =  trim(filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
        header("Location: ../register.php?error=" . $error_message);
        exit;
    } else {
        //check if email already exists
        try {
            $sql = "SELECT id,email FROM users WHERE email = :email";
            $query = $db->fetch($sql, ['email' => $email]);
            if (!empty($query)) {
                $error_message = "Email already exists,Kindly check.";
                header("Location: ../register.php?error=" . $error_message);
                exit;
            } else {
                $register_sql = "INSERT INTO users (name,email,password,phone,address,country_id,state_id,city,role) VALUES (:name,:email,:password,:phone,:address,:country_id,:state_id,:city,:role)";
                $params = [
                    'name' => $full_name,
                    'email' => $email,
                    'password' => md5($password),
                    'phone' => $phone,
                    'address' => $address,
                    'country_id' => $country,
                    'state_id' => $state,
                    'city' => '',
                    'role' => $role
                ];
                $register = $db->execute($register_sql, $params);
                if (!$register) {
                    $error_message = "Registration failed,Kindly check.";
                    header("Location: ../register.php?error=" . $error_message);
                } else {
                    $success_message = "Registration successful";
                    header("Location: ../login.php?success=" . $success_message);
                }
            }
        } catch (\Throwable $th) {
            $error_message = "Registration failed,Kindly check.";
            header("Location: ../register.php?error=" . $error_message);
        }
    }
} else {
    $error_message = "get method not allowed";
    header("Location: ../register.php?error=" . $error_message);
}
