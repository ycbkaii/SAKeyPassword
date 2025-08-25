# SAKey - Password Management Software

SAKey is a simple password management software written in PHP. It allows users to store and protect their passwords securely. SAKey uses encryption to ensure the privacy and security of user data.

## Getting Started

### Prerequisites

- PHP 8.1 or higher

### Installation

#### For Debian based linux distro :

Simply run `./launch.sh` and follow the instruction

#### For other OS :
1. Clone the SAKey repository or download the source code.
2. Make sure you have PHP 8.1 installed on your system.
3. Open a terminal and navigate to the SAKey directory.
4. Make the script executable by running the following command:
   ```
   chmod +x SAKey.php
   ```

## Usage

Once installed, You can run the SAKey software, use the following command:

```
./launch.sh
```

### Main Menu

Upon launching SAKey, you will be presented with the main menu. The menu options are as follows:

- **L**: Login to your account
- **R**: Register a new account
- **Q**: Quit the program

Enter the corresponding letter to choose an option. Follow the on-screen prompts to proceed.

### Login

If you select the login option (L), you will be prompted to enter your nickname and password. Once logged in successfully, you will have access to your stored passwords.

### Register

To register a new account (R), you need to provide a nickname and a password. After registration, you will be prompted to log in to your newly created account.

### Password Management

Once logged in, you can perform the following actions:

- **C**: Create a new row to store a website's password.
- **L**: List your stored accounts.
- **CLR**: Clear all your stored data.
- **D**: Disconnect from your account.

### Encryption

SAKey uses AES-256-CBC encryption to encrypt and decrypt the stored passwords. The encryption key is derived from your nickname and password.

## Contributing

Contributions to SAKey are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request on the [GitHub repository](https://github.com/ycbkaii/SAKeyPassword).

## License

SAKey is licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Author

SAKey is developed and maintained by Yanis Chiouar. You can reach out to the author at yanis.chiouar@gmail.com.

## Version

Current version: 1.1

## Patch notes V1.1

- New Encryption : **AES-256-CBC**
- Check the integrity of stored data with the **hmac method**