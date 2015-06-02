<?php

namespace AppBundle\Utils;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;

class Encoder
{

    /**
     * @var \Symfony\Component\Security\Core\Encoder\EncoderFactory
     */
    private $encoderFactory;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactory $encoderFactory
     */
    public function __construct(EncoderFactory $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param UserInterface $user
     * @param string $plaintextPassword
     */
    public function setUserPassword(UserInterface $user, $plaintextPassword)
    {
        $hash = $this->encoderFactory->getEncoder($user)->encodePassword($plaintextPassword,   $user->getSalt());

        return $hash;
    }
}
