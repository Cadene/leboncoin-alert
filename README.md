# LeBonCoin Alerts

A command you can cron to regularly receive email alerts on new ads.

![Result](/doc/result.png)

## Installation

Here are instructions to get started with the application.

```sh
# Clone the project
mkdir leboncoin-alert
cd leboncoin-alert
git clone https://github.com/ninsuo/leboncoin-alert.git ./

# install Composer
php -r "readfile('https://getcomposer.org/installer');" | php
php composer.phar install
```

## Configuration

Configuration is loaded from `config.yml`.

```sh
cp config.yml.dist config.yml
emacs -nw config.yml
```

## Usage

Just type `php run.php` to test your configuration.

Add a crontab to run "run.php" every XX minutes (5 is fair enough):

```
*/5 * * * * php /home/ninsuo/leboncoin/leboncoin-alert/run.php
```

