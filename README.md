# master-server

This is a PHP-only adaptation of Blockland's master server made to operate on an average website (with the aim being that a VPS is not required).

Server data is stored in an SQLite database in the local directory that the master server is operating from, which is created and managed automatically.
Cron is not required because server timeouts are automatically checked every time the master server is queried.

## Requirements

* Apache/Nginx web server.
* PHP 5.3.0 or over.

## Installation

* Edit `config.php` to your own liking.
* Copy `index.php`, `postServer.php` and `config.php` into a public web directory.

## Usage

* By using `Script_CustomMS` in your Blockland installation, changing the master server in-game should be as easy as typing `$Pref::MasterServer = "example.com:80";` in the console (where `example.com` is the URL of your public web directory where the master server is located).