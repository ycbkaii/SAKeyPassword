#!/usr/bin/php
<?php  
/**
 * @author Yanis Chiouar
 * @version 1.0
 */

require "User.php";
require "ReadInput.php";

const VERSION = "1.1";
const AUTHOR = "Yanis Chiouar";

const yellow_color = "\033[33m";
const reset_color = "\033[0m";


const TITRE = yellow_color."                                                             
oooooooo8      o      oooo   oooo ooooooooooo ooooo  oooo 
888            888      888  o88    888    88    888  88   
 888oooooo    8  88     888888      888ooo8        888     
        888  8oooo88    888  88o    888    oo      888     
o88oooo888 o88o  o888o o888o o888o o888ooo8888    o888o                          
".reset_color.PHP_EOL."\n\n";


//Function which ables to the user to choose what commands he wants
function main(){
    system("clear");
    echo TITRE;
    echo "Welcome to 'SAKey', it's a little software which stores and protects your passwords ! \n";
    echo yellow_color."@Version : ".VERSION.reset_color."\n";
    echo yellow_color."@Author : ".AUTHOR.reset_color."\n";
    echo "\n\n";
    echo "L : to login to your account\n";
    echo "R : to register an account\n";
    echo "Q : to quit the program\n";
    
    $choice = new ReadInput();
    $choice = strval($choice->readUser());
    while (trim(strtoupper($choice)) != "Q") {
        if (trim(strtoupper($choice)) == "L") {
            login();
        }else if (trim(strtoupper($choice)) == "R") {
            register();
        }
        system("clear");
        echo TITRE;
        echo "Welcome to 'SAKey', it's a little software which stores and protects your passwords ! \n";
        echo yellow_color."@Version : ".VERSION.reset_color."\n";
        echo yellow_color."@Author : ".AUTHOR.reset_color."\n";
        echo "\n\n";
        echo "L : to login to your account\n";
        echo "R : to register an account\n";
        echo "Q : to quit the program\n";
        
        $choice = new ReadInput();
        $choice = strval($choice->readUser());
    }
    echo "Thank you and goodbye !\n";
    sleep(1);
    system("clear");
}



//Function to login to the user's account and stock his passwords
function login(){
    system("clear");
    echo TITRE;
    echo "Welcome to 'SAKey', it's a little software which stocks and protects your passwords ! \n";
    echo yellow_color."@Version : ".VERSION.reset_color."\n";
    echo yellow_color."@Author : ".AUTHOR.reset_color."\n";
    echo "©SAKeySoftware";
    echo "\n\n";
    echo "Nickname : ";
    $read_input = new ReadInput();
    $name = strval($read_input->readUser());
    echo "\n";
    shell_exec('stty -echo');
    echo "Password : ";
    $password = strval($read_input->readUser());
    shell_exec('stty echo');
    echo "\n";

    system("mkdir -p ../file");
    $file_creation = fopen("../file/.usr","a");
    fwrite($file_creation,"");
    fclose($file_creation);

    $file = file("../file/.usr");
    $find = false;

    
    while($find == false){
        $i = 0;
        while($i < count($file) && !isset($name_confirmed)){
            $hash = explode(" ",$file[$i]);
            if (str_contains($hash[0],'dn')) {
                if(password_verify($name,rtrim($hash[1]))){
                    
                    $id_confirmed = $hash[0];

                    if(isset($id_confirmed)){
                        $j = 0;
                        while($j < count($file) && !isset($password_confirmed)){
                            $hash = explode(" ",$file[$j]);
                            if (str_contains($hash[0],'dp')) {
                                if(trim($hash[0],"dp") == trim($id_confirmed,"dn")){
                                
                                    if(password_verify($password,rtrim($hash[1]))){
                                        $password_confirmed = $password;   
                                        $name_confirmed = $name;
                                    }
                                    
            
                                }
                            }
                            $j++;
                        }
                    }
                    
                }
            }
            $i++;
        }
        
        
        

        if(isset($name_confirmed) && isset($id_confirmed) && isset($password_confirmed)){
            $find = true;
            $user = new User($name_confirmed, $password_confirmed, $id_confirmed);
            $user->startSession();
        }else{
            system("clear");
            echo TITRE;
            echo "Error : Password or Nickname incorrect\n";
            sleep(1.5);
            system("clear");
            echo "Welcome to 'SAKey', it's a little software which stocks and protects your passwords ! \n";
            echo yellow_color."@Version : ".VERSION.reset_color."\n";
            echo yellow_color."@Author : ".AUTHOR.reset_color."\n";
            echo "©SAKeySoftware";
            echo "\n\n";
            echo "Nickname : ";
            $name = strval($read_input->readUser());
            echo "\n";
            shell_exec('stty -echo');
            echo "Password : ";
            $password = strval($read_input->readUser());
            shell_exec('stty echo');
            echo "\n";

        }
    }

}

//Function to register the user 
function register(){
    system("clear");
    echo TITRE;
    echo "Welcome to 'SAKey', it's a little software which stocks and protects your passwords ! \n";
    echo yellow_color."@Version : ".VERSION.reset_color."\n";
    echo yellow_color."@Author : ".AUTHOR.reset_color."\n";
    echo "©SAKeySoftware";
    echo "\n\n";
    echo "Input a new Nickanme \n";
    echo "Nickname : ";
    $read_input = new ReadInput();
    $name = strval($read_input->readUser());
    echo "\n";
    echo "Enter a new Password\n";
    shell_exec('stty -echo');
    echo "Password : ";
    $password = strval($read_input->readUser());
    shell_exec('stty echo');
    echo "\n";
    $user = new User($name, $password,null);
    $user->createId();
    echo "You need to login to your account now !\n";
    sleep(1);
    system("clear");
    login();

}


//Function which crypt data

function _cryptInput($name_confirmed, $input ,$password_confirmed, $id_confirmed){
    
    $base_key = $name_confirmed.$password_confirmed."$";
    $key = hash_pbkdf2("sha256", $base_key, $id_confirmed, 100000, 32, true);;

    // Random IV of 16 octets
    $iv = random_bytes(openssl_cipher_iv_length("AES-256-CBC"));

    // Encrypting
    $ciphertext = openssl_encrypt($input, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);

    // HMAC for integrity
    $hmac = hash_hmac('sha256', $ciphertext, $key, true);

    return base64_encode($iv . $hmac . $ciphertext);
}

//Function which uncrypts data

function _uncryptInput($name_confirmed,$input,$password_confirmed, $id_confirmed){

    $input = base64_decode($input);

    $ivLength = openssl_cipher_iv_length("AES-256-CBC"); // 16 octets
    $hmacLength = 32; // 32 octets


    $iv = substr($input, 0, $ivLength);
    $hmac = substr($input, $ivLength, $hmacLength);
    $ciphertext = substr($input, $ivLength + $hmacLength);


    $base_key = $name_confirmed.$password_confirmed."$";
    $key = hash_pbkdf2("sha256", $base_key, $id_confirmed, 100000, 32, true);


    // Check integrity with HMAC
    $calculatedHmac = hash_hmac('sha256', $ciphertext, $key, true);
    if (!hash_equals($hmac, $calculatedHmac)) {
        return "Data encrypted compromised";
    }

    $plaintext = openssl_decrypt($ciphertext, "AES-256-CBC", $key, OPENSSL_RAW_DATA, $iv);
    
    return $plaintext;
}


main();


?>