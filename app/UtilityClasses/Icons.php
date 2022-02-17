<?php

namespace Bank\UtilityClasses;

class Icons
{
    public static array $allIcons = [];

    public static function getIcons()
    {
        $type = [
            'fas' => 'solid',
//            'far' => 'regular',
//            'fab' => 'brands'
        ];

        $path = base_path().'/node_modules/@fortawesome/';

        foreach ($type as $key => $value) {
            $dir = $path.'free-'.$value.'-svg-icons';
            $ls = scandir($dir);

            $i = 0;
            foreach ($ls as $file) {
                if (!stristr($file, '.d.ts')) {
                    continue;
                }

                $icon = preg_filter(
                    pattern: '/\.d\.ts$/',
                    replacement: '',
                    subject: $file);

                $upper = '/([^-])([A-Z])/';
                while (preg_match(pattern: $upper, subject: $icon) === 1) {
                    $icon = preg_replace(
                        pattern: $upper,
                        replacement: strtolower('${1}-${2}'),
                        subject: $icon);
                }
                $icon = strtolower($icon);

                $upper = '/([a-zA-Z])([0-9])/';
                while (preg_match(pattern: $upper, subject: $icon) === 1) {
                    $icon = preg_replace(
                        pattern: $upper,
                        replacement: strtolower('${1}-${2}'),
                        subject: $icon);
                }
                array_unshift(self::$allIcons, 'fa-'.$value.' '.$icon);
                $i++;
            }
        }

    }

    public static function randomIcon()
    {
        if (count(self::$allIcons) === 0) {
            self::getIcons();
        }

        return array_random(self::$allIcons, 1);
    }

}
