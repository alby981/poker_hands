<?php

namespace App\Collection;

use App\PokerHand\PokerHand;

class PokerHandCollection {

    public $data;
    public $hands;

    function __construct($data) {
        $this->data = $data;

        foreach (array_keys($this->data) as $index) {
            $this->setHand(new PokerHand, $index);
        }
    }

    static public function createFromArray($feed, $aCards) {
        $raw = $feed->setDataFromArray($aCards);
        return new static($feed->parseData($raw));
    }

    public function getHand($index = 1) {
        return $this->hands[$index];
    }

    public function setHand(PokerHand $hand, $index = 1) {
        if (isset($this->data[$index])) {
            foreach ($this->data[$index] as $card_index => $card) {
                $hand->addCard($card['card'], $card['suit'], $card['value']);
            }

            $this->hands[$index] = $hand;
        } else {
            throw new \Exception('There is no hand at this index.');
        }

        return $this;
    }

    public function rank() {
        if (empty($this->hands)) {
            throw new \Exception('There are no hands to rank.');
        }
        foreach ($this->hands as $i => $hand) {
            $hand->setRank();
        }
        uasort($this->hands, array($this, 'compareHands'));
        return $this;
    }

    static public function compareHands(PokerHand $a, PokerHand $b) {
        if ($a->hand_rank > $b->hand_rank) {
            return -1;
        } elseif ($a->hand_rank < $b->hand_rank) {
            return 1;
        }
        $a_cards = $a->getScoringCards();
        $a_high_card = $a->getHighCard($a_cards);

        if (count($a_cards) == 5 && $a_high_card::compare($a->getHighCard($a_cards), $b->getHighCard($b->cards))) {
            return -1;
        } elseif (count($a_cards) < 5) {
            $b_cards = $b->getScoringCards();
            if (!$a_high_card::equal($a_high_card, $b->getHighCard($b_cards))) {
                if ($a_high_card::compare($a->getHighCard($a_cards), $b->getHighCard($b_cards))) {
                    return -1;
                }
                return 1;
            }
            $a_kickers = array_diff_key($a->cards, $a_cards);
            $b_kickers = array_diff_key($b->cards, $b_cards);

            $a_high = $a->getHighCard($a_kickers);
            $b_high = $b->getHighCard($b_kickers);

            if (!isset($a_high) || !isset($b_high)) {
                throw new \Exception('A: ' . $a->__toString() . "\nB: " . $b->__toString() . "\n");
            }
            if ($a_high_card::compare($a_high, $b_high)) {
                return -1;
            }
        }
        return 1;
    }

}
