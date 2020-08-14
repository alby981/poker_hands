<?php

namespace App\PokerHand\PlayingCard;

/**
 * Provide methods on playing cards.
 */
class PlayingCard {

    public $card;
    public $suit;
    public $value;
    public $rank;
    static public $suits = array('S', 'H', 'D', 'C');
    static public $card_order = array(
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    );

    static public function createFromString($value = '') {
        if (empty($value)) {
            throw new \Exception('Card is empty.');
        }

        $value_length = strlen($value);

        if ($value_length < 2 || $value_length > 3) {
            throw new \Exception('Card does not have a valid string representation.');
        }

        $suit = substr($value, -1);

        $card_value = substr($value, 0, $value_length - strlen($suit));

        $card = new static();

        $card->value = $card_value;
        $card->suit = $suit;
        $card->card = $value;
        $card->rank = -1;

        return $card;
    }

    static public function compare(PlayingCard $a, PlayingCard $b) {
        $suit_rank = array_flip(self::$suits);

        if (self::$card_order[$a->value] > self::$card_order[$b->value] ||
                (self::$card_order[$a->value] == self::$card_order[$b->value] &&
                $suit_rank[$a->suit] < $suit_rank[$b->suit])) {
            return true;
        }

        return false;
    }

    static public function equal(PlayingCard $a, PlayingCard $b) {
        return self::$card_order[$a->value] == self::$card_order[$b->value];
    }

}
