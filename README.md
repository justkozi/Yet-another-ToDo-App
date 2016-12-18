# Yet another ToDo App
## Aplikacja oparta na PHP + AJAX pozwalaj¹ca na CRUD notatek. 

* Autor: [£ukasz Kozak](mailto:lukasz.kozak.97@gmail.com)
* Przyczna powstania: Projekt zaliczeniowy na przedmiot Aplikacje internetowe w Zespole Szko³ Komunikacji *(data oddania: grudzieñ 2016)*
* Strona z prezentacj¹: [todo-zsk.tk](http://todo-zsk.tk/)
## Instrukcja instalacji:
* Do automatyzacji zadañ (minimalizowanie plików, kompilacja sass->css itp.) u¿ywany jest [gulp](http://gulpjs.com/). Pierwszy krok zatem to: 
```$ npm install ```,
* Kolejnymi krokami jest uruchomienie gulp'a ```gulp deafault```,
* Od teraz pliki automatycznie s¹ kompilowane do zmniejszonej wersji a pliki sass s¹ autoprefixowane i ³¹czone do jednego g³ównego pliku,
* Konfuguracja bazy danych znajdujê siê w pliku ```includes/dbh.php```*(tam uzupe³niamy informacje o po³¹czeniu z baz¹)* nale¿y utworzyæ bazê danych a nastêpnie zaimplementowaæ w niej strukturê tabel: ```create_tables.sql```
* W razie problemów z uruchomieniem proszê o kontakt: [email](mailto:lukasz.kozak.97@gmail.com).

## Struktura katalogów i plików

```
+¦¦¦js -> Pliki odpowiedzialne za javascript strony
-   +¦¦¦dist -> Skompilowane pliki *.min.js oraz biblioteki js
-   -   -¦¦¦app.min.js -> G³ówny skompilowany plik js odpowiedzalny za AJAX
-	-	L¦¦¦script.min.js -> G³ówny skomilowawny plik, zawiera pozosta³e funkcje js
-   L¦¦¦src -> Folder z plikami *.js, kompilowanymi poprzez gulp'a
-       -¦¦¦app.js -> plik js odpowiedzalny za zapytania AJAX oraz tworzenie struktury
-	 	L¦¦¦script.js -> plik, zawiera pozosta³e funkcje js
+¦¦¦css -> Pliki odpowiedzialne za stylowanie strony
-   +¦¦¦dist -> Skompilowane pliki *.css oraz frameworki
-   -   L¦¦¦main.min.css -> G³ówny skompilowany plik stylów
-   +¦¦¦fonts  -> Folder z plikami wymaganymi przez FontAwesome
-   L¦¦¦src -> Folder z plikami *.sass, kompilowanymi poprzez gulp'a
-       L¦¦¦main.sass -> G³ówny plik, który jest kompilowany na main.min.css
+¦¦¦ ajax 
-   L¦¦¦ todo.php -> kontroler zapytañ AJAX'owych, zwraca wyniki do zapytañ
+¦¦¦includes -> Folder z g³ównymi plikami *.php
-   +¦¦¦dbh.php -> Klasa wykonuj¹ca zapytania MySQL (mysqli)
-   +¦¦¦functions.php -> Plik w którym zawarte s¹ dodatkowe funkcje
-   L¦¦¦user.php -> Klasa Uzytkownika, steruj¹ca i kontroluj¹ca dane, (kontroler)
-
+¦¦¦index.php -> Strona g³ówna
+¦¦¦app.php -> G³ówny plika aplikacji, tutaj u¿ytkownik zarz¹dza notatkami
+¦¦¦login.php -> Podstrona, zawieraj¹ca skrypt logowania i rejestracji
+¦¦¦logout -> Skrypt wylogowania (usuwanie sesji)
+¦¦¦package.json -> NodeJS dependencies (glownie gulp)
+¦¦¦gulpfile.js -> Gulp Tasks

```


## U¿yte biblioteki,frameworki itp.:

 * [Gulp](http://gulpjs.com/) - automatyzacja zadañ,
 * [FontAwesome](fontawesome.io) - ikonki,
 * [Subtle Patterns](subtlepatterns.com) - T³o z polonezami :D,
 * [Material Ripple](https://github.com/db2k/MaterialRipple) - Elekt ripple przy klikniêciach w menu,
 * [jQuerry](jquery.com) - nie muszê chyba przedstawiaæ.

