<?php
    // 03022021.2 : API stable with authentication

    // Tag: 190121.2

    include '../config/connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        $nis = $_POST['nis']; 

        $query_delete_siswa = "DELETE FROM tbl_siswa WHERE nis = '$nis'";

        if (mysqli_query($_AUTH, $query_delete_siswa)) {

            $response['message'] = "Data siswa dengan nis berhasil dihapus dari database";
            $response['code'] = 200;
            $response['status'] = true;

            echo json_encode($response);
        }else {
            $response['message'] = "Data siswa dengan nis $nis gagal terhapus dari database, karna data tidak tersedia";
            $response['code'] = 404;
            $response['status'] = false;
            echo json_encode($response);
        }


    } else {
        $response["message"] = trim("Oops! Sory, Request API ini membutuhkan parameter!.");
        $response["code"] = 400;
        $response["status"] = false;

        echo json_encode($response);
    }

?>