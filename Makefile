all: m2-cli.phar print-version

vendor/autoload.php: composer.phar
	composer install

composer.phar:
	wget https://raw.githubusercontent.com/composer/getcomposer.org/a5874d7ceecca18772d44ed19e7da5fd267ba0a4/web/installer -O - -q | php -- --quiet

box.phar:
	wget https://github.com/humbug/box/releases/download/3.8.4/box.phar

m2-cli.phar: .env.local.php box.phar box.json composer.lock symfony.lock vendor/autoload.php $(shell find bin config src -type f)
	php box.phar compile

.env.local.php:
	composer dump-env prod

print-version: m2-cli.phar
	php m2-cli.phar -V
