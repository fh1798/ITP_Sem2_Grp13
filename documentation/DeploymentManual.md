# Deployment Manual

In diesem Dokument werden alle notwendigen Schritte und Voraussetzungen beschrieben, um dieses Projekt auf einem eigenen System zum Laufen zu bringen.

## Benötigte Software

Folgende Software muss auf dem Zielsystem installiert sein:

- **XAMPP** (inkl. Apache und MySQL)
- **Ein moderner Webbrowser** (z. B. Chrome, Firefox)
- **Eine IDE oder Texteditor** (z. B. Visual Studio Code) – optional, nur für Änderungen am Code

Die Datenbankverwaltung erfolgt über phpMyAdmin (in XAMPP enthalten).


## Projekt aufsetzen
### Ordner ablegen

Um das Projekt auf einem eigenen Gerät zu starten, müssen die zuvor genannten Software-Lösungen installiert sein. Entpacken Sie den ZIP-Ordner mit dem Code in einem Ordner, auf den durch den localhost zugegriffen werden kann. Da wir XAMPP benutzen, muss der Ordner also innerhalb des `htdocs` Verzeichnisses liegen. Sollten Sie den Ordner nicht direkt in `htdocs` ablegen, müssen Sie in weiterer Folge den eigenen Pfad anstatt des beschriebenen im Browser eingeben.

### XAMPP starten
Starten Sie nun den Apache-Webserver.

### Website öffnen
Haben Sie den Projektordner mit dem Namen `ITP_Sem2_Grp13` direkt im Verzeichnis `htdocs` abgelegt, so können Sie nun im Browser den folgenden Link in die Adresszeile eingeben: `http://localhost/ITP_Sem2_Grp13/sourceCode/index.php`.

Falls Sie eine andere Ordnerstruktur auf Ihrem Gerät verwenden, so müssen Sie diesen Pfad anpassen.


## Verbinden mit der Datenbank
### Erste Schritte (einmalig)

- XAMPP starten (wenn nicht schon erledigt)
- MySQL Database starten
- sicherstellen, dass Ihr `root` Benutzer kein Passwort verlangt:
    - http://localhost/phpmyadmin aufrufen
    - Benutzerkonten
    - Zeile root mit screenPhpMyAdminUser.png abgleichen
    - in `config.inc.php` (unter MacOS in `xampp/phpMyAdmin`, Pfad kann unter Windows abweichen) kontrollieren, dass kein Passwort gesetzt ist (siehe `ScreenConfiIncPhp.png`), 
- sollten Sie aufgrund anderer Projekte in Ihrer Installation von XAMPP einen `root` Benutzer mit Passwort benötigen, so öffnen Sie die Datei [dbaccess.php](/sourceCode/config/dbaccess.php) und verändern Sie dort die Benutzerdaten in Zeile 7 bis 8.

Zur Kontrolle siehe die Screenshots im Ordner `/documentation/screenshots`.

### Datenbank importieren

- in http://localhost/phpmyadmin auf Importieren
- laden Sie die Datei `it_grp13.sql` hoch
- Bestehende Datenbank `itp_grp13` ggf. überschreiben

## Fehlerbehebung

### Website lädt nicht

- Stellen Sie sicher, dass **Apache** und **MySQL** in XAMPP laufen.
- Prüfen Sie, ob Sie im Browser den korrekten Pfad verwenden (z. B. `localhost/ITP_Sem2_Grp13/sourceCode`).

### Datenbankverbindung schlägt fehl

- Kontrollieren Sie die Zugangsdaten in `/sourceCode/config/dbaccess.php`.
- Prüfen Sie, ob `root` Zugriff ohne Passwort erlaubt.

### Bilder oder CSS fehlen

- Achten Sie auf die korrekte Ordnerstruktur innerhalb von `htdocs`.
- Verwenden Sie keinen symbolischen Link (Symlink) zu externen Ordnern.

## Erfolgskontrolle

Wenn alles korrekt eingerichtet ist, sollten Sie beim Öffnen der URL `http://localhost/ITP_Sem2_Grp13/sourceCode/index.php`:

- die Startseite des Webshops sehen,
- sich registrieren oder einloggen und
- auf „Artikelübersicht“ zugreifen können.

### Sicherheitshinweis

Dieses Setup ist für den lokalen Gebrauch gedacht. Für eine produktive Nutzung sollten Sie:

- ein sicheres Passwort für den `root`-Benutzer setzen,
- die Datei `dbaccess.php` absichern und sensible Zugangsdaten nicht öffentlich belassen,
- Apache und MySQL nur bei Bedarf starten.
