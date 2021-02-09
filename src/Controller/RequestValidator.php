<?php

namespace App\Controller;

class RequestValidator
{
    private const REQUIRED_FIELDS = [
        'name',
        'password',
        'email',
        'role',
    ];

    /**
     * @param string $requestData
     * @return bool
     */
    public function validateJSONData(string $requestData): bool
    {
        $decodedData = json_decode($requestData, true);

        if(!is_array($decodedData))
        {
            return false;
        }

        foreach (self::REQUIRED_FIELDS as $field)
        {
            if (!key_exists($field, $decodedData))
            {
                return false;
            }
        }

        return true;
    }
}