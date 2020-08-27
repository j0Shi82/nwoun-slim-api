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
    }

    public function post_source(Request $request, Response $response)
    {
        $this->validator = new \Valitron\Validator($request->getParsedBody());
        $this->validator->rule('required', ['email', 'url']);
        $this->validator->rule('email', 'email');
        $this->validator->rule('url', 'url');
        $this->validator->rule('ascii', 'desc');
        $this->validator->rule('lengthBetween', 'email', 5, 100);
        $this->validator->rule('lengthBetween', 'url', 10, 200);
        $this->validator->rules(['lengthBetween' => ['desc', 20, 1000]]);

        $validationSuccess = $this->validator->validate();

        if ($validationSuccess) {
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
