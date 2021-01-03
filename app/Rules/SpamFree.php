<?php


namespace App\Rules;


use App\Exceptions\SpamException;
use App\Inspections\Spam;

class SpamFree
{
    public function passes($attribute, $value)
    {
        try {
            return !resolve(Spam::class)->detect($value);
        } catch (SpamException $e) {
            return false;
        }
    }
}
