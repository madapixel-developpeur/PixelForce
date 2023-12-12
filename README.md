# Greenlife Ultimate
## doctrine/doctrine-bundle
```DATABASE_URL="mysql://root:@127.0.0.1:3306/pixelForce?serverVersion=5.7&charset=utf8mb4"```
#mail
```MAILER_DSN=smtp://localhost:1025```
```MAILER_SEND_FROM=admin@pixelForce.fr```
```MAILER_SEND_FROM_NAME=PixelForce```

### commandes

# installer les dépendances symfony
```composer install```
# installer les dépendances assets
```yarn install```
# probleme du slash div dans le compilateur js
```npm install -g sass-migrator```
```sass-migrator division **/*.scss```
# buil yarn
```yarn run dev --watch```
# lancer maildev
```maildev --hide-extensions STARTTLS```
# Lancer messenger
```php bin/console messenger:consume async -vv```
## Création de la base de données 
```php bin/console doctrine:database:create```
## Mise a jour des tables de la base de données generique
```php bin/console doctrine:schema:update -f```
# lancer messenger
```php bin/console messenger:consume async -vv```
# lancer mercure
```mercure run -config Caddyfile.dev```
# suprimer l cache
```php bin/console c:c```

# Calendar and Meeting Fixtures :
```php bin/console doctrine:fixtures:load --group=calendar_event_label --append```
```php bin/console doctrine:fixtures:load --group=calendar_event --append```
```php bin/console doctrine:fixtures:load --group=meeting_state --append```


# Deploy on Heroku :
heroku login -i
heroku git:remote -a pixel-force
git push heroku main

# PDF CONTRACTS : Must download PDF toolkit pdftk => composer require mikehaertl/php-pdftk

pdftk test.pdf output test_o.pdf `to correct FDF format`
pdftk test.pdf generate_fdf `to extract data fields from pdf forms`
To Persist data form from pdf :
- Convert PDF to image with https://www.ilovepdf.com/fr/pdf_en_jpg
- Print PDF - Save a PDF version of it and it will be un modifiable!

# DUMP DB 
mysqldump -u root -p pixelfocedev_bdd > pixelforce.sql
mysql -u root -p pixelforce < pixelforce.sql

$agentToken = $request->get('agentToken');


## Enrironment setup:
```shell
# For prod environment
sudo git clone https://github.com/madapixel-developpeur/PixelForce.git PixelForce-MLM
sudo chown -R $USER:$USER /var/www/PixelForce-MLM
cd PixelForce-MLM
git checkout MLM

git fetch
git pull

sudo npm install
npm run watch 
composer install 
```

## For Database : 
Update `.env` file
```yml
APP_ENV=dev
```

Then create database and make migrations
> Create a `migrations` in the root of the project if not present

```shell
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

Re-Update `.env` file
```yml
APP_ENV=prod
```

## Template utilisé
> https://drive.google.com/file/d/12EQ8drDtjMLWqIyFkOEcd2Lss6dmPO2p/view?usp=sharing

## Mise en ligne
```shell
sudo nano /etc/apache2/sites-available/pixelforce-greenlifeultimate.conf
```

Et mettre le contenu suivant
```xml
<VirtualHost *:80>
    ServerName greenlifeultimate.fr
    ServerAlias greenlifeultimate.fr
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/PixelForce-MLM/public
    <Directory /var/www/PixelForce-MLM/public>
        AllowOverride All
    </Directory>
</VirtualHost>
```

```shell
sudo a2ensite pixelforce-greenlifeultimate
sudo systemctl reload apache2
```

Générer le certificat
```shell
certbot --apache
```

## PROD
```shell
sudo nano /etc/apache2/sites-available/PixelForce-MLM.conf
```

Et mettre le contenu suivant
```xml
<VirtualHost *:80>
    ServerName traiteur-artisanal.fr
    ServerAlias traiteur-artisanal.fr
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/PixelForce-MLM/public
    <Directory /var/www/PixelForce-MLM/public>
        AllowOverride All
    </Directory>
</VirtualHost>

<VirtualHost *:80>
   ServerName tobywallet.fr
   ServerAlias tobywallet.fr
   Redirect permanent / https://tobywallet.fr/
</VirtualHost>
<VirtualHost *:443>
    ServerName tobywallet.fr
    ServerAlias tobywallet.fr
    ServerAdmin webmaster@localhost
    SSLEngine on
    SSLCertificateFile /etc/ssl-cert/tobywalletfr/tobywallet_fr_ssl_certificate.cer
    SSLCertificateKeyFile /etc/ssl-cert/tobywalletfr/tobywallet_fr_private_key.key
    SSLCACertificateFile /etc/ssl-cert/tobywalletfr/tobywallet_fr_ssl_certificate_INTERMEDIATE.cer
    DocumentRoot /var/www/tunnel-toby-wallet/public
    <Directory /var/www/tunnel-toby-wallet/public>
        AllowOverride All
    </Directory>
</VirtualHost>
```

```shell
sudo a2ensite PixelForce-MLM
sudo systemctl reload apache2
```

# USER
```sql
INSERT INTO `user` (
username,
roles,
password,
nom,
prenom,
email,
adresse,
telephone,
created_at,
account_status,
stripe_data,
code_postal
)
VALUES
(
'Green-life-ultimate',
'["ROLE_AGENT"]',
'$2y$13$aVrvQrPS.61AkyKggLZLXupJlyKFeZ2NWFnWVWsarPDXpDaf2RwYe',
'Kandjy',
'Elina',
'elinakandjypro@gmail.com',
'L''étang neuf 03350 Theneuille',
'0779542776',
current_timestamp,
'Actif',
'a:0:{}',
'03350'
)

-- CONFIG
INSERT INTO `config` VALUES (1,'TVA',20,1,1),(2,'Frais livraison',4.79,2,1),(3,'Prix min frais de livraison gratuit',35,3,1);

```