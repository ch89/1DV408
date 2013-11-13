# Driftsättning

Följande filer ska laddas upp via FTP

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

Databasen ska bestå av 3 tabeller.

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

Som besökare har man endast rättigheter till att se registrerade
konsoler samt tillhörande spel. Man kan söka i databasen efter registrerade
spel. Sökformulär finns på sidan "/Search" som man kommer till om man trycker på
Search-länken. Observera att inte alla fält behöver fyllas i.

Som Admin kan man lägga till en konsol genom att trycka på knappen
"Register console" som finns på förstasidan "/"

Lägga till konsol
- Ett konsolnamn måste anges och kan inte bestå av mer än 50 tecken.
- En utvecklare måste anges och kan inte bestå av mer än 50 tecken.
- Ett lanseringsdatum måste anges och vara på formen yyyy-mm-dd.

När en konsol är registrerade har man som admin rättigheter att editera eller ta
bort en konsol. Tryck på Edit-knappen för att komma till redigeringssidan.

Redigera konsol

Här visas konsolens nuvarande data och det går att redigera fälten
och sedan trycka på uppdatera för att verkställa. Man kan också välja "cancel"
för att ågra sig och man tas då till föregående sida.
Observera att samma valideringskrav gäller för uppdatering som vid registrering av
ny konsol.

Man kan ta bort en konsol genom att trycka på delete-knappen
och man får då bekräfta borttagningen via en popup.

Genom att trycka på konsolens namn så tas man till sidan för registrerade spel för
den konsolen "/Game/index/{console id}".
Här kan man som admin göra samma saker som med konsoler. 
Det vill säga lägga till, uppdatera eller ta bort.
Man kan inte ta bort en konsol om det finns registrerade spel till konsolen
