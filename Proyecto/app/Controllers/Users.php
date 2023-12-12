<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\User;
use App\Models\NewsSource;

use Config\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class Users extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function insertar()
    {
        // Obtén los datos del formulario
        $cedula = $this->request->getPost('cedula');
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $email = $this->request->getPost('email');
        $contrasena = password_hash($this->request->getPost('contrasena'), PASSWORD_DEFAULT);
        $address = $this->request->getPost('address');
        $address2 = $this->request->getPost('address2');
        $country = $this->request->getPost('country');
        $city = $this->request->getPost('city');
        $zip = $this->request->getPost('zip');
        $phone = $this->request->getPost('phone');
        $rol = 1; // Por ejemplo, asignando el valor 1 como rol predeterminado

        // Instancia del modelo
        $userModel = new User();
        // Insertar datos en la base de datos
        $userModel->insertUser($cedula, $nombre, $apellido, $email, $contrasena, $address, $address2, $country, $city, $zip, $phone, $rol, 0);

        $this->sendConfirmationEmail($email, $cedula);

        return $this->response->redirect(base_url('/login'));
    }
    private function sendConfirmationEmail($to, $userId)
    {
        $subject = 'Confirmacion de cuenta';
        $message = 'Gracias por crear una cuenta. Su cuenta ha sido creada correctamente.';

        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'josuebolanos2004@gmail.com';
            $mail->Password = 'snyh rygm zkkg qnpy';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('josuebolanos2004@gmail.com', 'Nombre remitente');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Enviar correo electrónico
            $mail->send();

            // Éxito al enviar el correo
            echo 'Correo de confirmación enviado correctamente';
        } catch (Exception $e) {
            // Error al enviar el correo
            echo 'Error al enviar el correo de confirmación: ' . $mail->ErrorInfo;
        }
    }

    public function loginA()
    {
        // Recupera los datos del formulario
        $email = $this->request->getPost('email');
        $contrasena = $this->request->getPost('contrasena');

        // Instancia del modelo
        $userModel = new User();

        // Verifica las credenciales del usuario
        $user = $userModel->getUserByEmail($email);

        if ($user && password_verify($contrasena, $user['password'])) {
            // Establece la sesión
            $session = session();
            $session->set([
                'user_id' => $user['id'],
                'user_name' => $user['first_name'],
                'user_last_name' => $user['last_name'],
                'role_id' => $user['role_id']
            ]);

            // Redirige según el rol del usuario
            if ($user['role_id'] == 1) {
                // Rol Administrador, redirige a la página de administrador
                return $this->response->redirect(base_url('/categories'));
            } elseif ($user['role_id'] == 2) {
                $newsSources = new NewsSource();
                $newsS = $newsSources->getNewsSourcesByUserId($user['id']);

                if (!empty($newsS)) {
                    return $this->response->redirect(base_url('/your_unique_news'));
                }else{
                    return $this->response->redirect(base_url('/news_sources'));

                }
            }
        } else {
            return redirect()->to('/login')->with('error', 'Credenciales incorrectas');
        }
    }

    public function logoutUser()
    {
        $session = session();
        $session->destroy();
        return $this->response->redirect(base_url('/login'));
    }

    public function cambiarEstadoPerfil($userId, $estadoActual)
    {
        $userModel = new User();

        // Cambiar el estado del perfil
        $nuevoEstado = ($estadoActual == 1) ? 0 : 1;
        $userModel->cambiarEstadoPerfil($userId, $nuevoEstado);

        return $this->response->redirect(base_url('/your_unique_news'));
    }
}
