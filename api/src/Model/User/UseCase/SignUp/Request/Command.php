<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\SignUp\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank(message="Заполните имя.")
     */
    public string $firstName = '';
    /**
     * @Assert\NotBlank(message="Заполните фамилию.")
     */
    public string $lastName = '';
    /**
     * @Assert\NotBlank(message="Заполните почту.")
     * @Assert\Email(message="Неверный формат почты.")
     */
    public string $email = '';
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Пароль должен быть больше 6 символов.")
     */
    public string $password = '';
    /**
     * @Assert\NotBlank()
     */
    public string $token = '';
}
