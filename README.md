# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 2.11 (so any version of Geometry Dash works, as of writing this [February 02, 2020])

Required version of PHP: 5.5+ (tested up to 7.3.11)

PHP 8.0 and newer are currently unsupported.

### Branches
- master - This is the main version of the server.
- untested - This branch contains the newest breaking changes. Note that this branch has virtually no support and therefore you're on your own if stuff breaks.

### Setup
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the links in GeometryDash.exe (some are base64 encoded since 2.1, remember that)

#### Updating the server
See [README.md in the `_updates`](_updates/README.md)

### Credits
Base for account settings and the private messaging system by someguy28

Using this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/lib/XORCipher.php)

Using this for cloud save encryption - https://github.com/defuse/php-encryption - (incl/lib/defuse-crypto.phar)

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them
