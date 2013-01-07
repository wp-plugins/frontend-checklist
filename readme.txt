=== Frontend Checklist ===
Contributors: JonasBreuer
Donate link: http://www.j-breuer.de/wordpress-plugins/frontend-checklist/
Tags: checklist, frontend, todo, to-do, list, checkliste, liste, aufgaben
Requires at least: 2.8
Tested up to: 3.5
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

EN: Create HTML or PDF checklists for your visitors, which can be saved. DE: Erstelle speicherbare HTML oder PDF Checklisten für deine Besucher.

== Description ==

= EN: =

With Frontend Checklist, you can create HTML or PDF-Checklists for your visitors. The status of the HTML-Checklists can be saved via Cookie. Your visitors can always come back and continue with the checklists.

You can see a [Live-Example of a checklist](http://www.transsib-tipps.de/reise-organisation/transsib-checkliste/) on my (german) page about the  Transsiberian Railway.

For creating the PDF-Checklist, I'm using FDPF (http://www.fpdf.org/). Thanks to Olivier Plathey for this great library.

If you have questions or problems, just leave a comment on the [Plugin page](http://www.j-breuer.de/wordpress-plugins/frontend-checklist/). I'm always glad to help.


= DE: =

Mit Frontend Checklist kannst du HTML- oder PDF-Checklisten für deine Besucher erzeugen. Der Status der HTML-Checklisten kann per Cookie gespeichert werden. So können deine Besucher jederzeit zurückkehren und die Checklisten weiter abhaken.

Ein [Live-Beispiel einer Checkliste](http://www.transsib-tipps.de/reise-organisation/transsib-checkliste/) kann auf meiner Seite zur Transsibirischen Eisenbahn angesehen werden.

Für die Erzeugung der PDF-Checklisten wird FPDF verwendet (http://www.fpdf.org/). Vielen Dank an Olivier Plathey für diese tolle Bibliothek.

Bei Fragen oder Problemen hinterlasse einfach einen Kommentar auf der [Plugin Seite](http://www.j-breuer.de/wordpress-plugins/frontend-checklist/). Ich helfe gerne.


== Installation ==

= EN: =

As usual.

1. Upload the directory `frontend-checklist` in `/wp-content/plugins/` (or install the plugin over the plugin manager of Wordpress)
2. Activate the plugin over the plugin manager of Wordpress
3. On the Settings menu is now a new entry `Frontend Checklist`, where you can define the To-Dos.
4. To output the HTML checklist, just enter `[frontend-checklist]` into the editor at any place.
5. If you don't want that the status of the checklist is saved via cookie, you can use this code: `[frontend-checklist cookie="off"]`
6. Link to the PDF-Checklist:  `[frontend-checklist type="pdf" title="My Checklist" linktext="To the Checklist"]`. The Title is the headline in the PDF file.


= DE: =

Wie immer.

1. Lade das Verzeichnis `frontend-checklist` in `/wp-content/plugins/` hoch (oder installiere das Plugin über den Plugin-Manager von Wordpress)
2. Aktiviere das Plugin über den Plugin-Manager von Wordpress.
3. Unter Einstellungen gibt es jetzt den neuen Punkt `Frontend Checklist`, wo du die einzelnen Punkte der Checkliste definieren kannst.
4. Zum Ausgeben der HTML Checkliste einfach den Tag `[frontend-checklist]` im Editor an der gewünschten Stelle eingeben.
5. Sollen die abgehakten ToDos nicht gespeichert werden, kann dieser Code benutzt werden: `[frontend-checklist cookie="off"]`
6. Link auf eine PDF-Checkliste: `[frontend-checklist type="pdf" title="Meine Checkliste" linktext="Zur Checkliste"]`. Der Title erscheint in der PDF-Datei als Überschrift. 

== Frequently Asked Questions ==

= EN: Is it possible to create more than 50 To-Dos? DE: Sind mehr als 50 To-Dos möglich? =

EN: Unfournately not. The cookie gets problems when creating more than 50 To-Dos.
DE: Leider nicht. Der Cookie bekommt Probleme bei mehr als 50 To-Dos.


= EN: Is it possible to create multiple checklists? DE: Kann man mehrere Checklisten erstellen? =

EN: Yes, you can create as many checklists as you want.
DE: Ja, du kannst so viele Checklisten erstellen, wie du möchtest.


== Screenshots ==

1. Configure Frontend Checklist
2. HTML-Checklist
3. PDF-Checklist

== Changelog ==

= 2.0.0 =
* Create multiple checklists / Mehrere Checklisten erstellen

= 1.0.2 =
* Wordpress 3.5 compatiblity / Kompatibel mit Wordpress 3.5

= 1.0.1 =
* Switched the default language to english / Standard-Sprache auf Englisch umgestellt

= 1.0.0 =
* Raised maximum number of To-Dos from 20 to 50 / Maximale Anzahl an To-Dos von 20 auf 50 erhöht
* Plugin is now translatable (POT file is included) / Plugin ist jetzt übersetzbar (POT Datei ist beigelegt)
* Added English translation / Englische Übersetzung hinzugefügt


= 0.3.0 =
* Little Bugfixes / Kleine Bugfixes
* Added Uninstall routine / Deinstallationsroutine hinzugefügt
* Removed Support for WP < 2.8 / Support für WP < 2.8 entfernt

= 0.2.0 =
* Implementation of the PDF-Checklist / Implementierung der PDF-Checkliste
* Added Attributes to configure the output of the checklist / Hinzufügen von Attributen, um die Ausgabe der Checkliste zu konfigurieren

= 0.1.0 =
* Implementation of the HTML-Checklist / Implementierung der HTML-Checkliste

== Upgrade Notice ==

= 2.0.0 =
* You should update if you want to create multiple checklists. / Du solltest aktualisieren, falls du mehrere Checklisten erstellen möchtest.

= 1.0.1 =
* You only need to update, if you have a non German page with German text / Du musst nur aktualisieren, wenn du auf einer nicht deutschen Seite deutsche Texte angezeigt bekommst.

= 1.0.0 =
* You should update if you need more than 20 To-Dos or understand no German / Du solltest aktualisieren, falls du mehr als 20 To-Dos benötigst, oder kein Deutsch verstehst.

= 0.3.0 =
* No traces after uninstall and no more PHP warnings. / Plugin hinterlässt bei Deinstallation keine Rückstände mehr und die PHP-Warnung ist behoben.

= 0.2.0 =
* Update is only required if you need PDF-Checklists or if yo want to deactivete the cookies / Ein Update ist nur nötig, wenn PDF-Checklisten oder die Deaktivierung der Speicherung per Cookie benötigt werden.
