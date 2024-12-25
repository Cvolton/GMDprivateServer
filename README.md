# GMDprivateServer
## Geometry Dash Private Server
Basically a Geometry Dash Server Emulator

Supported version of Geometry Dash: 1.0 - 2.207

(See [the backwards compatibility section of this article](https://github.com/Cvolton/GMDprivateServer/wiki/Deliberate-differences-from-real-GD) for more information)

Required version of PHP: 7.0+ (tested up to 8.3)

### Setup
1) Upload the files on a webserver
2) Import database.sql into a MySQL/MariaDB database
3) Edit the links in GeometryDash.exe (some are base64 encoded since 2.1, remember that)

#### Updating the server
1) Upload the files on a webserver
2) Set `$installed` to false in config/dashboard.php
3) Run main dashboard's page

### Credits
Base for account settings and the private messaging system by someguy28

XOR encryption — https://github.com/sathoro/php-xor-cipher — (incl/lib/XORCipher.php)

Cloud save encryption — https://github.com/defuse/php-encryption — (incl/lib/defuse-crypto.phar)

Mail verification — https://github.com/phpmailer/phpmailer — (config/mail)

JQuery — https://github.com/jquery/jquery — (dashboard/lib/jq.js)

Image dominant color picker — https://github.com/swaydeng/imgcolr — (dashboard/lib/imgcolr.js)

Media cover — https://github.com/aadsm/jsmediatags — (dashboard/lib/jsmediatags.js)

Audio duration — https://github.com/JamesHeinrich/getID3 — (config/getid3)

Proxies list — https://github.com/SevenworksDev/proxy-list — (config/proxies.txt)

Common VPNs list — https://github.com/X4BNet/lists_vpn — (config/vpns.txt)

Discord Webhooks — https://github.com/renzbobz/DiscordWebhook-PHP — (config/webhooks/DiscordWebhook.php)

GD icons — https://github.com/oatmealine/gd-icon-renderer-web — (any page with player's username)

Cloudflare IPs List — https://www.cloudflare.com/ips — (incl/lib/mainLib.php & incl/lib/ipCheck.php)

Translit — https://github.com/ashtokalo/php-translit — (config/translit)

Snow — https://embed.im/snow — (dashboard)

Most of the stuff in generateHash.php has been figured out by pavlukivan and Italian APK Downloader, so credits to them
