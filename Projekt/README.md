# Drifts�ttning

F�ljande filer ska laddas upp via FTP

I mappen view:

-AuthenticationView.php
-ConsoleView.php
-GameView.php
-GameViewBase.php
-Navigator.php
-SearchView.php
-ViewBase.php

I mappen model:

-AuthenticationModel.php
-Console.php
-ConsoleDAL.php
-DALBase.php
-Game.php
-GameDAL.php
-Service.php
-User.php
-UserDAL.php

I mappen controller

-AuthenticationController.php
-ConsoleController.php
-Controller.php
-GameController.php
-SearchController.php

I roten

-index.php
-Request.php
-Router.php
-style.css
-.htaccess

Databasen ska best� av 3 tabeller.

Console

-consoleId
-name
-developer
-releaseDate 

Game

-gameId
-title
-developer
-releaseDate
-category
-image
-consoleId

User

-userId
-username
-password


# Konsolsamling Dokumentation

Som bes�kare har man endast r�ttigheter till att se registrerade
konsoler samt tillh�rande spel. Man kan s�ka i databasen efter registrerade
spel. S�kformul�r finns p� sidan "/Search" som man kommer till om man trycker p�
Search-l�nken. Observera att inte alla f�lt beh�ver fyllas i.

Som Admin kan man l�gga till en konsol genom att trycka p� knappen
"Register console" som finns p� f�rstasidan "/"

L�gga till konsol
- Ett konsolnamn m�ste anges och kan inte best� av mer �n 50 tecken.
- En utvecklare m�ste anges och kan inte best� av mer �n 50 tecken.
- Ett lanseringsdatum m�ste anges och vara p� formen yyyy-mm-dd.

N�r en konsol �r registrerade har man som admin r�ttigheter att editera eller ta
bort en konsol. Tryck p� Edit-knappen f�r att komma till redigeringssidan.

Redigera konsol

H�r visas konsolens nuvarande data och det g�r att redigera f�lten
och sedan trycka p� uppdatera f�r att verkst�lla. Man kan ocks� v�lja "cancel"
f�r att �gra sig och man tas d� till f�reg�ende sida.
Observera att samma valideringskrav g�ller f�r uppdatering som vid registrering av
ny konsol.

Man kan ta bort en konsol genom att trycka p� delete-knappen
och man f�r d� bekr�fta borttagningen via en popup.

Genom att trycka p� konsolens namn s� tas man till sidan f�r registrerade spel f�r
den konsolen "/Game/index/{console id}".
H�r kan man som admin g�ra samma saker som med konsoler. 
Det vill s�ga l�gga till, uppdatera eller ta bort.
Man kan inte ta bort en konsol om det finns registrerade spel till konsolen
