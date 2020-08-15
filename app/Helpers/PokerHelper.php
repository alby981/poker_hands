<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class PokerHelper
{
    static public $suit_html = array(
        'S' => '&spades;',
        'H' => '&hearts;',
        'D' => '&diams;',
        'C' => '&clubs;',
    );
    public static function toSuits(string $string)
    {
        $aExp = explode(" ", $string);
        $aExp=array_map(function($item) {
            
            $value = substr($item,0,1);
            if($value == 'T') {
                $value = 10;
            }
            $suit = trim(substr($item,-1));
            
            $class = '';
            if ($suit == 'D' || $suit == 'H') {
                $class = 'class="red"';
            }
            $suit = self::$suit_html[$suit];
            return html_entity_decode(trim("<div $class>" . $value . $suit . "</div>"), ENT_COMPAT, 'UTF-8');
        },$aExp);
        return implode(" ", $aExp);
    }
}