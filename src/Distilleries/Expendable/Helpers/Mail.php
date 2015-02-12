<?php


namespace Distilleries\Expendable\Helpers;

use Illuminate\Config\Repository;
use Illuminate\Mail\Mailer;
use Swift_Mailer;
use \StringView;
use Distilleries\Expendable\Contracts\MailModelContract;
use Illuminate\View\Factory;
use Illuminate\Events\Dispatcher;


class Mail extends Mailer {

    protected $model;
    protected $config;
    protected $override;

    public function __construct(MailModelContract $model, Repository $config, Factory $views, Swift_Mailer $swift, Dispatcher $events = null)
    {
        $this->model  = $model;
        $this->config = $config;
        parent::__construct($views, $swift, $events);

    }

    protected function getView($view, $data)
    {
        $body            = $this->model->getTemplate($view);
        $data['subject'] = $this->model->getSubject();


        $body = StringView::make(
            array(
                'template'   => $body,
                'cache_key'  => uniqid(),
                'updated_at' => 0
            ),
            $data
        );

        $data['body_mail'] = $body;
        $config = $this->config->get('expendable::mail');
        return $this->views->make($config['template'], $data)->render();
    }

    public function send($view, array $data, $callback)
    {

        // First we need to parse the view, which could either be a string or an array
        // containing both an HTML and plain text versions of the view which should
        // be used when sending an e-mail. We will extract both of them out here.
        list($view, $plain) = $this->parseView($view);

        $this->model = $this->model->initByTemplate($view);

        $data['message'] = $message = $this->createMessage();

        $this->callMessageBuilder($callback, $message);

        // Once we have retrieved the view content for the e-mail we will set the body
        // of this message using the HTML type, which will provide a simple wrapper
        // to creating view based emails that are able to receive arrays of data.
        $this->addContent($message, $view, $this->model->getPlain(), $data);
        $this->addSubject($message);
        $this->addBcc($message);
        $this->addCc($message);
        $this->overideTo($message);

        $message = $message->getSwiftMessage();

        $this->sendSwiftMessage($message);

    }


    public function addCc($message)
    {

        $cc = ($this->isOveride()) ? $this->override['cc'] : $this->model->getCc();

        if (!empty($cc))
        {
            $message->setCc($cc);
        }

    }

    public function addBcc($message)
    {
        $bcc = ($this->isOveride()) ? $this->override['bcc'] : $this->model->getBcc();

        if (!empty($bcc))
        {
            $message->setBcc($bcc);
        }

    }

    public function addSubject($message)
    {
        $subject = $this->model->getSubject();

        if (!empty($subject))
        {
            $message->setSubject($subject);
        }

    }

    public function isOveride()
    {
        $config = $this->config->get('expendable::mail');
        $this->override = $config['override'];

        return $this->override['enabled'];
    }

    public function overideTo($message)
    {
        $to = ($this->isOveride()) ? $this->override['to'] : '';
        if (!empty($to))
        {
            $message->setTo($to);
        }
    }
} 