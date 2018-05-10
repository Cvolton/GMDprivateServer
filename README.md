# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 2.11 (so any version of Geometry Dash works, as of writing this [December 10, 2017])

Required version of PHP: 5.4+ (tested up to 7.1.3)

### Setup for Web Hostings
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the connection info at /config/connection.php
4) Edit the links in GeometryDash.exe (some are base64 encoded since 2.1, remember that)

### Setup for Dedicated Servers
1) Upload the files on web files tree folder.
Example1: [For iss(coming from Server Manager on Windows Server) install to C:\inetpub\wwwroot]
Example2: [For XAMPP(Can Downloadable) install to C:\xampp\htdocs)
2) Import database.sql into your webserver database.
Example1: ISS doesn't have Database, use another database app
Example2: XAMPP have database you can found http://localhost/phpmyadmin
3) Edit the connection info at /config/connection.php(Set server to localhost if you're using localhost database)
4) Edit the links in GeometryDash.exe (some are base64 encoded since 2.1, remember that)

### Found Problems or Bugs?
Feel free to write to the issues tab.
We'll help you as soon as we can.

### Credits
Private Messaging system by someguy28 (even though he needed a ton of help from me... and by a ton I mean A TON)

Base for account settings by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Using this for cloud save encryption - https://github.com/defuse/php-encryption - (incl/lib/defuse-crypto.phar)

Jscolor (color picker in packCreate.php) - http://jscolor.com/

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them

