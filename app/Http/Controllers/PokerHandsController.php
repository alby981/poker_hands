<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\PokerHands as PokerHands;
use App\Feed\PokerHandFeedGenerator;
use App\Collection\PokerHandCollection;

class PokerHandsController extends Controller {

    public function get() {
        $pokerHands = PokerHands::all();
        return view('pokerhands')->with(compact('pokerHands'));
    }
    
    public function checkWinner($hand1, $hand2) {
        $aCards = [$hand1, $hand2];
        $game = PokerHandCollection::createFromArray(PokerHandFeedGenerator::createGame(),$aCards);
        $game->rank();
        $aReturn = [];
        $winner = true;
        foreach ($game->hands as $player => $hand) {
            if ($winner) {
                $aReturn['winner'] = $player;
                $aReturn['with'] = $hand::$ranks[$hand->hand_rank];
            }
            $aReturn['vs'] = $hand::$ranks[$hand->hand_rank];
            $winner = false;
        }
        return $aReturn;
    }
}
