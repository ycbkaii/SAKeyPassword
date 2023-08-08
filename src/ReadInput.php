<?php
class ReadInput{
    public static function readUser(){
        $stdin = fopen("php://stdin","r");
        $input = fgets($stdin);
        fclose($stdin);
        return $input;
    }
}
?>