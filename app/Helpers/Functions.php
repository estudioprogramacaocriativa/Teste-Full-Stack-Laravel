<?php

namespace App\Helpers;

abstract class Functions
{
    public static function getStatus($index, $values = [])
    {
        return $values[$index];
    }

    public static function friendlyUrl($tag, $slug = '-') {
        $string = strtolower(utf8_decode($tag));
        $ascii['a'] = range(224, 230);
        $ascii['e'] = range(232, 235);
        $ascii['i'] = range(236, 239);
        $ascii['o'] = array_merge(range(242, 246), array(240, 248));
        $ascii['u'] = range(249, 252);
        $ascii['b'] = array(223);
        $ascii['c'] = array(231);
        $ascii['d'] = array(208);
        $ascii['n'] = array(241);
        $ascii['y'] = array(253, 255);

        foreach ($ascii as $key => $item):
            $acentos = '';
            foreach ($item as $codigo)
                $acentos .= chr($codigo);
            $troca[$key] = '/[' . $acentos . ']/i';
        endforeach;

        $string = preg_replace(array_values($troca), array_keys($troca), $string);

        if ($slug):
            $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
            $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
            $string = trim($string, $slug);
        endif;

        return $string;
    }
}
