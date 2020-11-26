<?php

namespace App\Action\User;

use App\Domain\User\Service\UserCreator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

final class UserCreateAction
{
    private $userCreator;

    public function __construct(UserCreator $userCreator)
    {
        $this->userCreator = $userCreator;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $errors = [];

        $token = $this->generateRandomString(60);
        $data = (array)$request->getParsedBody();
        $data = array_merge($data, array('token' => $token));        
        $result = $this->userCreator->createUser($data);
        if ($result['success']) {
            $this->sendMail($data, $token);
        }

        $response->getBody()->write((string)json_encode($result));
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withStatus(200);
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function sendMail($user, $token) {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = false;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = $_ENV['EMAIL_ADDRESS'];                     // SMTP username
            $mail->Password   = $_ENV['EMAIL_PASSWORD'];                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('no-reply@ccpractice.com', 'Mailer');
            $mail->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);     // Add a recipient

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Verify Email CodeChef Practice';
            $mail->Body    = '<a href="'.$_ENV['CCPP_URL'].'/api/user/verify?token='.$token.'">Verify</a>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}