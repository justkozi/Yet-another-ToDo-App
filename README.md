# Yet another ToDo App
## Aplikacja oparta na PHP + AJAX pozwalaj�ca na CRUD notatek. 

* Autor: [�ukasz Kozak](mailto:lukasz.kozak.97@gmail.com)
* Przyczna powstania: Projekt zaliczeniowy na przedmiot Aplikacje internetowe w Zespole Szko� Komunikacji *(data oddania: grudzie� 2016)*
* Strona z prezentacj�: [todo-zsk.tk](http://todo-zsk.tk/)
## Instrukcja instalacji:
* Do automatyzacji zada� (minimalizowanie plik�w, kompilacja sass->css itp.) u�ywany jest [gulp](http://gulpjs.com/). Pierwszy krok zatem to: 
```$ npm install ```,
* Kolejnymi krokami jest uruchomienie gulp'a ```gulp deafault```,
* Od teraz pliki automatycznie s� kompilowane do zmniejszonej wersji a pliki sass s� autoprefixowane i ��czone do jednego g��wnego pliku,
* Konfuguracja bazy danych znajduj� si� w pliku ```includes/dbh.php```*(tam uzupe�niamy informacje o po��czeniu z baz�)* nale�y utworzy� baz� danych a nast�pnie zaimplementowa� w niej struktur� tabel: ```create_tables.sql```
* W razie problem�w z uruchomieniem prosz� o kontakt: [email](mailto:lukasz.kozak.97@gmail.com).

## Struktura katalog�w i plik�w

```
+���js -> Pliki odpowiedzialne za javascript strony
-   +���dist -> Skompilowane pliki *.min.js oraz biblioteki js
-   -   -���app.min.js -> G��wny skompilowany plik js odpowiedzalny za AJAX
-	-	L���script.min.js -> G��wny skomilowawny plik, zawiera pozosta�e funkcje js
-   L���src -> Folder z plikami *.js, kompilowanymi poprzez gulp'a
-       -���app.js -> plik js odpowiedzalny za zapytania AJAX oraz tworzenie struktury
-	 	L���script.js -> plik, zawiera pozosta�e funkcje js
+���css -> Pliki odpowiedzialne za stylowanie strony
-   +���dist -> Skompilowane pliki *.css oraz frameworki
-   -   L���main.min.css -> G��wny skompilowany plik styl�w
-   +���fonts  -> Folder z plikami wymaganymi przez FontAwesome
-   L���src -> Folder z plikami *.sass, kompilowanymi poprzez gulp'a
-       L���main.sass -> G��wny plik, kt�ry jest kompilowany na main.min.css
+��� ajax 
-   L��� todo.php -> kontroler zapyta� AJAX'owych, zwraca wyniki do zapyta�
+���includes -> Folder z g��wnymi plikami *.php
-   +���dbh.php -> Klasa wykonuj�ca zapytania MySQL (mysqli)
-   +���functions.php -> Plik w kt�rym zawarte s� dodatkowe funkcje
-   L���user.php -> Klasa Uzytkownika, steruj�ca i kontroluj�ca dane, (kontroler)
-
+���index.php -> Strona g��wna
+���app.php -> G��wny plika aplikacji, tutaj u�ytkownik zarz�dza notatkami
+���login.php -> Podstrona, zawieraj�ca skrypt logowania i rejestracji
+���logout -> Skrypt wylogowania (usuwanie sesji)
+���package.json -> NodeJS dependencies (glownie gulp)
+���gulpfile.js -> Gulp Tasks

```


## U�yte biblioteki,frameworki itp.:

 * [Gulp](http://gulpjs.com/) - automatyzacja zada�,
 * [FontAwesome](fontawesome.io) - ikonki,
 * [Subtle Patterns](subtlepatterns.com) - T�o z polonezami :D,
 * [Material Ripple](https://github.com/db2k/MaterialRipple) - Elekt ripple przy klikni�ciach w menu,
 * [jQuerry](jquery.com) - nie musz� chyba przedstawia�.

