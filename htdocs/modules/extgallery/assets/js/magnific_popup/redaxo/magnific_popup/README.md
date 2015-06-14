Magnific Popup AddOn für REDAXO 4
=================================

Bindet das jQuery Lightbox Plugin [Magnific Popup](http://dimsemenov.com/plugins/magnific-popup/) in REDAXO Websites ein.

Features
--------

* Automatische Enbindung von Magnific Popup im Frontend inklusive Fade Effekt und deutscher Lokalisierung
* Zusätzliche optionale Einbindung von jQuery
* Benötigte Bildtypen werden direkt mitgeliefert und automatisch installiert
* Galerie und Einzelbild Modul inkl. komfortabler Installation
* Titel und Beschreibungstext für die Bilder werden aus dem Medienpool geholt
* Automatische suchmaschinenfreundliche Image Manager Urls wenn [SEO42](http://github.com/RexDude/seo42) installiert

jQuery einbinden oder nicht?
----------------------------

Standardmäßig wird die benötigte JavaScript-Bibliothek jQuery automatisch eingebunden. Bindet man diese jedoch bereits "von Hand" ein oder über ein anderes Addon, sollte man unter den Einstellungen die entsprechende Checkbox wegklicken. 

Was hat es mit der Custom CSS auf sich?
---------------------------------------

Unter Einstellungen wird eine `custom.css` Datei angegeben. Dort sind hauptsächlich die Styles für die Bild-Rahmen, etc. definiert. Bei Bedarf bitte abändern bzw. die Styles per `!important` Statement im der eigenen CSS-Datei überschreiben.

Codebeispiel Einzelbild
-----------------------

```html
<a class="magnific-popup-image" href="./files/full.jpg" title="Die Bildbeschreibung">
	<img src="./files/thumb.jpg" width="200" height="200" alt="" />
</a>
```

Codebeispiel Galerie
--------------------

```html
<div class="magnific-popup-gallery">
	<a href="./files/full1.jpg" title="Die Bildbeschreibung #1">
		<img src="./files/thumb1.jpg" width="200" height="200" alt="" />
	</a>
	<a href="./files/full2.jpg" title="Die Bildbeschreibung #2">
		<img src="./files/thumb2.jpg" width="200" height="200" alt="" />
	</a>
	<a href="./files/full3.jpg" title="Die Bildbeschreibung #3">
		<img src="./files/thumb3.jpg" width="200" height="200" alt="" />
	</a>
</div>
```

Hinweise
--------

* Getestet mit REDAXO 4.5
* AddOn-Ordner lautet: `magnific_popup`
* Abhängigkeiten: Image Manager AddOn
* Aussehen der Rahmen für die Thumbs änderbar in der `custom.css`, siehe Einstellungen-Seite
* Medienpool-Bildtitel ergibt das `alt` Attribute
* Medienpool-Bildbeschreibung ergibt das `title` Attribute und somit den Bilduntertitel für die Lightbox

Changelog
---------

siehe [CHANGELOG.md](CHANGELOG.md)

Lizenz
------

* Magnific Popup: MIT Lizenz
* Magnific Popup REDAXO AddOn: [LICENSE.md](LICENSE.md) (MIT Lizenz)

Credits
-------

* [Magnific Popup](http://dimsemenov.com/plugins/magnific-popup/) Lightbox Plugin by Dmitry Semenov
* [Parsedown](http://parsedown.org/) Class by Emanuil Rusev

