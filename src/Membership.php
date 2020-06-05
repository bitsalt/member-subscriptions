<?php

namespace Bitsalt\Membership;

/**
 * Class Membership This class should expose endpoints to interact with the
 * internals of the package. It acts as an interface which can be used within
 * any application.
 * @package Bitsalt\Membership
 */
class Membership
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public static function membership(): self
    {
        return new static();
    }

    public function addMember($memberData)
    {
        return $this->user->addUser($memberData);
    }

    public function getMember($data)
    {
        if ($email = Validator::validateEmail($data)) {
            return $this->user->getUserByEmail($email);
        }

        return $this->user->getUserByUsername($data);
    }

    public function updateMember($data)
    {
        return $this->user->updateUser($data);
    }
}
