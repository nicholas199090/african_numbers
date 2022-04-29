# African Number Test

Software che consente d'importare e testare i numeri di cellulare sudafricani


## Prerequisiti
Questi sono i requisiti software necessari per poter clonare il progetto correttamente

php 7.3
mysql
npm
composer

## Installazione
``` bash
git clone https://github.com/nicholas199090/african_numbers.git
```
``` bash
composer install  
```
Rinominare il file .env.example in .env ed aggiungere i dati per la connession al db
Ora accedi alla cartella del progetto e genera la chiave segreta della tua applicazione con il comando:
``` bash
php artisan key:generate   
```
Copiare il file .env.example in .env ed aggiungere i dati per connettersi al proprio database.

Accedere al file phpunit.xml ed inserire anche qui il nome del db ed il tipo di connessione che si vuole utilizzare (nel mio caso mysql).

A questo punto utilizzare (per compilare i nostri css ed i nostri js):
``` bash
npm install 
```

``` bash
npm run dev
```

Effettuare le migrazioni del db:
``` bash
php artisan migrate
```

Ora avviare il web server di test di laravel:
``` bash
php artisan serve
```
## UNIT TEST
Ho creato una serie di test che si trovano nella cartella tests/Unit/PhoneNumberTest. Per eseguire i test è sufficiente eseguire il comando:
``` bash
php artisan test
```
## Come usare il software
Il sito è composto da due schermate:
1) Schermata principale che consente di caricare un file (.csv) per importare i numeri di telefono ed inoltre ha un form per poter testare o meno la validità di un singolo numero.
2) Schermata di riepilogo che mi mostra i numeri che sono stati importati correttamente, quelli modificati e quelli errati.

## Criterio che determina la correttezza del numero
Il numero per essere ritenuto valido deve:

1) Iniziare con il prefisso del sudafrica -> 27
2) Essere di una lunghezza totale di 11 numeri
3) Essere composto da soli numeri

## File d'importazione
Il file d'importazione utilizzato è il seguente:
[File CSV](https://docs.google.com/spreadsheets/d/1G4tfC-cM1t3XOpCZrFWaGT205kZWBlgsCzKN3nwhp3c/edit?usp=sharing)
