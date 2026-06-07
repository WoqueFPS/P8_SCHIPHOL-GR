# P8_SCHIPHOL-GR
Dit project draait om het bouwen van een interactief Schiphol-dashboard waarmee reizigers vluchten kunnen zoeken en boeken, vluchtcoördinatoren vluchtschema’s en gatebeheer kunnen uitvoeren, en de directie overzichtelijke rapportages ontvangt over omzet en gebruik.

# Laravel Project (Vite + XAMPP MySQL)

Snelstartgids om dit project lokaal te draaien met XAMPP.

---

## Prerequisities
* XAMPP (Apache & MySQL gestart)
* PHP & Composer
* Node.js & NPM

---

## 1. Database & Omgeving inschakelen
1. Open **phpMyAdmin** (`http://localhost/phpmyadmin`) en maak een nieuwe database aan genaamd: `schiphol_db`.
2. Kopieer `.env.example` naar `.env` en pas de databasegegevens aan:

env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=schiphol_db
DB_USERNAME=root
DB_PASSWORD=

---

## 2. Installatie, Migraties & Seeders
Open je terminal in de projectmap en voer de volgende commando's uit:

composer install

php artisan key:generate

php artisan migrate --seed

npm install

Tip: Wil je de database later een keer volledig resetten en opnieuw seeden? Gebruik dan: php artisan migrate:fresh --seed

## 3. Applicatie Starten
Open twee aparte terminals om zowel de backend als de frontend te draaien:

Terminal 1:
php artisan serve

Terminal 2:
npm run dev

Applicatie is nu live op: http://127.0.0.1:8000

---
