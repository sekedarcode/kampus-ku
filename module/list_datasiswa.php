<?php
    include '../config/connection.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $id_kelas = $_POST['kode_kelas'];

        $cek_kelas = "SELECT * FROM tbl_datasiswa WHERE id_kelas = '$id_kelas'";
        $check_ifexist = mysqli_fetch_array(mysqli_query($_AUTH, $cek_kelas));

        if (isset($check_ifexist)) {
            //banyak siswa
            $total_siswa = "SELECT COUNT(*) 'total' FROM tbl_datasiswa WHERE id_kelas = '$id_kelas'";
            $exe_totalsiswa = mysqli_query($_AUTH, $total_siswa);
            $get_siswa = mysqli_fetch_assoc($exe_totalsiswa);

            //data kelas
            $Kelas = "SELECT * FROM tbl_kelas WHERE id_kelas = '$id_kelas'";
            $exe_kelas = mysqli_query($_AUTH,$Kelas);
            $get_kelas = mysqli_fetch_assoc($exe_kelas);

            //data pengajar
            $pengajar = "SELECT * FROM tbl_kelas
            JOIN tbl_guru ON tbl_guru.id_guru=tbl_kelas.id_guru WHERE id_kelas = '$id_kelas'";
            $exe_pengajar = mysqli_query($_AUTH, $pengajar);
            $get_pengajar = mysqli_fetch_assoc($exe_pengajar);


            //output data siswa
            $data_siswa = "SELECT tbl_siswa.nama_siswa, tbl_jurusan.jurusan, tbl_siswa.jenis_kelamin, tbl_siswa.alamat, tbl_siswa.no_telp, tbl_siswa.email, tbl_siswa.tgl_terdaftar FROM tbl_datasiswa
            JOIN tbl_siswa ON tbl_siswa.nis=tbl_datasiswa.nis
            JOIN tbl_jurusan ON tbl_jurusan.id_jurusan=tbl_datasiswa.id_jurusan
            WHERE tbl_datasiswa.id_kelas = '$id_kelas'";
            $exe_list_siswa = mysqli_query($_AUTH, $data_siswa);

            if ($get_siswa > 0) {
                $response["message"] = trim("Data berhasil ditampilkan");
                $response["code"] = 200;
                $response["total_datasiswa"] = $get_siswa['total'];
                $response["Kelas"] = $get_kelas['kelas'];
                $response["wali_kelas"] = $get_pengajar["nama_guru"];
                $response["status"] = true;
                $response["data_siswa"] = array();

                while ($row = mysqli_fetch_array($exe_list_siswa)) {
                    $data = array();
                    $data["nama_lengkap"] = $row["nama_siswa"];
                    $data["jenis_kelamin"] = $row["jenis_kelamin"];
                    $data["alamat"] = $row["alamat"];
                    $data["no_telfon"] = $row["no_telp"];
                    $data["email"] = $row["email"];
                    $data["jurusan_siswa"] = $row["jurusan"];
                    $data["tgl_terdaftar"] = $row["tgl_terdaftar"];
                    array_push($response["data_siswa"], $data);
                }
                echo json_encode($response);

            }

        }else{
            $response["message"] = "Data tidak ditemukan di dalam database";
            $response["status"] = false;
            $response["code"] = 403;
            echo json_encode($response);
        }

    }else {
    $response["message"] = trim("Oops! Sory, Request API ini membutuhkan parameter!.");
    $response["code"] = 400;
    $response["status"] = false;
    echo json_encode($response);
    }

?>