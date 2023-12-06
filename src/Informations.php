<?php

class Informations{
    public static function createRow($id_confirmed,$name_confirmed,$password_confirmed){
        if($id_confirmed != null && $name_confirmed != null && $password_confirmed != null){
            system("mkdir -p ../file/".$id_confirmed."_dir");
            system("clear");
            echo "©SAKeySoftware";
            echo "\n\n";
            $read_input = new ReadInput();
            $id = time()."dac";
            echo "Name of the website ? \n";
            $nameWebSite = $id."nws ".strval($read_input->readUser());
            echo "Name or Email of your account : \n";
            $nameAccount = $id."na ".strval($read_input->readUser());
            echo "Your password :\n";
            shell_exec('stty -echo');
            $passwordAccount = $id."pa ".strval($read_input->readUser());
            shell_exec('stty echo');
            $f = fopen("../file/".$id_confirmed."_dir/".$id_confirmed, "a");
            echo "Loading .\n";
            fwrite($f,_cryptInput($name_confirmed,$nameWebSite,$password_confirmed)."\n");
            system("clear");
            echo "Loading ..\n";
            fwrite($f,_cryptInput($name_confirmed,$nameAccount,$password_confirmed)."\n");
            system("clear");
            echo "Loading ...\n";
            fwrite($f,_cryptInput($name_confirmed,$passwordAccount,$password_confirmed)."\n");
            system("clear");
            echo "Succes !\n";
            sleep(1);
            system("clear");
        }
    
    }

    
    public static function listeAccounts($id_confirmed,$name_confirmed,$password_confirmed){
        $f = file("../file/".$id_confirmed."_dir/".$id_confirmed."");
        $tmp = 0;
        $read_input = new ReadInput();
        if($f != false){
            do{
                foreach($f as $line){
                    $line = _uncryptInput($name_confirmed,trim($line),$password_confirmed);
                    $a_line = explode(" ",$line);
                    if(str_contains($a_line[0],"nws")){
                        $tmp = trim($a_line[0],"nws");
                        echo "----------------\n";
                        echo "WebSite : ".trim($a_line[1]);
                        echo "\n";
                    }
                    else if(str_contains($a_line[0],$tmp) && str_contains($a_line[0],"na")){
                        echo "NameAccount/E-Mail : ".trim($a_line[1]);
                        echo "\n";
                    }
                    else if(str_contains($a_line[0],$tmp) && str_contains($a_line[0],"pa"))
                    {
                        echo "Password : ".trim($a_line[1]);
                        echo "\n";
                        echo "----------------\n\n\n";
            
                    }
                }
                echo "'Q' to leave\n";
                $choice = strval($read_input->readUser());
            }while(strtoupper(trim($choice)) != "Q");
        }
        
        
    }


    //Function to clear the data of your account
    public function clearData($id_confirmed){
        $f = fopen("../file/".$id_confirmed."_dir/".$id_confirmed."","w");
        if($f != false){
            fwrite($f,"");
        }
    }
}
?>