<?php

namespace App\PokerHand;

use App\PokerHand\PlayingCard\PlayingCard;

class PokerHand {

    /**
     * An indexed array of zero to five PlayingCard objects.
     */
    public $cards = [];

    /**
     * The base hand rank 1-10.
     */
    public $hand_rank = NULL;

    /**
     * Sets of a kind associative array
     *
     * pair: an array of pairs.
     * three: the card value of three of a kind if any.
     * four: the card value of four of a kind if any.
     */
    public $sets = [];

    /**
     * Human-readable names of hand ranks.
     */
    static public $ranks = array(
        1 => 'High Card',
        2 => 'One Pair',
        3 => 'Two Pairs',
        4 => 'Three of a Kind',
        5 => 'Straight',
        6 => 'Flush',
        7 => 'Full House',
        8 => 'Four of a Kind',
        9 => 'Straight Flush',
        10 => 'Royal Flush',
    );

    /**
     * ordinal card value order by key.
     */
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

    /**
     * HTML entities for suits.
     */
    static public $suit_chars = array(
        'S' => '&spades;',
        'H' => '&hearts;',
        'D' => '&diams;',
        'C' => '&clubs;',
    );

   
    public function addCard($card, $suit, $value) {
        if (is_array($this->cards) && count($this->cards) == 5) {
            throw new Exception('Cannot add another card to the hand.');
        }
        try {
            $this->cards[$card] = PlayingCard::createFromString($card);
        } catch (\Exception $e) {
            throw $e;
        }

        return $this;
    }
   
    public function isStraight() {
        $card_order = self::$card_order;

        if ($this->isRoyal()) {
            return true;
        }

        $straight = array_reduce($this->cards, function(&$result, $item) use ($card_order) {
            if (empty($result['cards'])) {
                $result['cards'][] = $item->value;
                $result['straight'] = true;
            } elseif ($result['straight']) {
                // Continue to go through each card if a straight is a possibility.
                $straight_continues = false;

                foreach ($result['cards'] as $card_value) {
                    // Janky fix for non-numeric card values.
                    if (!is_numeric($card_value)) {
                        $card_value = self::$card_order[$card_value];
                    }

                    if (($card_value + 1 == $item->value || $card_value - 1 == $item->value) && !in_array($item->value, $result['cards'])) {
                        // if the current card is one greater or less than a
                        // card in the straight, AND there are no sets of any thing.
                        $straight_continues = true;
                        break;
                    }
                }

                if ($straight_continues) {
                    $result['cards'][] = $item->value;
                    $result['straight'] = true;
                } else {
                    $result['straight'] = false;
                }
            }

            return $result;
        });

        return $straight['straight'];
    }

    public function isRoyal() {
        $royals = array(10, 'J', 'Q', 'K', 'A');
        $straight = [];
        foreach ($this->cards as $card) {
            if (!in_array($card->value, $royals) || in_array($card->value, $straight)) {
                return false;
            }
            $straight[] = $card->value;
        }

        return true;
    }

    public function isFlush() {
        $flush = array_reduce($this->cards, function(&$result, $item) {
            if (empty($result['suit'])) {
                $result['suit'] = $item->suit;
                $result['count'] = 1;
            } elseif (in_array($item->suit, $result)) {
                $result['count']++;
            }
            return $result;
        });

        return $flush['count'] == 5;
    }

    public function getSetsOfAKind() {
        $items = array(
            'pair' => [],
            'three' => 0,
            'four' => 0,
        );

        $values = [];
        foreach ($this->cards as $card) {
            if (!isset($values[$card->value])) {
                $values[$card->value] = 0;
            }

            $values[$card->value]++;
        }

        foreach ($values as $card_value => $kind) {
            if ($kind == 4) {
                $items['four'] = $card_value;
                break;
            } elseif ($kind == 3) {
                $items['three'] = $card_value;
            } elseif ($kind == 2) {
                $items['pair'][] = $card_value;
            }
        }
        return $items;
    }

//    public function setSets() {
//        $this->sets = $this->getSetsOfAKind();
//        return $this;
//    }

    public function getHighCard(array $cards) {
        $suit_rank = array_flip(array_keys(self::$suit_chars));
        $ranks = self::$card_order;

        return array_reduce($cards, function(&$result, $item) use ($suit_rank, $ranks) {
            if (empty($result) || $ranks[$item->value] > $ranks[$result->value] || $ranks[$item->value] == $ranks[$result->value] && $suit_rank[$item->suit] < $suit_rank[$result->suit] ) {
                $result = $item;
            }
            return $result;
        });
    }

    public function getScoringCards() {
        if (!isset($this->hand_rank) || !isset($this->sets)) {
            throw new \Exception('Hand must be ranked to use this method.');
        }

        if (in_array($this->hand_rank, array(1, 5, 6, 7, 9, 10))) {
            return $this->cards;
        }

        $set = $this->sets['pair'];

        if ($this->sets['four']) {//quads
            $set = array($this->sets['four']);
        } elseif ($this->sets['three']) {
            $set = array($this->sets['three']);
        }
        
        return array_reduce($this->cards, function(&$result, $item) use ($set) {
            if ($item->value == $set[0] || (isset($set[1]) && $item->value == $set[1])) {
                $result[$item->card] = $item;
            }
            return $result;
        });
    }

    public function setRank() {
        $this->sets = $this->getSetsOfAKind();
        if ($this->isRoyal() && $this->isFlush()) {
            $this->hand_rank = 10;
        } elseif ($this->isFlush() && $this->isStraight()) {
            $this->hand_rank = 9;
        } else {
            if ($this->sets['four']) {
                $this->hand_rank = 8;
            } elseif ($this->sets['three'] && count($this->sets['pair']) > 0) {
                $this->hand_rank = 7;
            } elseif ($this->isFlush()) {
                $this->hand_rank = 6;
            } elseif ($this->isStraight()) {
                $this->hand_rank = 5;
            } elseif ($this->sets['three']) {
                $this->hand_rank = 4;
            } elseif (count($this->sets['pair']) > 1) {
                $this->hand_rank = 3;
            } elseif (count($this->sets['pair']) > 0) {
                $this->hand_rank = 2;
            } else {
                $this->hand_rank = 1;
            }
        }
        return $this;
    }
}
