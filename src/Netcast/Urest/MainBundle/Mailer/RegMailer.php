<?php

namespace Netcast\Urest\MainBundle\Mailer;

use FOS\UserBundle\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use FOS\UserBundle\Model\UserInterface;

class RegMailer extends Mailer
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    public function __construct($mailer, RouterInterface $router, EngineInterface $templating, array $parameters, \Doctrine\ORM\EntityManager $em)
    {
        parent::__construct($mailer, $router, $templating, $parameters);

        $this->em = $em;
    }

    public function sendConfirmationEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['confirmation.template'];
        $url      = $this->router->generate(
            'urest_user_registration_confirm',
            array('token' => $user->getConfirmationToken()),
            true
        );

        $content = $this->templating->render($template, array(
            'subject'         => 'Добро пожаловать',
            'user'            => $user,
            'confirmationUrl' => $url,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('Добро пожаловать')
            ->setFrom($this->parameters['from_email']['confirmation'])
            ->setTo($user->getEmail())
            ->addPart($content, 'text/html')
        ;
        $this->mailer->send($message);
    }

    public function sendResettingEmailMessage(UserInterface $user)
    {
        $template = $this->parameters['resetting.template'];
        $url      = $this->router->generate(
            'fos_user_resetting_reset',
            array('token' => $user->getConfirmationToken()),
            true
        );
        $rendered = $this->templating->render($template, array(
            'user'            => $user,
            'confirmationUrl' => $url
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('Воостановление пароля')
            ->setFrom($this->parameters['from_email']['confirmation'])
            ->setTo($user->getEmail())
            ->addPart($rendered, 'text/html')
        ;
        $this->mailer->send($message);
    }

    public function sendLoginzaSuccess(UserInterface $user, $plainPassword)
    {
        $rendered = $this->templating->render('NetcastUrestMainBundle:User:loginza.success.email.html.twig', array(
            'user'     => $user,
            'password' => $plainPassword,
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('Регистрация')
            ->setFrom($this->parameters['from_email']['confirmation'])
            ->setTo($user->getEmail())
            ->addPart($rendered, 'text/html')
        ;
        $this->mailer->send($message);
    }
}