<?php
    include '../config/connection.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $nis = $_POST['nis'];
        $nama_siswa = $_POST ['nama_siswa'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $no_telp = $_POST['no_telp'];
        $email = $_POST['email'];

        $id_kelas = $_POST['id_kelas'];
        $id_jurusan = $_POST['id_jurusan'];

        $cek_data = "SELECT * FROM tbl_siswa WHERE nis = '$nis'";
        $check_ifexist = mysqli_fetch_array(mysqli_query($_AUTH, $cek_data));

        if (isset($check_ifexist)) {
            $response["message"] = "Data terdeteksi ganda harap periksa kembali";
            $response["status"] = false;
            $response["code"] = 403;
            echo json_encode($response);
        }else{
            // input to tbl_siswa
            $query_input_siswa = "INSERT INTO `tbl_siswa` (`nis`, `nama_siswa`, `jenis_kelamin`, `alamat`, `no_telp`, `email`, `tgl_terdaftar`) VALUES ('$nis', '$nama_siswa', '$jenis_kelamin', '$alamat', '$no_telp', '$email', current_timestamp())";

            if(mysqli_query($_AUTH, $query_input_siswa)){
                // input to tbl_datasiswa
                $query_input_datasiswa = "INSERT INTO `tbl_datasiswa` (`id_datasiswa`, `id_kelas`, `nis`, `id_jurusan`, `tgl_tambah`) VALUES (NULL, '$id_kelas', '$nis', '$id_jurusan', current_timestamp());";
                if(mysqli_query($_AUTH, $query_input_datasiswa)){

                    $exe_input_data = mysqli_query($_AUTH, $cek_data);
                    $detaildata = mysqli_fetch_array($exe_input_data);

                    $response["message"] = "Siswa successful added";
                    $response["code"] = 201;
                    $response["status"] = true;
                    $response["tambah_data"] = [
                        "nama_siswa" => $detaildata['nama_siswa'],
                        "jenis_kelamin" => $detaildata['jenis_kelamin'],
                        "alamat"=> $detaildata['alamat'],
                        "no_telfon"=> $detaildata['no_telp'],
                        "email"=> $detaildata['email'],
                        "tgl_terdaftar"=> $detaildata['tgl_terdaftar']
                    ];
                    echo json_encode($response);
                }
            }else{
                $response["message"] = "Error please try again";
                $response["code"] = 403;
                $response["status"] = false;
                echo json_encode($response);
            }
            mysqli_close($_AUTH);
        }

    }else {
        $response["message"] = trim("Oops! Sory, Request API ini membutuhkan parameter!.");
        $response["code"] = 400;
        $response["status"] = false;
        echo json_encode($response);
    }
?>