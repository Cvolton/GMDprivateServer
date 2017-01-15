# GMDprivateServer
## Geometry Dash Private Server
A PHP server, which should react exactly, how RobTop's server could react...

Supported version of Geometry Dash: 2.00 (generateHash.php is missing in this repository, so no 2.02 and 2.1 yet for public)

### Credits
Private Messaging system by someguy28 (even though he needed a ton of help from me... and by a ton I mean A TON)

Base for account settings by someguy28

Used this for XOR encryption - https://github.com/sathoro/php-xor-cipher - (incl/XORCipher.php)

Most of the stuff in generateHash.php (missing in the public repository but it does exist in private) has been figured out by pavlukivan

### To-do list
* A major overhaul of the friends system
* The notification counters in profiles
* Searching levels
	* Featured not being sorted by date anymore (!feature <position>)
* Banning system
	* Autoban
* Custom Features 
	* Favorite levels (not sure how to implement yet)
* 2.01 and 2.1 features (future)
	* !!!!!!! THE HASH !!!!!!!!!
	* The new mod system
	* Entirely new 2.1 features
		* Friends
			* Levels Leaderboard
		* Quests
		* Daily features
		* Gauntlets
		* Epic levels