<?php


namespace App\Inspections;


use App\Exceptions\SpamException;

class KeyHeldDown
{
    public function detect($body)
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new SpamException('Votre commentaire contient du spam.');
        }
    }
}
