<?php

namespace Netcast\Urest\MainBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Ivan1986\LoginzaBundle\DependencyInjection\Security\LoginzaToken;

class AuthHandler implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /**
     * Current router
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * Constructor
     *
     * @param RouterInterface $router
     * @param TranslatorInterface $translator
     * @param UserManagerInterface $userManager
     * @param SessionInterface $session
     */
    public function __construct(RouterInterface $router, TranslatorInterface $translator, UserManagerInterface $userManager, SessionInterface $session)
    {
        $this->router      = $router;
        $this->translator  = $translator;
        $this->userManager = $userManager;
        $this->session     = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($exception instanceof Exception\LoginzaExcetpion) {
            return new Response('<script>
                window.parent.$(".modal:visible").find(".errorReg").remove();
                window.parent.$(".modal:visible")
                    .find(".box-social")
                    .append(\'<div class="errorReg" style="color: red">' . $exception->getMessageKey() . '</div>\')
                ;
            </script>');
        }

        $result = array(
            'success' => false,
            'error'   => $exception->getMessage(),
        );
        return new JsonResponse($result);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($token instanceof LoginzaToken) {
            return new Response('<script>
                window.parent.$(".modal:visible").modal("toggle");
                window.parent.$("li.user-bar.hidden-sm.hidden-xs > span").remove();
                window.parent.$("li.user-bar.hidden-sm.hidden-xs").append(
                    \'<span><a href="' . $this->router->generate('netcast_urest_profile_view') . '">' . $token->getUser()->getUsername() . ', здравствуйте</a></span>\' +
                    \' <span>|</span> \' +
                    \'<span><a href="' . $this->router->generate('sonata_user_security_logout') . '">Выйти</a></span>\'
                );
            </script>');
        }

        $result = array(
            'success' => true,
            'profile' => $this->router->generate('netcast_urest_profile_view'),
            'logout'  => $this->router->generate('sonata_user_security_logout'),
            'name'    => $token->getUser()->getUsername(),
        );

        return new JsonResponse($result);
    }
}