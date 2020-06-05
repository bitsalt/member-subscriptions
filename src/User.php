<?php


namespace Bitsalt\Membership;

class User
{
    private string $username;

    private string $email;

    private string $firstName;

    private string $lastName;

    private array $userData;

    public function addUser($userData)
    {
        // Todo: validate all data
        $this->email = Validator::validateEmail($userData['email']);

        // Reject on invalid data
        if (! $this->email) {
            return false;
            //throw new \InvalidArgumentException("User has not been added. Email is invalid.");
        }

        // for now, just storing data locally
        $this->username = $userData['username'];
        $this->email = $userData['email'];
        $this->firstName = $userData['first_name'];
        $this->lastName = $userData['last_name'];
        $this->refreshUserData();

        /**Todo: store data persistently */


        return true;
    }

    public function getUserByEmail($email)
    {
        // TODO: check against persistent data

        if (! empty($this->userData)) {
            return $this->userData;
        }

        return false;
    }

    public function getUserByUsername($username)
    {
        // TODO: check against persistent data

        if ($username == $this->userData['username']) {
            return $this->userData;
        }

        return false;
    }

    public function updateUser($data)
    {
        if (! is_array($data)) {
            return false;
        }

        foreach ($data as $key => $val) {
            if ($key == 'email') {
                if (! $this->updateEmail($val)) {
                    return false;
                }
            } else {
                $this->$key = $val;
            }
        }

        $this->refreshUserData();

        return true;
    }

    private function updateEmail($email)
    {
        if ($validEmail = Validator::validateEmail($email)) {
            $this->email = $validEmail;

            return $this->email;
        }

        return false;
    }

    private function refreshUserData(): void
    {
        $this->userData = [
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ];
    }
}
