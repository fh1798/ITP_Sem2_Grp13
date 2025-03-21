# Hotelprojekt Liu, Harich

## Zugangsdaten Datenbank

- username = "root";
- password = "Bingki!2020$!";
- dbname = "hotelprojekt";

## Beschreibung

Dieses Projekt im Rahmen der Lehrveranstaltung Webtechnologien diente dem Erlernen des Programmierens einer Website mit Datenbankanbindung. Als konkrete Aufgabe war eine Hotelwebseite zu implementieren, mit Informationsseiten wie News-Beiträgen, einem Impressum und einer Hilfeseite, sowie der Möglichkeit sich einzuloggen und erweiterter Funktionalität für registrierte User - zB. das reservieren von Zimmern oder Verwalten der eigenen Nutzerdaten. Außerdem gibt es einen admin-User, der zusätzlich in der Lage ist, direkt online die Nutzer- und Reservierungsdaten der gesamten Webseite zu bearbeiten, sowie neue Blogbeiträge zu erstellen.
Die im Projekt vorhandenen Markdown-Files dienten der Organisation und Zusammenarbeit des Teams über Github.

## Dateiüberblick

Alle Dateien mit Programmiercode, die zu diesem Projekt gehören, und ihr Status, ob sie aktiv an der abgegebenen Lösung beteiligt sind.

- [x] index.php

### include

- [x] admin_reservierung.php
- [x] admin_update_reservierung.php
- [x] admin_user.php
- [x] article.php
- [x] delete_user.php
- [x] fct_login.php
- [x] fct_logout.php
- [x] fct_pw_reset.php
- [x] fct_register.php
- [x] fct_reservation.php
- [x] fct_session.php
- [x] fct_upload.php
- [x] footer.php
- [x] header.php 
- [ ] kontakt.php
- [x] navbar.php
- [ ] roomcard.php
- [x] site_blog.php
- [x] site_dashboard.php
- [x] site_help.php
- [x] site_impressum.php
- [x] site_logout.php
- [x] site_profil.php
- [x] site_profilverwaltung.php
- [x] site_reservation_process.php
- [x] site_reservation.php
- [x] site_reservationlists.php
- [x] site_rooms.php
- [x] site_upload.php
- [x] update_user.php

### config

- [x] dbaccess.php

### res/css

- [x] styles.css

## Verbesserungsvorschläge, nicht erledigt

- Bilder auf Startseite responsive
- Login & Registrierung in navbar nur für anonyme anzeigen
- fct_login & fct_register zu site_login & site_register umbenennen (Achtung: alle links!)
    - fct_register aufteilen in Funktion und Seite (Seite beginnt in Zeile 81)
- site_logout mit header.php noch kürzer machen, dafür footer einbinden
- sidebar im Dashboard etwas schöner machen