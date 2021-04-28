<?php
    // 03022021.2 : API stable with authentication

    // Tag: 190121.2

    include '../config/connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
       
      
        $get_nis = $_POST['nis'];
        $set_namalengkap = $_POST['nama_siswa'];
        $set_jeniskelamin = $_POST['jenis_kelamin'];
        $set_alamat = $_POST['alamat'];
        $set_notelp = $_POST['no_telp'];
        $email = $_POST['email'];

        $query_updatenote = "UPDATE tbl_siswa
            SET nama_siswa = '$set_namalengkap', jenis_kelamin = '$set_jeniskelamin', alamat = '$set_alamat', no_telp = '$set_notelp', email= '$email'
            WHERE nis = $get_nis";
        $execute_updatenote = mysqli_query($_AUTH, $query_updatenote);

        if($execute_updatenote) {
            $query_tampilkandatayangbarudiupdate = "SELECT * FROM tbl_siswa WHERE nis = '$get_nis'";
            $execute_tampilkandatalatestupdatenote = mysqli_query($_AUTH, $query_tampilkandatayangbarudiupdate);

                // Untuk menampilkan informasi
            $response['message'] = "Data siswa dengan nis $get_nis berhasil diupdate, dan list berhasil ditampilkan";
            $response['code'] = 201;
            $response['status'] = true;
            $response['dataupadated'] = array();

            while($row = mysqli_fetch_array($execute_tampilkandatalatestupdatenote)) {

                $data = array();

                $data['nis'] = $row['nis'];
                $data['nama_lengkap'] = $row['nama_siswa'];
                $data['jenis_kelamin'] = $row['jenis_kelamin'];
                $data['alamat'] = $row['alamat'];
                $data['no_telfon'] = $row['no_telp'];
                $data['email'] = $row['email'];
                $data['tgl_terdaftar'] = $row['tgl_terdaftar'];


                array_push($response['dataupadated'], $data);
            }

            echo json_encode($response);
        }else{
            $response["message"] = trim("Oops! Sory, Data gagal di update!, periksa lagi fieldnya.");
            $response["code"] = 400;
            $response["status"] = false;

            echo json_encode($response);

        }

       

    } else {
        $response["message"] = trim("Oops! Sory, Request API ini membutuhkan parameter!.");
        $response["code"] = 400;
        $response["status"] = false;

        echo json_encode($response);
    }

?>