<?php

namespace App\Fixtures\Provider;

class TagProvider
{
    public function randomTag(): String
    {
        $tagList = [
            'Symfony',
            'Php',
            'Framework',
            'NodeJS',
            'VueJS',
            'GitHub',
            'API Rest',
            'FrontEnd',
            'BackEnd',
            'WebDesign',
            'SQL',
            'DQL',
            'M.A.O.',
            'Sound Design',
            'Mastering',
        ];

        return $tagList[array_rand($tagList)];
    }
}