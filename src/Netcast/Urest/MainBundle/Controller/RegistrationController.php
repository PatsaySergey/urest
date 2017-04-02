<?php

namespace Netcast\Urest\MainBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RegistrationController extends Controller
{
    /**
     * @return \FOS\UserBundle\Mailer\MailerInterface
     */
    protected function getMailer()
    {
        return $this->container->get('urest.registration.mailer');
    }

    /**
     * @return \FOS\UserBundle\Util\TokenGeneratorInterface
     */
    protected function getTokenGenerator()
    {
        return $this->container->get('fos_user.util.token_generator');
    }

    public function registerAction()
    {
        $form        = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('urest.registration.form.handler');
        $process     = $formHandler->process(false);
        if ($process['status']) {
            $user = $form->getData();
            $user->setConfirmationToken($this->getTokenGenerator()->generateToken());
            $user->setEnabled(false);
            $this->getMailer()->sendConfirmationEmailMessage($user);
            $this->container->get('doctrine')->getManager()->flush();
            return new JsonResponse(array(
                'success'   => true,
                'remailUrl' => $this->container->get('router')->generate('fos_user_registration_check_email', array(
                    'email' => $form->getData()->getEmail(),
                )),
            ));
        } else {
            return new JsonResponse(array(
                'success'  => false,
                'errors'   => $process['errors'],
                'formName' => $form->getName(),
            ));
        }
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);
        $response = new RedirectResponse($this->container->get('router')->generate('netcast_urest_profile_view'));
        $this->authenticateUser($user, $response);

        return $response;
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function remailAction($email)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByEmail($email);
        if (null === $user) {
            return new JsonResponse($response['success'] = false);
        }

        $formHandler = $this->container->get('antiq.registration.form.handler');
        $response['success'] = $formHandler->reMail($user);

        return new JsonResponse($response);
    }
}
