<?php


namespace Bitsalt\Membership;

class Validator
{

    /**
     * Returns a valid email or 'false' if invalid
     * @param $email
     * @return mixed
     */
    public static function validateEmail($email)
    {
        // not well-formed?
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }


        $mailParts = explode('@', $email);
        $domain = $mailParts[1];
        // no MX record defined? domain is not valid
        if (! checkdnsrr($domain, 'MX')) {
            return false;
        }


        return $email;
    }
}
