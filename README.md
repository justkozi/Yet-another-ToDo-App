# Yet another ToDo App
## Aplikacja oparta na PHP + AJAX pozwalająca na CRUD notatek. 

* Autor: [Łukasz Kozak](mailto:lukasz.kozak.97@gmail.com)
* Przyczna powstania: Projekt zaliczeniowy na przedmiot Aplikacje internetowe(IV klasa) w Zespole Szkoł Komunikacji w Poznaniu *(data oddania: grudzień 2016)*
* Strona z prezentacją: [todo-zsk.tk](http://todo-zsk.tk/)

## Instrukcja instalacji:
* Do automatyzacji zadań używany jest [gulp](http://gulpjs.com/). 
Pierwszy krok zatem to:
```$ npm install ```,
* Kolejnymi krokami jest uruchomienie gulp'a ```gulp deafault```,
* Od teraz pliki automatycznie są kompilowane do zmniejszonej wersji a pliki sass są autoprefixowane i łączone do jednego głównego pliku,
* Konfuguracja bazy danych znajduję się w pliku [dbh.php](includes/dbh.php)*(tam uzupełniamy informacje o połączeniu z bazą)* należy utworzyć bazę danych a następnie zaimplementować w niej strukturę tabel: ```create_tables.sql```
* W razie problemów z uruchomieniem proszę o kontakt: [email](mailto:lukasz.kozak.97@gmail.com).

## Struktura katalogów i plików

```
├───js -> Pliki odpowiedzialne za javascript strony
│   ├───dist -> Skompilowane pliki *.min.js oraz biblioteki js
│   │   │───app.min.js -> Główny skompilowany plik js odpowiedzalny za AJAX
│ 	    └───script.min.js -> Główny skomilowawny plik, zawiera pozostałe funkcje js
│   └───src -> Folder z plikami *.js, kompilowanymi poprzez gulp'a
│       │───app.js -> plik js odpowiedzalny za zapytania AJAX oraz tworzenie struktury
│	 	└───script.js -> plik, zawiera pozostałe funkcje js
├───css -> Pliki odpowiedzialne za stylowanie strony
│   ├───dist -> Skompilowane pliki *.css oraz frameworki
│   │   └───main.min.css -> Główny skompilowany plik stylów
│   ├───fonts  -> Folder z plikami wymaganymi przez FontAwesome
│   └───src -> Folder z plikami *.sass, kompilowanymi poprzez gulp'a
│       └───main.sass -> Główny plik, który jest kompilowany na main.min.css
├─── ajax 
│   └─── todo.php -> kontroler zapytań AJAX'owych, zwraca wyniki do zapytań
├───includes -> Folder z głównymi plikami *.php
│   ├───dbh.php -> Klasa wykonująca zapytania MySQL (mysqli)
│   ├───functions.php -> Plik w którym zawarte są dodatkowe funkcje
│   └───user.php -> Klasa Uzytkownika, sterująca i kontrolująca dane, (kontroler)
│
├───index.php -> Strona główna
├───app.php -> Główny plik aplikacji, tutaj użytkownik zarządza notatkami
├───login.php -> Podstrona, zawierająca skrypt logowania i rejestracji
├───logout -> Skrypt wylogowania (usuwanie sesji)
├───package.json -> NodeJS dependencies (glownie gulp)
├───gulpfile.js -> Gulp Tasks

```


## Użyte biblioteki,frameworki itp.:

 * [Gulp](http://gulpjs.com/) - automatyzacja zadań,
 * [FontAwesome](http://fontawesome.io/) - ikonki,
 * [Subtle Patterns](http://subtlepatterns.com/) - Tło z polonezami :D,
 * [Material Ripple](https://github.com/db2k/MaterialRipple/) - Elekt ripple przy kliknięciach w menu,
 * [jQuerry](http://jquery.com/) - nie muszę chyba przedstawiać.
