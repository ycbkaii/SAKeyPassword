<?php

class User{

    private $password;
    private $nickname;
    private $id = null;
    
    public function __construct($nickname,$password, $id = null){
        if($id == null){
            $this->nickname = $nickname;
            $this->password = $password;
            $this->createId();
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
        if($this->id = null && $this->nickname != null && $this->password != null){
            $this->signUp();
        }
    }

    private function signUp(){
        $file = fopen("file/usr","a");
        $id = time();
        $options = [
            'cost' => 12,
        ];
        $hashP = password_hash($this->password, PASSWORD_BCRYPT, $options);
        $hashN = password_hash($this->nickname, PASSWORD_BCRYPT, $options);
        fwrite($file, $id."dn ".$hashN."\n");
        fwrite($file, $id."dp ".$hashP."\n");
        fclose($file);
    }

    private function index(){

        $name_confirmed = $this->nickname;
        $id_confirmed = $this->id;
        $password_confirmed = $this->password;

        system("clear");
        echo "©SAKeySoftware\n";
        echo "Hello ".trim($name_confirmed)." ! Here, store your passwords or check them.";
        echo "\n\n";
        
    
        echo "Main :\n\n";
        echo "C : Create a row to store the password of a website\n";
        echo "L : List your accounts stored by SAKey\n";
        echo "CLR : Clear your data you put in the files\n";
        echo "D : Disconnect\n";
        $choice = readUser();
        
        while(strtoupper(trim($choice)) != 'D'){
            switch (strtoupper(trim($choice))) {
                case 'C':
                    createRow($id_confirmed,$name_confirmed,$password_confirmed);
                    break;
    
                case 'L' :
                    listeAccounts($id_confirmed,$name_confirmed,$password_confirmed);
                    break;
    
                case 'CLR' :
                    clearData($id_confirmed);
                    break;
    
                default:
                    break;
            }
            system("clear");
            echo "©SAKeySoftware\n";
            echo "Hello ".trim($name_confirmed)." ! Here, store your passwords or check them.";
            echo "\n\n";
    
    
            echo "Main :\n\n";
            echo "C : Create a row to store the password of a website\n";
            echo "L : List your accounts stored by SAKey\n";
            echo "CLR : Clear your data you put in the files\n";
            echo "D : Disconnect\n";
            $choice = readUser();
        }
        echo "Goodbye ! See you soon ;)\n";
        sleep(1);
    
    }


    



    

} 

?>