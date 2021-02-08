<?php


namespace App\CoreDomain;


class EmailValidator
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        // easiest mail validation, 3rd party service call can be done here
        return (bool) strpos($email, '@');
    }
}