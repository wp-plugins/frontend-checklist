=== Frontend Checklist ===
Contributors: jonasbreuer
Donate link: http://www.j-breuer.de/wordpress-plugins/frontend-checklist/
Tags: checklist, frontend, todo, to-do, list, checkliste, liste, aufgaben
Requires at least: 2.5
Tested up to: 3.4.1
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Mit Frontend Checklist kannst du eine HTML- oder PDF-Checkliste für deine Besucher erzeugen. Der Status kann per Cookie gespeichert werden.

== Description ==

Mit Frontend Checklist kannst du eine HTML- oder PDF-Checkliste für deine Besucher erzegen. Der Status der HTML-Checkliste kann per Cookie gespeichert werden. So können deine Besucher jedezeit zurückkehren und die Checkliste weiter abhaken.

Ein [Live-Beispiel der Checkliste](http://www.transsib-tipps.de/reise-organisation/transsib-checkliste/) kann auf meiner Seite zur Transsibirischen Eisenbahn angesehen werden.

Für die Erzeugung der PDF-Checkliste wird FPDF verwendet (http://www.fpdf.org/). Vielen Dank an Olivier Plathey für diese tolle Bibliothek.

Bei Fragen oder Problemen hinterlasse einfach einen Kommentar auf der [Plugin Seite](http://www.j-breuer.de/wordpress-plugins/frontend-checklist/). Ich helfe gerne.


== Installation ==

Wie immer.

1. Lade das Verzeichnis `frontend-checklist` in `/wp-content/plugins/` hoch (oder installiere das Plugin über den Plugin-Manager von Wordpress)
2. Aktiviere das Plugin über den Plugin-Manager von Wordpress.
3. Unter Einstellungen gibt es jetzt den neuen Punkt `Frontend Checklist`, wo du die einzelnen Punkte der Checkliste definieren kannst.
4. Zum Ausgeben der HTML Checkliste einfach den Tag `[frontend-checklist]` im Editor an der gewünschten Stelle eingeben.
5. Sollen die abgehakten ToDos nicht gespeichert werden, kann dieser Code benutzt werden: `[frontend-checklist cookie="off"]`
6. Link auf eine PDF-Checkliste: `[frontend-checklist type="pdf" title="Meine Checkliste" linktext="Zur Checkliste"]`. Der Title erscheint in der PDF-Datei als Überschrift. 


== Screenshots ==

1. Einrichtung der Checkliste
2. HTML-Checkliste
3. PDF-Checkliste

== Changelog ==

= 0.2.0 =
* Implementierung der PDF-Checkliste
* Hinzufügen von Attributen, um die Ausgabe der Checkliste zu konfigurieren

= 0.1.0 =
* Implementierung der HTML-Checkliste

== Upgrade Notice ==

= 1.0 =
Ein Update ist nur nötig, wenn PDF-Checklisten oder die Deaktivierung der Speicherung per Cookie benötigt werden.
