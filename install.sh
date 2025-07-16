#!/bin/bash

# Abilita uscita immediata in caso di errore
set -e

echo "✅ Aggiornamento sistema..."
sudo apt update && sudo apt upgrade -y

echo "✅ Installazione pacchetti base..."
sudo apt install -y php php-cli php-mbstring php-xml php-bcmath php-curl php-mysql unzip curl git composer

echo "✅ Preparazione cartella progetto..."
cd /var/www

if [ -d "melatv.it" ]; then
  echo "⚠️  La cartella /var/www/melatv.it esiste già. Verrà rimossa..."
  sudo rm -rf melatv.it
fi

echo "✅ Clonazione repository Faucet..."
sudo git clone https://github.com/pasqualelembo78/faucet.git melatv.it
cd melatv.it

echo "✅ Installazione dipendenze Laravel..."
composer install

echo "✅ Creazione file .env..."
cat > .env <<EOF
APP_NAME="Mevacoin Faucet"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://www.melatv.it

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phpfaucet
DB_USERNAME=phpfaucet
DB_PASSWORD=desy

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=lembopasquale78@gmail.com
MAIL_PASSWORD=qguqkhwqafymicxj
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=lembopasquale78@gmail.com
MAIL_FROM_NAME="Faucet Mevacoin"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

WALLET_RPC_HOST=127.0.0.1
WALLET_RPC_PORT=17082
WALLET_ACCOUNT=meva
WALLET_PASSWORD=desy

RECAPTCHA_PUBLIC_KEY=6Ld2rlorAAAAAB72L6WzCq6TDrcXkSJi9CgcENH4
RECAPTCHA_PRIVATE_KEY=6Ld2rlorAAAAAKqLEAV12_RT19xgNqzNOudt8ZY8
EOF

echo "✅ Generazione APP_KEY..."
php artisan key:generate

echo "✅ Permessi cartelle storage e bootstrap/cache..."
sudo chown -R www-data:www-data .
sudo chmod -R 775 storage bootstrap/cache

echo "✅ Avvio Faucet su tutti gli IP (porta 8000)..."
nohup php artisan serve --host=0.0.0.0 --port=8000 > faucet.log 2>&1 &

echo "✅ Installazione completata! Visita: http://<TUO-IP>:8000 oppure http://www.melatv.it"
