<?php require "connect.php";

use PHPMailer\PHPMailer\PHPMailer;

require_once '../PHPMailer/PHPMailer.php';
require_once '../PHPMailer/SMTP.php';
require_once '../PHPMailer/Exception.php';

$message = "";
$success = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');
    if ($_POST['role'] == 'mahasiswa') {
        if (isset($_POST['nama']) && isset($_POST['nrp'])) {

            $nama = htmlspecialchars($_POST["nama"]);
            $nrp = htmlspecialchars($_POST["nrp"]);
            $email = $nrp . "@john.petra.ac.id";

            $cek_nrp = $conn->prepare("SELECT nrp FROM rsvp WHERE nrp= :nrp");
            $cek_nrp->bindParam(':nrp', $nrp);
            $cek_nrp->execute();

            if (mb_strlen($nrp) != 9) {
                $message = 'NRP harus 9 karakter';
            } else if ($nama == NULL) {
                $message = 'Nama belum terisi';
            } else if ($nrp == NULL) {
                $message = 'NRP belum terisi';
            } else if ($cek_nrp->rowCount() > 0) {
                $message = 'NRP sudah terdaftar';
            } else {
                $sql = "INSERT INTO rsvp SET id = UUID(), nama = ?, nrp = ?, role = 0";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nama, $nrp]);
            }
        }
    } else if ($_POST['role'] == 'alumni') {
        if (isset($_POST['nama']) && isset($_POST['email'])) {

            $nama = htmlspecialchars($_POST["nama"]);
            $email = htmlspecialchars($_POST["email"]);

            $cek_email = $conn->prepare("SELECT email FROM rsvp WHERE email= :email");
            $cek_email->bindParam(':email', $email);
            $cek_email->execute();

            if (mb_strlen($email) > 64) {
                $message = 'Email terlalu panjang';
            } else if ($nama == NULL) {
                $message = 'Nama belum terisi';
            } else if ($email == NULL) {
                $message = 'Email belum terisi';
            } else if ($cek_email->rowCount() > 0) {
                $message = 'Email sudah terdaftar';
            } else {
                $sql = "INSERT INTO rsvp SET id = UUID(), nama = ?, email = ?, role = 1";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$nama, $email]);
            }
        }
    }

    if ($stmt) {
        //EMAIL
        $mail = new PHPMailer();
        $name = 'DIES NATALIS INFORMATIKA 26';
        $subject = 'RSVP DIES NATALIS INFORMATIKA 26';

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'himainfra.petra@gmail.com';
        $mail->Password = 'raxz oshg tkmo momq';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';

        //Email Setting
        $mail->isHTML(true);
        $mail->setFrom($mail->Username, $name);
        $mail->addAddress($email);
        $mail->Subject = $subject;
        $isi = '
        <body>
            <div class="wrapper"
                style="padding: 20px; height:fit-content; margin:0 auto; margin-top: 2%; min-width: 200px; width: 380px; background-color: #b4cee8; border: 2px solid black; border-radius: 10px;">
        
                <h2 style="text-align: center; font-weight: 600; color: black;">Hello, ' . $nama . '!</h2>
        
                <h3 style="text-align: center; color: black;">RSVP Anda Telah Berhasil!</h3>
        
                <div>
                    <img style="text-align: center; margin-top: 30px; width: 40px; display: block; margin-left: auto;  margin-right: auto;"
                        src="https://img.icons8.com/pastel-glyph/64/ffffff/clipboard-approve--v1.png" />
                </div>
        
                <div class="container" style="padding: 16px;">
                    <br>
                    <h4 style="text-align: center; color: black;">❗Save The Date❗</h4>
                    <p style="text-align: center; color: black;">Tanggal📅: 29 Mei 2024 <br>Tempat🏦: Auditorium W</p>
        
                    <button type="submit" style="background-color: #79a2df; color: black; border: none; cursor: pointer; width: 60%; margin: 5px auto; padding: 8px; border-radius: 50px; border: 2px solid black; display:block; text-align:center;">
                        <a href=""
                            style="color:black; text-decoration: none;" target="_blank">OA Line: @urd5942g</a>
                    </button>
                </div>
            </div>
        </body>';
        $body = $isi;
        $mail->Body = $body;

        if (!$mail->send()) {
            $message = "Email tidak terkirim";
        } else {
            $message = "RSVP Anda berhasil, silakan cek email!";
            $success = true;
        }
    } else {
        $message = "RSVP gagal, silakan coba lagi";
    }


    echo json_encode([
        'message' => $message,
        'success' => $success
    ]);
}
