<?php declare(strict_types=1);

namespace App\Controller\V1\Infohub;

use \App\Controller\BaseController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use JBBCode\DefaultCodeDefinitionSet;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Infohub
{
    /**
     * @var PHPMailer\PHPMailer\PHPMailer
     */
    private $mailer;

    /**
     * @var Valitron\Validator
     */
    private $validator;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['SMTP_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['SMTP_USER'];
        $this->mailer->Password = $_ENV['SMTP_PASS'];
        $this->mailer->SMTPSecure = $_ENV['SMTP_ENC'];
        $this->mailer->Port = $_ENV['SMTP_PORT'];
    }

    public function post_source(Request $request, Response $response)
    {
        $data_ary = $request->getParsedBody();

        $this->validator = new \Valitron\Validator($data_ary);
        $this->validator->rule('required', ['url']);
        $this->validator->rule('email', 'email');
        $this->validator->rule('url', 'url');
        $this->validator->rule('ascii', 'desc');
        $this->validator->rule('lengthBetween', 'email', 5, 100);
        $this->validator->rule('lengthBetween', 'url', 10, 200);
        $this->validator->rules(['lengthBetween' => ['desc', 20, 1000]]);

        $validationSuccess = $this->validator->validate();

        if ($validationSuccess) {
            try {
                $this->mailer->setFrom($_ENV['SMTP_FROM_MAIL'], $_ENV['SMTP_FROM_NAME']);
                $this->mailer->addAddress('admin@nwo-uncensored.com', 'Admin');
                $this->mailer->addReplyTo(!empty($data_ary['email']) ? $data_ary['email'] : $_ENV['SMTP_FROM_MAIL']);

                $this->mailer->Subject = 'Form Submission: Add Source';
                $this->mailer->Body = print_r($data_ary, true);

                $this->mailer->send();
            } catch (Exception $e) {
                throw($e);
            }

            $response->getBody()->write(json_encode(['success' => $validationSuccess, 'error' => []]));
            return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
        } else {
            $response->getBody()->write(json_encode(['success' => $validationSuccess, 'error' => $this->validator->errors()]));
            return $response
            ->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('charset', 'utf-8');
        }
    }
}
