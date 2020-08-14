<?php
   
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\PokerHands as PokerHands;

class ParserController extends Controller
{
  
    public function parse($filename)
    {
        $filePath = public_path() . '\uploads'. DIRECTORY_SEPARATOR . $filename;
        $handle = fopen($filePath, "r");
        if ($handle) {
            PokerHands::query()->truncate();
            while (($line = fgets($handle)) !== false) {
                $expLine = explode(" ",trim($line));
                $hand1Array = array_slice($expLine, 0, 5, true);
                $hand2Array = array_slice($expLine, 5, 5, true);
                
                $hand1 = implode(" ",$hand1Array);
                $hand2 = implode(" ",$hand2Array);
                
                $pokerHand = new \App\PokerHands();
                $pokerHand->handPlayer1 = $hand1;
                $pokerHand->handPlayer2 = $hand2;
                
                $pokerHands = new PokerHandsController();
                $winner = $pokerHands->checkWinner($hand1, $hand2);
                $pokerHand->winner = $winner['winner'];
                $pokerHand->with = $winner['with'];
                $pokerHand->vs = $winner['vs'];
                $pokerHand->save();
            }
            fclose($handle);
        } else {
            // error opening the file.
        } 
    }
}