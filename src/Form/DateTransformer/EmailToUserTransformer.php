<?php
/**
 * Created by PhpStorm.
 * User: Max
 * Date: 12.02.2019
 * Time: 12:39
 */

namespace App\Form\DateTransformer;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class EmailToUserTransformer implements DataTransformerInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var callable
     */
    private $findCallBack;

    public function __construct(UserRepository $userRepository, callable $findCallBack)
    {
        $this->userRepository = $userRepository;
        $this->findCallBack = $findCallBack;
    }

    /**
     * @param mixed User|null
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }
        if (!$value instanceof User) {
            throw new \LogicException('The UserSelectTextType can only be user with User object');
        }

        return $value->getEmail();
    }

    public function reverseTransform($value)
    {
        if (!$value) {
            return;
        }

        $callback = $this->findCallBack;
        $user = $callback($this->userRepository, $value);

        $user = $this->userRepository->findOneBy(['email' => $value]);

        if (!$user) {
            throw new TransformationFailedException(sprintf(
                'No user found with email "%s"',
                $value
            ));
        }

        return $user;
    }
}