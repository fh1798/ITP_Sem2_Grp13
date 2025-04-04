# Verbinden mit der Datenbank

## Erste Schritte (einmalig)

- XAMPP starten
- MySQL Database starten
- sicherstellen, dass euer "root" Benutzer kein Passwort verlangt:
    - http://localhost/phpmyadmin aufrufen
    - Benutzerkonten
    - Zeile root mit screenPhpMyAdminUser.png abgleichen
    - in xamppfiles/phpmyadmin/config.inc.php kontrollieren, dass kein Passwort gesetzt ist (siehe ScreenConfiIncPhp.png)

## Datenbank importieren/exportieren (bei Updates)

### Importieren (nach jedem Pull)

- in http://localhost/phpmyadmin auf Importieren
- .sql Datei aus diesem Ordner hochladen
- wenn vorhanden ältere Datenbank itp_grp13 überschreiben

### Exportieren (wenn etwas geändert wurde bei Commit)

- in http://localhost/phpmyadmin auf Exportieren
- Datenbank itp_grp13 auswählen
- in diesem File ablegen
