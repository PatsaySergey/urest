<?php

namespace Netcast\Urest\MainBundle\Security;

use Doctrine\ORM\EntityRepository;
use Ivan1986\LoginzaBundle\DependencyInjection\Security\LoginzaUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\ProviderNotFoundException;
use Netcast\Urest\MainBundle\Security\Exception\EmailMustNotBeEmptyExcetpion;
use Netcast\Urest\MainBundle\Security\Exception\UserWithEmailExistsExcetpion;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginzaUserProvider extends EntityRepository implements LoginzaUserProviderInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

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

    /**
     * {@inheritdoc}
     *
     * @throws ProviderNotFoundException
     * @throws UserWithEmailExistsExcetpion
     */
    public function loadUserByIdentityAndProvider($identity, $provider, $loginzaInfo)
    {
        $user = $this->findOneBy(array(
            'identity' => $identity,
            'provider' => $provider,
        ));

        if (!$user) {
            $method = 'createUserBy' . $this->normalizeProvider($provider);
            if (!method_exists($this, $method)) {
                throw new ProviderNotFoundException();
            }
            $user = $this->$method($loginzaInfo);

            if ($this->findOneByUsername($user->getUsername())) {
                throw new UserWithEmailExistsExcetpion();
            }

            $password = $this->generatePassword();

            $this->getMailer()->sendLoginzaSuccess($user, $password);

            $user->setPlainPassword($password);
            $user->setEnabled(true);
            $user->setProvider($provider);
            $user->setIdentity($identity);

            // add default user group
            $group = $this->_em->getRepository('Application\Sonata\UserBundle\Entity\Group')
                ->findOneByName('Зарегистрированный пользователь');

            if ($group) {
                $user->addGroup($group);
            }

            $this->_em->persist($user);
            $this->_em->flush();
        }

        return $user;
    }

    /**
     * Normalize provider for call
     *
     * @param string $provider
     *
     * @return string
     */
    protected function normalizeProvider($provider)
    {
        $words = preg_split('/[^a-z]+/', $provider);

        foreach ($words as &$word) {
            $word = ucfirst($word);
        }

        return implode('', $words);
    }

    /**
     * Create user from facebook.com
     *
     * @param array $info
     *
     * @return User
     *
     * @throws EmailMustNotBeEmptyExcetpion
     */
    protected function createUserByHttpWwwFacebookCom($info)
    {
        if (!$info['email']) {
            throw new EmailMustNotBeEmptyExcetpion();
        }

        $user = new User();

        $user->setUsername($info['email']);
        $user->setEmail($info['email']);
        $user->setGender(strtolower($info['gender']));
        $user->setFirstname($info['name']['first_name']);
        $user->setLastname($info['name']['last_name']);

        return $user;
    }

    /**
     * Create user from plus.google.com
     *
     * @param array $info
     *
     * @return User
     *
     * @throws EmailMustNotBeEmptyExcetpion
     */
    protected function createUserByHttpsPlusGoogleCom($info)
    {
        if (!$info['email']) {
            throw new EmailMustNotBeEmptyExcetpion();
        }

        $password = $this->generatePassword();

        $user = new User();

        $user->setEnabled(true);
        $user->setUsername($info['email']);
        $user->setEmail($info['email']);
        $user->setGender(strtolower($info['gender']));
        $user->setPlainPassword($password);
        $user->setFirstname($info['name']['first_name']);
        $user->setLastname($info['name']['last_name']);

        return $user;
    }

    /**
     * Generate random password for user
     *
     * @param integer $length
     *
     * @return string
     */
    protected function generatePassword($length = 8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index   = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function loadUserByUsername($username)
    {
        throw new \Exception('not supported');
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'Application\Sonata\UserBundle\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByIdentityAndProvider($user->getIdentity(), $user->getProvider(), $user->getLoginzaInfo());
    }
}