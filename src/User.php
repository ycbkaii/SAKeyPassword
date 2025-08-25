<?php

require 'Informations.php';
class User{

    private $password;
    private $nickname;
    private $id = null;
    
    public function __construct($nickname,$password, $id = null){
        if($id == null){
            $this->nickname = $nickname;
            $this->password = $password;
            $this->id = $id;
        }else if($id != null){
            $this->nickname = $nickname;
            $this->password = $password;
            $this->id = $id;
        }
    }

    public function getNickname(){
        return $this->nickname;
    }

    public function startSession(){
        if($this->id != null && $this->nickname != null && $this->password != null){
            $this->index();
        }else{
            echo "Error : You can't start the session because your informations are incorrect...";
            sleep(1.2);
            system("cls | clear");
        }
    }


    public function createId(){
        if($this->nickname != null && $this->password != null){
            $this->signUp();
        }
    }

    private function signUp(){
        system("mkdir -p ../file");
        $file = fopen("../file/.usr","a");
        $id = time();
        $options = [
            'cost' => 12,
        ];
        $hashP = password_hash($this->password, PASSWORD_BCRYPT, $options);
        $hashN = password_hash($this->nickname, PASSWORD_BCRYPT, $options);
        system("mkdir -p ../file");
        fwrite($file, $id."dn ".$hashN."\n");
        fwrite($file, $id."dp ".$hashP."\n");
        fclose($file);
    }



    private function index(){

        $name_confirmed = $this->nickname;
        $id_confirmed = $this->id;
        $password_confirmed = $this->password;

        system("clear");
        echo yellow_color."                                                             
        oooooooo8      o      oooo   oooo ooooooooooo ooooo  oooo 
        888            888      888  o88    888    88    888  88   
         888oooooo    8  88     888888      888ooo8        888     
                888  8oooo88    888  88o    888    oo      888     
        o88oooo888 o88o  o888o o888o o888o o888ooo8888    o888o                          
        ".reset_color.PHP_EOL."\n\n";
        echo "©SAKeySoftware\n";
        echo "Hello ".trim($name_confirmed)." ! Here, store your passwords or list them.";
        echo "\n\n";
        
    
        echo "Main :\n\n";
        echo "C : Create a row to store a website's password\n";
        echo "L : List your accounts stored by SAKey\n";
        echo "CLR : Clear your private data\n";
        echo "D : Disconnect\n";
        $choice = new ReadInput();
        $choice = strval($choice->readUser());
        
        $information = new Informations();

        while(strtoupper(trim($choice)) != 'D'){
            switch (strtoupper(trim($choice))) {
                case 'C':
                    $information->createRow($id_confirmed,$name_confirmed,$password_confirmed);
                    break;
    
                case 'L' :
                    $information->listeAccounts($id_confirmed,$name_confirmed,$password_confirmed);
                    break;
    
                case 'CLR' :
                    $information->clearData($id_confirmed);
                    break;
    
                default:
                    break;
            }
            system("clear");
            echo yellow_color."                                                             
            oooooooo8      o      oooo   oooo ooooooooooo ooooo  oooo 
            888            888      888  o88    888    88    888  88   
             888oooooo    8  88     888888      888ooo8        888     
                    888  8oooo88    888  88o    888    oo      888     
            o88oooo888 o88o  o888o o888o o888o o888ooo8888    o888o                          
            ".reset_color.PHP_EOL."\n\n";
            echo "©SAKeySoftware\n";
            echo "Hello ".trim($name_confirmed)." ! Here, store your passwords or list them.";
            echo "\n\n";
    
    
            echo "Main :\n\n";
            echo "C : Create a row to store a website's password\n";
            echo "L : List your accounts stored by SAKey\n";
            echo "CLR : Clear your private data\n";
            echo "D : Disconnect\n";
            $choice = new ReadInput();
            $choice = strval($choice->readUser());
        }
        echo "Goodbye ! See you soon ;)\n";
        sleep(1);
    
    }




    

} 

?>