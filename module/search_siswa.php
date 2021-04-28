<?php
    // 03022021.2 : API stable with authentication

    // Tag: 190121.2

    include '../config/connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
       

        
        $get_nis = $_POST['nis']; 

        $query_mencaridatasiswa = "SELECT COUNT(*) total_data FROM tbl_siswa WHERE nis = $get_nis";
        $execute_caridatasiswa = mysqli_query($_AUTH, $query_mencaridatasiswa);
        $get_ketersediaan_data = mysqli_fetch_assoc($execute_caridatasiswa);

        if($get_ketersediaan_data['total_data'] > 0) {

            $query_tampilkandatahasilcari = "SELECT * FROM tbl_siswa WHERE nis = $get_nis";
            $execute_tampilkandatanote = mysqli_query($_AUTH, $query_tampilkandatahasilcari);


            $response['message'] = "Data siswa dengan nis $get_nis tersedia di database, dan list berhasil ditampilkan";
            $response['code'] = 201;
            $response['status'] = true;
            $response['caridatasiswa'] = array();


            while($row = mysqli_fetch_array($execute_tampilkandatanote)) {

                $data = array();

                $data['nama_siswa'] = $row['nama_siswa'];
                $data['jenis_kelamin'] = $row['jenis_kelamin'];
                $data['alamat'] = $row['alamat'];
                $data['no_telfon'] = $row['no_telp'];
                $data['email'] = $row['email'];
                $data['tgl_terdaftar'] = $row['tgl_terdaftar'];

                array_push($response['caridatasiswa'], $data);
            }

            echo json_encode($response);
        } else {

            // Data tidak tersedia didatabase

            $response['message'] = trim("Data siswa dengan nis tidak tersedia di database");
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