<?php

require_once '../../app/config.php';
require_once '../../vendor/autoload.php';
require_once 'db_connect.php';
require_once pathurl.'/app/libs/functions.php';
include_once '../config.php';

use Respect\Validation\Validator as v;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['action'])) {
    $dt = array('dt' => $_POST);
	$data = [];
    if ($_POST['action'] == 'daftar') {
	    $vForm = v::key(
	    	'dt',
	    	v::key('name', v::notEmpty()->stringType()->alnum(' ', '.', ','))
	    	->key('username', v::notEmpty()->noWhitespace()->stringType()->alnum())
	    	->key('password', v::notEmpty()->noWhitespace()->identical($_POST['confirmPassword']))
	    	->key('email', v::notEmpty()->noWhitespace()->email())
	    )->validate($dt);

	    $name = $_POST['name'];
	    $username = $_POST['username'] . ".bcsoetta.org";
	    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	    $confirmPassword = $_POST['confirmPassword'];
	    $email = $_POST['email'];

	    $acticode = sha1(mt_rand(10000,99999).time().$email);
		$expired = date('Y-m-d', strtotime('+3 days'));
		$expiredx = date('d/m/Y', strtotime('+3 days'));

	    if (isset($_POST['terms'])) {
	    	$terms = $_POST['terms'];
	    }

	    if (!$vForm) {
	    	$data['info'] = 'Terdapat isian data yang tidak valid';
	    	echo json_encode($data);
	    	die();
	    } else {
	    	$u = mysqli_query($con, "SELECT * FROM auth WHERE username = '$username'");
	    	if (mysqli_num_rows($u) > 0) {
	    		$data['info'] = 'Username sudah digunakan, gunakan username lainnya.';
	    		echo json_encode($data);
	    		die();
	    	}
	    	$u = mysqli_query($con, "SELECT * FROM customer WHERE email = '$email'");
	    	if (mysqli_num_rows($u) > 0) {
	    		$data['info'] = 'Email sudah digunakan, gunakan email lainnya.';
	    		echo json_encode($data);
	    		die();
	    	}
            $au = mysqli_query($con, "INSERT INTO auth (`username`, `password`, `group`) VALUES ('$username', '$password', 'customer')");
            if (mysqli_affected_rows($con) > 0) {
                $uid = mysqli_query($con, "SELECT user_id FROM auth WHERE username = '$username'");
                list($user_id) = mysqli_fetch_array($uid);
                $ak = mysqli_query($con, "INSERT INTO aktivasi (user_id, code, expired) VALUES ('$user_id', '$acticode', '$expired')");
                if (mysqli_affected_rows($con) > 0) {
                    $cu = mysqli_query($con, "INSERT INTO customer (user_id, nama, email) VALUES ('$user_id', '$name', '$email')");
                    if (mysqli_affected_rows($con) > 0) {
                        $mail = new PHPMailer(true);
    					try {
    						//Server settings
    					    $mail->SMTPDebug = false;
    					    $mail->isSMTP();
    					    $mail->Host       = MAIL_HOST;
    					    $mail->SMTPAuth   = true;
    					    $mail->Username   = MAIL_USERNAME;
    					    $mail->Password   = MAIL_PASSWORD;
    					    $mail->SMTPSecure = MAIL_SECURE;
    					    $mail->Port       = MAIL_PORT;

    					    //Recipients
    					    $mail->setFrom(MAIL_USERNAME, 'bcsoetta.org');
    					    $mail->addReplyTo(MAIL_USERNAME, 'Info');

    					    // Notification
    					    $mail->addAddress(MAIL_USERNAME, 'Akun baru bcsoetta.org');

    					    $mail->isHTML(true);
    					    $mail->Subject = 'Akun baru bcsoetta.org';
    					    $mail->Body    = 'Username: ' . $username . "<br>Email: " . $email;
    					    $mail->send();

    					    $mail->ClearAddresses();

    					    // Activation link to client
    					    $mail->addAddress($email);
    					    // Content
    					    $mail->isHTML(true);
    					    $mail->Subject = 'Link aktivasi bcsoetta.org';
    					    $mail->Body    = 'Akun:<br>Username: '.$username.'<br>Password: '.$_POST['password'].'<br><br>Silahkan klik link aktivasi di bawah untuk mengaktifkan akun Anda.<br>' . baseurl . 'user/activation?code=' . $acticode . "<br>" . "Kode aktivasi akan expired pada " . $expiredx . ".";
    					    $mail->send();

    					    $data['info'] = 'Terima kasih. Pendaftaran berhasil dilakukan.<br>Silahkan klik link aktivasi yang kami kirim ke email Anda.';
    	    				echo json_encode($data);
    					} catch(Exception $e) {

    					}
                    } else {
                        // echo json_encode('g3');
                    }
                } else {
                    // echo json_encode('g2');
                }
            } else {
                // echo json_encode('g1');
            }
	    }
	}

    if ($_POST['action'] == 'activation') {
		$code = $_POST['code'];
		$expired = date('Y-m-d');
		$status = [];

        $ak = mysqli_query($con, "UPDATE aktivasi SET `status` = 'aktif' WHERE code = '$code' AND expired >= '$expired' AND `status` = 'tidak aktif'");
        if (mysqli_affected_rows($con) > 0) {
            $cc = mysqli_query($con, "SELECT user_id FROM aktivasi WHERE code = '$code'");
            list($user_id) = mysqli_fetch_array($cc);
            $au = mysqli_query($con, "UPDATE auth SET `status` = 'enabled' WHERE user_id = '$user_id'");
            if (mysqli_affected_rows($con) > 0) {
    			$status['status'] = 'Activated';
    		} else {
    			$x = mysqli_query($con, "SELECT `status`, expired FROM aktivasi WHERE code = '$code'");
    				if (mysqli_num_rows($x) > 0) {
    				while ($d = mysqli_fetch_array($x)) {
    					if ($d['status'] == 'enabled') {
    						$status['status'] = 'Account is already activated';
    					}
    					if ($d['expired'] <= $expired) {
    						$status['status'] = 'Code activation is expired';
    					}
    				}
    			} else {
    				$status['status'] = 'Code activation failed!';
    			}
    		}
        } else {
            $status['status'] = 'Activation failed!';
        }
		echo json_encode($status);
	}

    if ($_POST['action'] == 'uprofil') {
        $name = $_POST['name'];
        // $username = $_POST['username'];
        $phone = $_POST['phone'];
        $nik = $_POST['nik'];
        $perusahaan = $_POST['perusahaan'];
        $npwp = $_POST['npwp'];
        $nib = $_POST['nib'];
        $tanggal_nib = dateSys($_POST['tglnib']);
        $alamat = $_POST['alamat'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $action = $_POST['action'];

        // hidden
        $user_id = $_POST['user_id'];
        $email = $_POST['emailh'];

		$data = [];

		// username
		// if (v::stringType()->notEmpty()->alnum('.')->validate($username)) {
		// 	$q = mysqli_query($con, "UPDATE auth SET username = '$username' WHERE user_id = '$user_id'");
		// 	if (mysqli_affected_rows($con) > 0) {
		// 		if (session_status() == PHP_SESSION_NONE) {
		// 		    session_start();
		// 		}
  		//      $_SESSION['username'] = $username;
		// 		$data['usernamei'] = 'Username berhasil diupdate';
		// 	} else {
		// 		$data['usernamei'] = 'Username tidak diupdate';
		// 	}
		// }

        // nama, name
		if (v::stringType()->notEmpty()->alnum(' ', '.', ',')->validate($name)) {
			$q = mysqli_query($con, "UPDATE customer SET nama = '$name' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['namei'] = 'Nama berhasil diupdate';
			} else {
				$data['namei'] = 'Nama tidak diupdate';
			}
		}
        
        // phone
		if (v::stringType()->notEmpty()->alnum()->validate($phone)) {
			$q = mysqli_query($con, "UPDATE customer SET phone = '$phone' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['phonei'] = 'No. HP berhasil diupdate';
			} else {
				$data['phonei'] = 'No. HP tidak diupdate';
			}
		}
        
        // nik
		if (v::stringType()->notEmpty()->alnum()->validate($nik)) {
			$q = mysqli_query($con, "UPDATE customer SET nik = '$nik' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['niki'] = 'NIK berhasil diupdate';
			} else {
				$data['niki'] = 'NIK tidak diupdate';
			}
		}
        
        // perusahaan
		if (v::stringType()->notEmpty()->alnum(' ', '.', ',')->validate($perusahaan)) {
			$q = mysqli_query($con, "UPDATE customer SET perusahaan = '$perusahaan' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['perusahaani'] = 'Perusahaan berhasil diupdate';
			} else {
				$data['perusahaani'] = 'Perusahaan tidak diupdate';
			}
		}
        
        // npwp
		if (v::stringType()->notEmpty()->alnum()->validate($npwp)) {
			$q = mysqli_query($con, "UPDATE customer SET npwp = '$npwp' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['npwpi'] = 'NPWP berhasil diupdate';
			} else {
				$data['npwpi'] = 'NPWP tidak diupdate';
			}
		}
        
        // nib
		if (v::stringType()->notEmpty()->alnum()->validate($nib)) {
			$q = mysqli_query($con, "UPDATE customer SET nib = '$nib' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['npwpi'] = 'No. NIB berhasil diupdate';
			} else {
				$data['npwpi'] = 'No. NIB tidak diupdate';
			}
		}
        
        // tanggal nib
        if (v::date('Y-m-d')->validate($tanggal_nib)) {
            $q = mysqli_query($con, "UPDATE customer SET tanggal_nib = '$tanggal_nib' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['npwpi'] = 'Tanggal NIB berhasil diupdate';
			} else {
				$data['npwpi'] = 'Tanggal NIB tidak diupdate';
			}
        }
        
        // alamat
		if (v::stringType()->notEmpty()->alnum(' ', '.', ',')->validate($alamat)) {
			$q = mysqli_query($con, "UPDATE customer SET alamat = '$alamat' WHERE user_id = '$user_id'");
			if (mysqli_affected_rows($con) > 0) {
				$data['alamati'] = 'Alamat berhasil diupdate';
			} else {
				$data['alamati'] = 'Alamat tidak diupdate';
			}
		}
        
        // password
		if (v::notEmpty()->validate($password)) {
			if (v::identical($password)->validate($confirmPassword)) {
				$passx = password_hash($password, PASSWORD_DEFAULT);
				$q = mysqli_query($con, "UPDATE auth SET password = '$passx' WHERE user_id = '$user_id'");
				if (mysqli_affected_rows($con) > 0) {
					$data['passwordi'] = 'Password berhasil diupdate';
				} else {
					$data['passwordi'] = 'Password gagal diupdate';
				}
			}
		}
        
        // notifikasi ke email
		if (isset($data['passwordi']) AND $data['passwordi'] == 'Password berhasil diupdate') {
			$mail = new PHPMailer(true);
			try {
				//Server settings
				$mail->SMTPDebug = false;
				$mail->isSMTP();
				$mail->Host       = MAIL_HOST;
				$mail->SMTPAuth   = true;
				$mail->Username   = MAIL_USERNAME;
				$mail->Password   = MAIL_PASSWORD;
				$mail->SMTPSecure = MAIL_SECURE;
				$mail->Port       = MAIL_PORT;

				//Recipients
				$mail->setFrom(MAIL_USERNAME, 'bcsoetta.org');
				$mail->addReplyTo(MAIL_USERNAME, 'Info');

				// Notification
				$mail->addAddress($email, 'Ganti data akun bcsoetta.org');
				$mail->isHTML(true);
				$mail->Subject = 'Ganti data akun bcsoetta.org';
				$mail->Body    = 'Anda telah mengganti data akun sebagai berikut:<br>Password: '.$password;
				$mail->send();
			} catch(Exception $e) {

			}
		}
		echo json_encode($data);
	}
}
