<?php

namespace App\Services\Spam;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,

    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }

        return false;
    }
}