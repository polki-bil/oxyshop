<?php


namespace App\CoreDomain;


class PasswordValidator
{
    /**
     * @param string $plaintextPassword
     * @return bool
     */
    public function validate(string $plaintextPassword): bool
    {
        return strlen($plaintextPassword) > 5;
    }
}