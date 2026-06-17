<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Pendaftaran {
    private $nama;
    private $email;

    public function __construct($nama, $email) {
        $this->nama = $nama;
        $this->email = $email;
    }

    public function kirimEmailKonfirmasi() {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            
            $mail->Username   = 'sriwidiyani16@gmail.com';
            $mail->Password   = 'tveg xqvs opfs smqu';
            
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->setFrom('sriwidiyani16@gmail.com', 'Sistem Registrasi Kampus');
            $mail->addAddress($this->email, $this->nama);

            $mail->isHTML(true);
            $mail->Subject = 'Konfirmasi Pendaftaran Akun Berhasil!';
            
            $mail->Body    = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
                    <h3 style='color: #007bff;'>Halo, " . htmlspecialchars($this->nama) . "!</h3>
                    <p>Terima kasih telah melakukan registrasi pada sistem pendaftaran kami.</p>
                    <p>Akun Anda telah berhasil dibuat dan saat ini statusnya sudah aktif. Anda sudah bisa mencoba melakukan login menggunakan password yang telah Anda daftarkan.</p>
                    <br>
                    <hr style='border: 0; border-top: 1px solid #eee;'>
                    <p style='font-size: 12px; color: #888;'>Ini adalah email otomatis. Jangan membalas email ini.</p>
                </div>
            ";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Email gagal dikirim. Error PHPMailer: {$mail->ErrorInfo}";
        }
    }
}

if (isset($_POST['register'])) {
    $namaForm  = $_POST['nama'];
    $emailForm = $_POST['email'];

    $userBaru = new Pendaftaran($namaForm, $emailForm);
    
    $prosesKirim = $userBaru->kirimEmailKonfirmasi();

    if ($prosesKirim === true) {
        echo "<script>
                alert('Registrasi Sukses! Email konfirmasi telah dikirim ke $emailForm');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('$prosesKirim');
                window.location.href = 'index.php';
              </script>";
    }
} else {
    header("Location: index.php");
    exit();
}