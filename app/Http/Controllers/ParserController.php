<?php
   
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ParserController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function parse($filename)
    {
        $filePath = public_path() . '\uploads'. DIRECTORY_SEPARATOR . $filename;
        $handle = fopen($filePath, "r");
        if ($handle) {
            $z = 1;
            while (($line = fgets($handle)) !== false) {
                $expLine = explode(" ",$line);
                $hand1 = implode(" ",array_slice($expLine, 0, 5, true));
                $hand2 = implode(" ",array_slice($expLine, 5, 5, true));
                
                $pokerHand = new \App\PokerHands();
                $pokerHand->hand = $hand1;
                $pokerHand->handNo = $z;
                $pokerHand->user_id = 1;
                $pokerHand->save();
                
                $pokerHand = new \App\PokerHands();
                $pokerHand->hand = $hand2;
                $pokerHand->handNo = $z;
                $pokerHand->user_id = 2;
                $pokerHand->save();
            }
            fclose($handle);
        } else {
            // error opening the file.
        } 
        $fileContent = file_get_contents($filePath);
        
        
        
        echo $fileContent;
        die;
    }
}