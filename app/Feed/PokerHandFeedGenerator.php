<?php

namespace App\Feed;

class PokerHandFeedGenerator {

    /**
     * @var string
     */
    private $players = [];

    static public function createGame($players = 2) {
        $instance = new static();
        for ($i = 1; $i <= $players; $i++) {
            $instance->addHand('Player ' . $i);
        }
        reset($instance->players);
        return $instance;
    }

    public function setDataFromArray($aCards) {
        $num = count($this->players);
        for ($i = 0; $i < count($aCards); $i++) {
            $playerCards = explode(" ", $aCards[$i]);
            for ($z = 0; $z < count($playerCards); $z++) {
                $card = [];
                $card['value'] = substr($playerCards[$z], 0, 1);
                $card['suit'] = substr($playerCards[$z], 1, 1);
                $card['card'] = $playerCards[$z];
                $playerIndex = $i + 1;
                $this->players["Player $playerIndex"]['hand'][$card['card']] = $card;
            }
        }
        return $this->players;
    }

    public function parseData($data) {
        $info = array();
        foreach ($data as $n => $player) {
            $info[$player['name']] = array();
            foreach ($player['hand'] as $card_index => $card) {
                $card['value'] = str_replace('T', 10, $card['value']);
                $card['card'] = str_replace('T', 10, $card['card']);
                $card_index = str_replace('T', 10, $card_index);
                $info[$player['name']][$card_index] = $card;
            }
        }

        return $info;
    }

    public function addHand($name) {
        $this->players[$name] = array(
            'name' => $name,
            'hand' => array(),
        );
        return $this;
    }

}
