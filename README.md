# Schiphol Dashboard | Gatekeepers

Welkom bij het officiële repository voor het **Schiphol Dashboard**, ontwikkeld door team **Gatekeepers**. 

Dit platform biedt een centrale omgeving voor vluchtinformatie, planning en operationele rapportages binnen Schiphol. Het is ontworpen voor reizigers, coördinatoren en management om data snel en overzichtelijk te beheren en in te zien.

---

## Technologie Stack
Dit project is gebouwd met **Laravel** en maakt gebruik van **Vite** voor een moderne, snelle frontend-ervaring en **XAMPP (MySQL)** voor de database-afhandeling.

# Over het project

Het Schiphol Dashboard is ontwikkeld om:
Vluchtinformatie te beheren en tonen
Boekingen en operationele data te verwerken
Realtime frontend updates via Vite te ondersteunen
Een eenvoudige lokale ontwikkelomgeving te bieden

Het doel is een snelle, schaalbare en overzichtelijke applicatie voor luchthavenbeheer.

## Snelstartgids
Volg deze stappen om het dashboard lokaal op te zetten.

### Prerequisities
* **XAMPP**: Zorg dat Apache en MySQL gestart zijn.
* **PHP & Composer**: Geïnstalleerd op je systeem.
* **Node.js & NPM**: Voor het afhandelen van Vite assets.

---

### 1. Database & Omgevingsconfiguratie
1. Navigeer naar `http://localhost/phpmyadmin` en maak een database aan met de naam: `schiphol_db`.
2. Kopieer het configuratiebestand:
   ```bash
   cp .env.example .env
3. Open .env en update de database-instellingen:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schiphol_db
DB_USERNAME=root
DB_PASSWORD=

### 2. Installatie & Migraties

Voer de volgende commando's uit in de terminal vanuit de projectmap:
# Installeer PHP dependencies
composer install

# Genereer de applicatiesleutel
php artisan key:generate

# Voer migraties uit en vul de database met seed-data
php artisan migrate --seed

# Installeer frontend dependencies
npm install

Tip: Heb je de database vervuild of wil je een schone start? Gebruik: php artisan migrate:fresh --seed

### 3. Applicatie Starten
Draai de backend en de frontend gelijktijdig in twee aparte terminalvensters:

Terminal 1 (Backend):
Bash
php artisan serve

Terminal 2 (Frontend/Vite):
Bash
npm run dev

De applicatie is nu toegankelijk op: http://127.0.0.1:8000

---

# Features
Vlucht- en gatebeheer
Dashboard met operationele inzichten
Snelle frontend via Vite hot reload
Lokale database met MySQL (XAMPP)
Seeder data voor testgebruik

## Troubleshooting
Vite werkt niet / geen styling
npm install
npm run dev

Database errors
Check of MySQL draait in XAMPP
Controleer .env database credentials

Artisan errors
php artisan config:clear
php artisan cache:clear

--- 

## Handige commands
php artisan serve
php artisan migrate
php artisan migrate:fresh --seed
npm run dev
npm install
composer install

### Gebruikte Resources & Bronnen

https://laravel.com/docs/13.x/authentication
https://laravel.com/docs/13.x/csrf
https://vite.dev/guide/features
https://vite.dev/
https://apvarun.github.io/toastify-js/
https://developer.mozilla.org/en-US/
https://developer.mozilla.org/en-US/docs/Web/API/Clipboard_API
https://web.dev/


Gemaakt door Team Gatekeepers | P8_SCHIPHOL-GR
