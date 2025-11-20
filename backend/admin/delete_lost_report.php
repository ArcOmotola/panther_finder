<?php
require_once('../../include/config/path.php');
require_once(ROOT_PATH . 'include/function.php');
$db = new Database();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM finder_reports WHERE id = :id";
    $result = $db->execute($sql, ['id' => $id]);
    if ($result) {
        $success_message = "Data deleted successfully";
        header("Location: ../../admin/lost-report.php?success=" . $success_message);
        exit;
    }
} else {
    $php_errormsg = "ID not found";
    header("Location: ../../admin/lost-report.php?error=" . $php_errormsg);
    exit;
}
