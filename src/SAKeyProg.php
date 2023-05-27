#!/usr/bin/php8.1
<?php  
/**
 * @author Yanis Chiouar <yanis.chiouar@gmail.com>
 * @version 1.2
 */

require "User.php";

const VERSION = "1.0";
const AUTHOR = "Yanis Chiouar";

//Function which ables to the user to input some data
function readUser(){
    $stdin = fopen("php://stdin","r");
    $input = fgets($stdin);
    fclose($stdin);
    return $input;
}

//Function which returns a char
function readChar(){
    $stdin = fopen("php://stdin","r");
    $input = fgetc($stdin);
    fclose($stdin);
    return $input;
}

//Function which ables to the user to choose what commands he wants
function main(){
    system("clear");
    echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n";
    echo "\n\n";
    echo "L : to login to your account\n";
    echo "R : to register an account\n";
    echo "Q : to quit the program\n";
    $choice = readUser();
    while (trim(strtoupper($choice)) != "Q") {
        if (trim(strtoupper($choice)) == "L") {
            login();
        }else if (trim(strtoupper($choice)) == "R") {
            register();
        }else if(trim(strtoupper($choice))){
            clearData();
        }
        system("clear");
        
        echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
        echo "@Version : ".VERSION."\n";
        echo "@Author : ".AUTHOR."\n";
        echo "\n\n";
        echo "L : to login to your account\n";
        echo "R : to register an account\n";
        echo "Q : to quit the program\n";
        $choice = readUser();
    }
    echo "Thank you and goodbye !\n";
    sleep(1);
    system("clear");
}



//Function to login to the user's account and stock his passwords
function login(){
    system("clear");
    echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n\n";
    echo "©SAKeySoftware";
    echo "\n\n";
    echo "Nickname : ";
    $name = readUser();
    echo "\n";
    shell_exec('stty -echo');
    echo "Password : ";
    $password = readUser();
    shell_exec('stty echo');
    echo "\n";

    $file = file("file/usr");
    $find = false;
    while($find == false){
        $i = 0;
        while($i < count($file) && !isset($name_confirmed)){
            $hash = explode(" ",$file[$i]);
            if (str_contains($hash[0],'dn')) {
                if(password_verify($name,rtrim($hash[1]))){
                    $name_confirmed = $name;
                    $id_confirmed = $hash[0];
                    
                }
            }
            $i++;
        }
        if(isset($name_confirmed) && isset($id_confirmed)){
            $i = 0;
            while($i < count($file) && !isset($password_confirmed)){
                $hash = explode(" ",$file[$i]);
                if (str_contains($hash[0],'dp')) {
                    if(trim($hash[0],"dp") == trim($id_confirmed,"dn")){
                        if(password_verify($password,rtrim($hash[1]))){
                            $password_confirmed = $password;   
                        }
                        

                    }
                }
                $i++;
            }
        }

        if(isset($name_confirmed) && isset($id_confirmed) && isset($password_confirmed)){
            $find = true;
            index($name_confirmed, $id_confirmed,$password_confirmed);
        }else{
            system("clear");
            echo "Error : Password or Nickname incorrect\n";
            sleep(1.5);
            system("clear");
            echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
            echo "@Version : ".VERSION."\n";
            echo "@Author : ".AUTHOR."\n\n";
            echo "©SAKeySoftware";
            echo "\n\n";
            echo "Nickname : ";
            $name = readUser();
            echo "\n";
            shell_exec('stty -echo');
            echo "Password : ";
            $password = readUser();
            shell_exec('stty echo');
            echo "\n";

        }
    }

}

//Function to register the user 
function register(){
    system("clear");
    echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n\n";
    echo "©SAKeySoftware";
    echo "\n\n";
    echo "Input a new Nickanme \n";
    echo "Nickname : ";
    $name = readUser();
    echo "\n";
    echo "Enter a new Password\n";
    shell_exec('stty -echo');
    echo "Password : ";
    $password = readUser();
    shell_exec('stty echo');
    echo "\n";
    pushFile($name, $password);
    echo "You need to login to your account now !\n";
    sleep(1);
    system("clear");
    login();

}

//Function which stored data hashed in a file
function pushFile($name, $password){
    $file = fopen("file/usr","a");
    $id = time();
    $options = [
        'cost' => 12,
        ];
        $hashP = password_hash($password, PASSWORD_BCRYPT, $options);
        $hashN = password_hash($name, PASSWORD_BCRYPT, $options);
        fwrite($file, $id."dn ".$hashN."\n");
        fwrite($file, $id."dp ".$hashP."\n");
        fclose($file);
}


//Function which ables to the user to create a to registrate a account's password
function createRow($id_confirmed,$name_confirmed,$password_confirmed){
    
    system("mkdir -p file/".$id_confirmed."_dir");
    system("clear");
    echo "©SAKeySoftware";
    echo "\n\n";
    $id = time()."dac";
    echo "Name of the website ? \n";
    $nameWebSite = $id."nws ".readUser();
    echo "Name or Email of your account : \n";
    $nameAccount = $id."na ".readUser();
    echo "Your password :\n";
    $passwordAccount = $id."pa ".readUser();
    $f = fopen("file/".$id_confirmed."_dir/".$id_confirmed, "a");
    echo "Loading .\n";
    fwrite($f,_cryptInput($name_confirmed, $nameWebSite ,$password_confirmed)."\n");
    system("clear");
    echo "Loading ..\n";
    fwrite($f,_cryptInput($name_confirmed, $nameAccount ,$password_confirmed)."\n");
    system("clear");
    echo "Loading ...\n";
    fwrite($f,_cryptInput($name_confirmed, $passwordAccount ,$password_confirmed)."\n");
    system("clear");
    echo "Succes !\n";
    sleep(1);
    system("clear");

}

//Function which ables to the user to check his data
function listeAccounts($id_confirmed,$name_confirmed,$password_confirmed){
    $f = file("file/".$id_confirmed."_dir/".$id_confirmed."");
    $tmp = 0;
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
            $choice = readUser();
        }while(strtoupper(trim($choice)) != "Q");
    }
    
    
}


//Function main when the user is connected
function index($name_confirmed, $id_confirmed, $password_confirmed){

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
                echo "test L";
                break;

            case 'CLR' :
                echo "test CLR";
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

//Function which crypt data
function _cryptInput($name_confirmed, $input ,$password_confirmed){
    $key = $name_confirmed.$password_confirmed."$";
    $encrypted_chaine = openssl_encrypt($input, "AES-128-ECB" ,$key);
    return $encrypted_chaine;
}

//Function which uncrypts data
function _uncryptInput($name_confirmed,$input,$password_confirmed){
    
    $key = $name_confirmed.$password_confirmed."$";
    $decrypted_chaine = openssl_decrypt($input, "AES-128-ECB" ,$key);
    
    return $decrypted_chaine;
}

//Function which encrypts files
function _cryptfile(){

}

// Function which uncrypts files
function _uncryptfile(){

}

//Function to clear the data of your account
function clearData($id_confirmed){
    
}

main();


?>