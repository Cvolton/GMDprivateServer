# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 2.11 (so any version of Geometry Dash works, as of writing this [February 02, 2020])

Required version of PHP: 5.4+ (tested up to 7.3.11)

### Setup the Server
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the links in GeometryDash.exe (some are base64 encoded since 2.1, remember that)

### Setup the Clients
•[Windows](../../wiki/Creating-Windows,-Android-and-IOS-Apps#windows)

•[Android](../../wiki/Creating-Windows,-Android-and-IOS-Apps#android)

•[IOS](../../wiki/Creating-Windows,-Android-and-IOS-Apps#ios)

### Credits
Base for account settings and the private messaging system by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Using this for cloud save encryption - https://github.com/defuse/php-encryption - (incl/lib/defuse-crypto.phar)

Jscolor (color picker in packCreate.php) - http://jscolor.com/

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them

### Need More Help?
Refer the [wiki](../../wiki) or check [issues](../../issues)
