1. Otvorite terminal i pozicionirajte se u direktorijum projekta , kod mene je XAMPP > htdocs.

2. Izvršite sledeću komandu kako biste instalirali sve zavisnosti projekta:
   - composer install && npm install

3. Napravite kopiju datoteke .env.example i nazovite je .env , ako vam se nije kloniramo onda napravite 
   .env text file i prekopirajte vrednosti sa .env.example na gitu

4. Izvršite sledeću komandu da generišete ključ za aplikaciju:
   - php artisan key:generate
   
5. Kreirajte novu bazu podataka u mysql (pise u .env DB_NAME, ali da ubrzamo proces baza se zove library) i podesite detalje za pristup bazi podataka u datoteci .env.

6. Izvršite sledeću komandu da izvršite migracije baze podataka:
   - php artisan migrate

7. Pokrenite seeder-e
    - php artisan db:seed
   
8. Pokrenite server
   - php artisan serve
   
9. U drugom terminalu pokrenite komandu za "watch" kako bi Vue.js komponente mogle da se prevode prilikom promene:
   - npm run watch


***  Nakon ovih koraka, projekat će biti pokrenut na vašem lokalnom računaru i biće dostupan na adresi http://localhost:8000 ***
