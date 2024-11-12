# Lucrarea de laborator nr. 3. Bazele lucrului cu baze de date în Laravel

## Scopul Lucrării

Familiarizarea cu principiile de bază ale lucrului cu baze de date în Laravel. Învățarea creării de migrații, modele și seed-uri pe baza aplicației web `To-Do App`.

## Condiții

În cadrul acestei lucrări de laborator, veți continua dezvoltarea aplicației `To-Do App` pentru echipe, începută în lucrările de laborator anterioare.

Veți adăuga funcționalitatea de lucru cu baza de date, veți crea modele și migrații, veți configura relațiile dintre modele și veți învăța să utilizați fabrici și seed-uri pentru generarea datelor de testare.

## №1. Pregătirea pentru lucru

## Pași realizați pentru configurarea bazei de date:

1. Instalarea MySQL pe WSL
   Am instalat MySQL pe Windows Subsystem for Linux (WSL) pentru a avea un SGBD dedicat care să ruleze pe sistemul de operare.

2. Lansarea procesului MySQL în background
   Am configurat MySQL să ruleze în background, pe portul specificat în fișierul `.env` (3306), pentru a asigura conectivitatea aplicației.

3. Configurarea variabilelor de mediu în fișierul `.env`
   În fișierul `.env`, am configurat variabilele de mediu pentru a conecta aplicația la baza de date:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=root
```

## №2. Crearea modelelor și migrațiilor

1.  Creați modelul Category — categoria unei sarcini.

        - `php artisan make:model Category -m`

    ![model_category](image.png)

2.  Definirea structurii tabelei category în migrație:

Adăugați câmpuri:

-   id — cheia primară;
-   name — numele categoriei;
-   description — descrierea categoriei;
-   created_at — data creării categoriei;
-   updated_at — data actualizării categoriei.

În interiorul fișierului de migrație pentru modelul `Category` din folderul `database/migrations`creat automat de Laravel am definit structura tabelului :

```php
public function up(): void
   {
     Schema::create('categories', function (Blueprint $table) {
         $table->id(); //cheia primara
         $table->string('name');  // numele categoriei
         $table->text('description')->nullable();  // descrierea categoriei
         $table->timestamps(); //timpul si data de actualizare
   });
   }
```

Tot odată pentru a preveni atacurile de tip _mass assignment_ am utilizat variabila `$fillable` în În modelul `Category` (fișierul `app/Models/Category.php`) pentru a specifica exact care câmpuri sunt permise pentru atribuire în masă, reducând riscul de acces neautorizat la alte câmpuri.

`protected $fillable = ['name', 'description'];`

3. Creați modelul Task — sarcina.

`php artisan make:model Task -m`

4. Definirea structurii tabelei task în migrație:

Adăugați câmpuri:

-   id — cheia primară;
-   title — titlul sarcinii;
-   description — descrierea sarcinii;
-   created_at — data creării sarcinii;
-   updated_at — data actualizării sarcinii.

```php
public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
```

Adăugaarea câmpului `$fillable` :
`protected $fillable = ['title', 'description'];`

5. Rulați migrarea pentru a crea tabelele în baza de date:

-   `php artisan migrate`

6. Creați modelul `Tag` — eticheta unei sarcini.

`php artisan make:model Tag -m`

7. Definirea structurii tabelei **tag** în migrație:

    Adăugați câmpuri:

    - id — cheia primară;
    - name — numele etichetei;
    - created_at — data creării etichetei;
    - updated_at — data actualizării etichetei.

```php
public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
```

Adăugaarea câmpului `$fillable` :
`protected $fillable = ['name'];`

8. Adăugați câmpul $fillable în modelele Task, Category și Tag pentru a permite atribuirea în masă a datelor.

## №3. Relația dintre tabele

1. Creați o migrare pentru a adăuga câmpul `category_id` în tabela _task_.

    - `php artisan make:migration add_category_id_to_tasks_table --table=tasks`
    - Definiți structura câmpului category_id și adăugați cheia externă pentru a face legătura cu tabela
      `category`.

Codul adaugat în fișierul migrației nou create în `database/migrations` :

```php
public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable(); // câmpul category_id
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null'); // cheia externă
        });
    }
```

```php
public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);  // elimină cheia externă
        $table->dropColumn('category_id');    // elimină câmpul category_id
        });
    };
```

Aceasta va adăuga câmpul `category_id` în tabela `tasks` și va crea o relație de tipul `many-to-one` între `tasks` și `categories`.

2. Creați o tabelă intermediară pentru relația de tipul multe-la-multe dintre sarcini(tasks) și etichete(tags):

    - `php artisan make:migration create_task_tag_table`

3. Definirea structurii corespunzătoare a tabelei în migrație.

    - Această tabelă trebuie să lege sarcinile și etichetele prin identificatorii lor.
    - Exemplu: `task_id` și `tag_id`: sarcina 10 este legată de eticheta 5.

```php
public function up(): void
    {
        Schema::create('task_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');  // câmpul pentru id-ul sarcinii
            $table->unsignedBigInteger('tag_id');   // câmpul pentru id-ul etichetei
            $table->timestamps();

        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade'); // relație cu tasks
        $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');   // relație cu tags

        // Definirea unui index unic pentru a preveni duplicatele
        $table->unique(['task_id', 'tag_id']);
        });
    }
```

Aceasta va crea o tabelă intermediară care leagă `tasks` și `tags` prin câmpurile `task_id` și `tag_id`. De asemenea, sunt stabilite relațiile corespunzătoare pentru ștergerea în cascadă a înregistrărilor.

4. Rulați migrarea pentru a crea tabela în baza de date.
   ![rezultate_creare_relatiitab](image-1.png)

    ![relatii_tabele](image-2.png)

## №4. Relațiile dintre modele

1. Adăugați relații în modelul `Category` (O categorie poate avea multe sarcini)

    - Deschideți modelul Category și adăugați metoda:

```php
   public function tasks()
   {
   return $this->hasMany(Task::class);
   }
```

2. Adăugați relații în modelul Task

    - Sarcina este legată de o categorie.
    - Sarcina poate avea multe etichete.

    Am adaugat relația `belongsTo` pentru a indica că o sarcină este asociată unei categorii.

    Am adaugat și relația belongsToMany pentru a lega sarcinile de etichete (relația `many-to-many`):

```php
public function category()
{
    return $this->belongsTo(Category::class);
}

public function tags()
{
    return $this->belongsToMany(Tag::class);
}
```

3. Adăugați relații în modelul Tag (O etichetă poate fi legată de multe sarcini).

    Adaugă metodei `tasks()` pentru a defini relația `many-to-many`:

    ```php
    public function tasks()
    {
     return $this->belongsToMany(Task::class);
    }

    ```

4. Adăugați câmpurile corespunzătoare în `$fillable` ale modelelor.

    - În Category.php:

`protected $fillable = ['name', 'description'];`

-   În Task.php:

`protected $fillable = ['title', 'description', 'category_id'];`

Adăugarea lui `category_id` în câmpul `$fillable` al modelului `Task` este necesară pentru că acest câmp reprezintă legătura între `Task` și `Category`.

-   În Tag.php:

`protected $fillable = ['name'];`
