# Updating GMDprivateServer
This directory contains all SQL files containing updates made to the database AFTER October 28, 2017. This gives everyone running a version that supports Geometry Dash 2.11 or newer the opportunity to update to the latest version of the private server for new features, exploit patches and performance improvements.

## How to update
1. Make a backup of the `config` and `data` directories in the server files.
	- You can optionally create a backup of all server files in case the update fails.
2. Make a backup of the server database (you can use the export feature in phpMyAdmin).
3. Determine which version of `database.sql` your server is currently using
	- In most cases you can take a look inside the file itself and look at the date mentioned on line 6 as `Generation Time`. In some cases the line might say `Vytvořeno` in Czech, in this case you can use [Google Translate](https://translate.google.com/) to translate the timestamp into a language you understand.
4. Download a copy of the private server repository.
5. Compare the config directory in the new version with your version and edit the files as necessary to set new variables.
6. Delete all files from the server EXCEPT for the `config` and `data` directories.
	- **IMPORTANT: If you delete the `data` directory and do not have a backup, you will lose ALL player-made levels.**
7. Upload the new server files including your new config files (if applicable) to the server.
8. Import all SQL files in this directory with timestamps newer than your current version `database.sql`. (You can use the import feature in phpMyAdmin for this).

TL;DR upload new server files, import relevant SQL files from this directory