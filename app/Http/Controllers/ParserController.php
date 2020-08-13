<?php
   
namespace App\Http\Controllers;
  
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
            while (($line = fgets($handle)) !== false) {
                $expLine = explode(" ",$line);
                for($i = 0;$i < 5;$i++) {
                    echo $expLine[$i];
                    echo " ";
                    DB::insert('insert into users (id, name) values (?, ?)', [1, 'Dayle']);
                }
                for($i = 5;$i < 10;$i++) {
                    echo $expLine[$i];
                    echo " ";
                }
                die;
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