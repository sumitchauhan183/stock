<?php 

namespace App\Classes;



Class Utils{
    public static function uploadFile($request,$file, $path){
            $file = $request->file("$file");
            $destinationPath = 'file_storage/'.$path;
            $originalFile    = $file->getClientOriginalName();
            $filename=strtotime(date('Y-m-d-H:isa')).$originalFile;
            $file->move($destinationPath, $filename);

            return $destinationPath.'/'.$filename;
    }

    public static function curlRequest($uri){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);


        return json_decode($output);
   }
    
}