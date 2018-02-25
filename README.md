# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 1.9 (as of writing this on 25/02/18)

Required version of PHP: 5.4+ (tested up to 7.1.3)

### Setup
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the links in GeometryDash.exe
4) Enter credentials in the config.php file, and optional webhooks.php file.

### Credits
Private Messaging system by someguy28 (even though he needed a ton of help from me... and by a ton I mean A TON)

Base for account settings by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Using this for cloud save encryption - https://github.com/defuse/php-encryption - (incl/lib/defuse-crypto.phar)

Jscolor (color picker in packCreate.php) - http://jscolor.com/

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them