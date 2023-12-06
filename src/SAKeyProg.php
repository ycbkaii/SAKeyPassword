#!/usr/bin/php
<?php  
/**
 * @author Yanis Chiouar
 * @version 1.0
 */

require "User.php";
require "ReadInput.php";

const VERSION = "1.0";
const AUTHOR = "Yanis Chiouar";

const yellow_color = "\033[33m";
const reset_color = "\033[0m";



//Function which ables to the user to choose what commands he wants
function main(){
    system("clear");
    echo yellow_color."      ___           ___           ___           ___                 
    /\__\         /\  \         /|  |         /\__\                
   /:/ _/_       /::\  \       |:|  |        /:/ _/_         ___   
  /:/ /\  \     /:/\:\  \      |:|  |       /:/ /\__\       /|  |  
 /:/ /::\  \   /:/ /::\  \   __|:|  |      /:/ /:/ _/_     |:|  |  
/:/_/:/\:\__\ /:/_/:/\:\__\ /\ |:|__|____ /:/_/:/ /\__\    |:|  |  
\:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/__/ \:\/:/ /:/  /  __|:|__|  
 \::/ /:/  /   \::/__/       \::/~~/~      \::/_/:/  /  /::::\  \  
  \/_/:/  /     \:\  \        \:\~~\        \:\/:/  /   ~~~~\:\  \ 
    /:/  /       \:\__\        \:\__\        \::/  /         \:\__\
    \/__/         \/__/         \/__/         \/__/           \/__/".reset_color.PHP_EOL."\n\n";
    echo "Welcome to 'SAKey', this is a little software which stores and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n";
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
        echo yellow_color."      ___           ___           ___           ___                 
    /\__\         /\  \         /|  |         /\__\                
   /:/ _/_       /::\  \       |:|  |        /:/ _/_         ___   
  /:/ /\  \     /:/\:\  \      |:|  |       /:/ /\__\       /|  |  
 /:/ /::\  \   /:/ /::\  \   __|:|  |      /:/ /:/ _/_     |:|  |  
/:/_/:/\:\__\ /:/_/:/\:\__\ /\ |:|__|____ /:/_/:/ /\__\    |:|  |  
\:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/__/ \:\/:/ /:/  /  __|:|__|  
 \::/ /:/  /   \::/__/       \::/~~/~      \::/_/:/  /  /::::\  \  
  \/_/:/  /     \:\  \        \:\~~\        \:\/:/  /   ~~~~\:\  \ 
    /:/  /       \:\__\        \:\__\        \::/  /         \:\__\
    \/__/         \/__/         \/__/         \/__/           \/__/".reset_color.PHP_EOL."\n\n";
        echo "Welcome to 'SAKey', this is a little software which stores and protects your passwords ! \n";
        echo "@Version : ".VERSION."\n";
        echo "@Author : ".AUTHOR."\n";
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
    echo yellow_color."      ___           ___           ___           ___                 
    /\__\         /\  \         /|  |         /\__\                
   /:/ _/_       /::\  \       |:|  |        /:/ _/_         ___   
  /:/ /\  \     /:/\:\  \      |:|  |       /:/ /\__\       /|  |  
 /:/ /::\  \   /:/ /::\  \   __|:|  |      /:/ /:/ _/_     |:|  |  
/:/_/:/\:\__\ /:/_/:/\:\__\ /\ |:|__|____ /:/_/:/ /\__\    |:|  |  
\:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/__/ \:\/:/ /:/  /  __|:|__|  
 \::/ /:/  /   \::/__/       \::/~~/~      \::/_/:/  /  /::::\  \  
  \/_/:/  /     \:\  \        \:\~~\        \:\/:/  /   ~~~~\:\  \ 
    /:/  /       \:\__\        \:\__\        \::/  /         \:\__\
    \/__/         \/__/         \/__/         \/__/           \/__/".reset_color.PHP_EOL."\n\n";
    echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n\n";
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
            $user = new User($name_confirmed, $password_confirmed, $id_confirmed);
            $user->startSession();
        }else{
            system("clear");
            echo yellow_color."      ___           ___           ___           ___                 
    /\__\         /\  \         /|  |         /\__\                
   /:/ _/_       /::\  \       |:|  |        /:/ _/_         ___   
  /:/ /\  \     /:/\:\  \      |:|  |       /:/ /\__\       /|  |  
 /:/ /::\  \   /:/ /::\  \   __|:|  |      /:/ /:/ _/_     |:|  |  
/:/_/:/\:\__\ /:/_/:/\:\__\ /\ |:|__|____ /:/_/:/ /\__\    |:|  |  
\:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/__/ \:\/:/ /:/  /  __|:|__|  
 \::/ /:/  /   \::/__/       \::/~~/~      \::/_/:/  /  /::::\  \  
  \/_/:/  /     \:\  \        \:\~~\        \:\/:/  /   ~~~~\:\  \ 
    /:/  /       \:\__\        \:\__\        \::/  /         \:\__\
    \/__/         \/__/         \/__/         \/__/           \/__/".reset_color.PHP_EOL."\n\n";
            echo "Error : Password or Nickname incorrect\n";
            sleep(1.5);
            system("clear");
            echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
            echo "@Version : ".VERSION."\n";
            echo "@Author : ".AUTHOR."\n\n";
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
    echo yellow_color."      ___           ___           ___           ___                 
    /\__\         /\  \         /|  |         /\__\                
   /:/ _/_       /::\  \       |:|  |        /:/ _/_         ___   
  /:/ /\  \     /:/\:\  \      |:|  |       /:/ /\__\       /|  |  
 /:/ /::\  \   /:/ /::\  \   __|:|  |      /:/ /:/ _/_     |:|  |  
/:/_/:/\:\__\ /:/_/:/\:\__\ /\ |:|__|____ /:/_/:/ /\__\    |:|  |  
\:\/:/ /:/  / \:\/:/  \/__/ \:\/:::::/__/ \:\/:/ /:/  /  __|:|__|  
 \::/ /:/  /   \::/__/       \::/~~/~      \::/_/:/  /  /::::\  \  
  \/_/:/  /     \:\  \        \:\~~\        \:\/:/  /   ~~~~\:\  \ 
    /:/  /       \:\__\        \:\__\        \::/  /         \:\__\
    \/__/         \/__/         \/__/         \/__/           \/__/".reset_color.PHP_EOL."\n\n";
    echo "Welcome to 'SAKey', this is a little software which stocks and protects your passwords ! \n";
    echo "@Version : ".VERSION."\n";
    echo "@Author : ".AUTHOR."\n\n";
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

function _cryptInput($name_confirmed, $input ,$password_confirmed){
    $key = $name_confirmed.$password_confirmed."$";
    $encrypted_chaine = openssl_encrypt($input, "AES-256-ECB" ,$key);
    return $encrypted_chaine;
}

//Function which uncrypts data

function _uncryptInput($name_confirmed,$input,$password_confirmed){
    
    $key = $name_confirmed.$password_confirmed."$";
    $decrypted_chaine = openssl_decrypt($input, "AES-256-ECB" ,$key);
    
    return $decrypted_chaine;
}



//Function which encrypts files
// function _encryptfile($idUser,$name_confirmed, $f ,$password_confirmed){
//     $key = $name_confirmed.$password_confirmed."$";
//     if(file_put_contents($f, openssl_encrypt($f, "AES-256-ECB", $key)) == false){
//         echo "External Error...";
//         sleep(1);
        
//     }

// }

// Function which uncrypts files
// function _uncryptfile($idUser,$name_confirmed, $f ,$password_confirmed){
//     $key = $name_confirmed.$password_confirmed."$";
//     $fichier = openssl_decrypt(file_get_contents($f), "AES-256-ECB", $key);
//     if($fichier == false){
//         echo "External Error...";
//         sleep(1);
//         return [];
        
//     }

//     return $fichier;
    
// }

main();


?>