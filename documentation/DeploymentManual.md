# Deployment Manual

In diesem Dokument werden alle notwendigen Schritte und Vorraussetzungen beschrieben, um dieses Projekt auf einem eigenen System zum laufen zu bringen.

## Software

Die für das aufsetzen des Projekts notwendige Software besteht aus:
- einem Browser,
- einem localhost (zB. XAMPP),
- einer SQL-Datenbank (zB. phpMyAdmin) und
- einer IDE um php-Code zu schreiben (zB. Visual Studio Code).

## Projekt aufsetzen

Um das Projekt auf einem eigenen Gerät zu starten, müssen die zuvor genannten Software-Lösungen installiert sein. Dann kann man den zip-Ordner mit unserem Code in einem Ordner entpackt werden, auf den durch den localhost zugegriffen werden kann. Im Falle von XAMPP ist dies der Ordner htdocs.


## Verbinden mit der Datenbank
### Erste Schritte (einmalig)

- XAMPP starten
- MySQL Database starten
- sicherstellen, dass euer "root" Benutzer kein Passwort verlangt:
    - http://localhost/phpmyadmin aufrufen
    - Benutzerkonten
    - Zeile root mit screenPhpMyAdminUser.png abgleichen
    - in xamppfiles/phpmyadmin/config.inc.php kontrollieren, dass kein Passwort gesetzt ist (siehe ScreenConfiIncPhp.png)    

### Datenbank importieren

- in http://localhost/phpmyadmin auf Importieren
- .sql Datei aus diesem Ordner hochladen
- wenn vorhanden ältere Datenbank itp\_grp13 überschreiben