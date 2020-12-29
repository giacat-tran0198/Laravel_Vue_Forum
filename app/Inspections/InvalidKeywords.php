<?php


namespace App\Inspections;


use App\Exceptions\SpamException;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support'
    ];

    public function detect($body)
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new SpamException('Votre commentaire contient du spam.');
            }
        }
    }
}
