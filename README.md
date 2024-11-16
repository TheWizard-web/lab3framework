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

## №5. Crearea fabricilor și seed-urilor

1. Creați o fabrică pentru modelul `Category`:

    - `php artisan make:factory CategoryFactory --model=Category`
    - Definiți structura datelor pentru generarea categoriilor.

```php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}

```

Acest cod va genera 10 categorii fictive, fiecare cu câmpurile `name` și `description` completate automat folosind `Faker`.

2. Creați o fabrică pentru modelul `Task`.
   `php artisan make:factory TaskFactory --model=Task`

```php
namespace Database\Factories;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'category_id' => Category::factory(), // Asociere cu o categorie generată
        ];
    }
}

```

Acest cod va genera 10 sarcini, fiecare având câmpurile `title` și `description` completate și asociate unei categorii fictive prin `category_id`.

3. Creați o fabrică pentru modelul `Tag`.
   `php artisan make:factory TagFactory --model=Tag`

```php
namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}

```

Acest cod va genera 10 tag-uri, fiecare având câmpul `name` completat cu un cuvânt fictiv.

4. Creați seed-uri pentru a popula tabelele cu date inițiale pentru modelele `Category`, `Task`, `Tag`.

`php artisan make:seeder CategorySeeder`

```php
use App\Models\Category;

public function run()
{
    Category::factory()->count(10)->create();
}

```

`php artisan make:seeder TaskSeeder`

```php
use App\Models\Task;

public function run()
{
    Task::factory()->count(50)->create();
}

```

`php artisan make:seeder TagSeeder`

```php
use App\Models\Tag;

public function run()
{
    Tag::factory()->count(20)->create();
}

```

5. Actualizați fișierul `DatabaseSeeder` pentru a lansa seed-urile și rulați-le:

```php
use Illuminate\Database\Seeder;

use App\Models\Category;
use App\Models\Task;
use App\Models\Tag;

public function run()
{
    $this->call([
        CategorySeeder::class,
        TaskSeeder::class,
        TagSeeder::class,
    ]);
}

```

`php artisan db:seed`

Urmând acești pași am creat date fictive pentru modelele `Category`, `Task` și `Tag` în baza de date, pentru a putea lucra cu ele mai departe în aplicație.

## №6. Lucrul cu controlere și vizualizări

1. Deschideți controlerul `TaskController` (`app/Http/Controllers/TaskController.php`).

2. Actualizați metoda index pentru a obține lista sarcinilor din baza de date.

    - Folosiți modelul `Task` pentru a obține toate sarcinile.

Inițial, metoda `index` folosea o listă statică de sarcini (un array definit manual) pentru a trimite datele către vizualizare. Codul inițial arăta astfel:

```php
public function index()
{
    $tasks = [
        ['id' => 1, 'title' => 'Cumpărături'],
        ['id' => 2, 'title' => 'Spălat mașina'],
        ['id' => 3, 'title' => 'Finalizat proiect'],
    ];

    return view('tasks.index', ['tasks' => $tasks]);
}

```

Aceasta afișa datele din array în vizualizarea `tasks.index`.

După modificare, metoda index arată astfel:

```php
public function index()
{
    $tasks = Task::with(['category', 'tags'])->get();

    return view('tasks.index', compact('tasks'));
}

```

În aceast mod:

-   Array-ul static a fost înlocuit cu datele obținute din baza de date.
-   Metoda încearcă să preia toate sarcinile existente din tabelul `tasks` din baza de date (inclusiv relațiile `category` și `tags`).

3. Actualizați metoda `show` pentru a afișa o sarcină individuală.

    - Afișați informațiile despre sarcină după identificatorul acesteia.
    - **Obligatoriu** afișați categoria și etichetele sarcinii.

Codul original al metodei `show`:

```php
public function show($id)
{
    $task = [
        'id' => $id,
        'title' => 'Titlul sarcinii',
        'description' => 'Aceasta este descrierea detaliată a sarcinii.',
        'created_at' => now()->subDays(2)->format('d-m-Y'),
        'updated_at' => now()->format('d-m-Y'),
        'status' => false, // sarcina nu este finalizată
        'priority' => 'medie',
        'assigned_to' => 'John Doe'
    ];

    return view('tasks.show', ['task' => $task]);
}

```

În acest caz:

-   Sarcina era definită manual ca un array static, folosind `$id` ca identificator.
-   Detaliile (cum ar fi titlul, descrierea, data creării etc.) erau pur fictive și hardcodate în metoda `show`.
-   Nu se folosea deloc baza de date, iar datele erau mereu aceleași pentru orice `id`.

După modificare, metoda `show` folosește modelul `Task` pentru a obține datele unei sarcini din baza de date:

```php
public function show($id)
{
    $task = Task::with(['category', 'tags'])->findOrFail($id);

    return view('tasks.show', compact('task'));
}

```

Acum:

-   **Datele sunt preluate din baza de date**:
    În loc să folosească un array static, metoda folosește modelul `Task` pentru a găsi sarcina cu ID-ul specificat în baza de date.

-   **Relațiile sunt încărcate**:
    Folosind `with(['category', 'tags'])`, metoda adaugă și datele din tabelele asociate (`category` și `tags`), ceea ce permite accesarea informațiilor suplimentare despre sarcină.

-   **Gestionează erorile automat**:
    Metoda `findOrFail($id)` verifică dacă sarcina cu ID-ul specificat există. Dacă nu există, Laravel va arunca automat o eroare 404 (Not Found).

4. În metodele `index` și `show`, folosiți metoda with (**Eager Loading**) pentru a încărca modelele asociate.

La punctele anterioare am folosit`with(['category', 'tags'])` pentru a încărca relațiile. Acesta este un exemplu de Eager Loading care reduce numărul de interogări și aduce datele asociate într-o singură interogare.

5. Actualizați vizualizările corespunzătoare pentru a afișa lista de sarcini și o sarcină individuală.

Inițial, fișierul`index.blade.php`afișa doar titlul sarcinilor preluate dintr-un array static. După modificările în controler, datele sunt acum preluate din baza de date, iar fiecare sarcină conține relațiile sale.

În urma modificărilor:

-   **Accesarea relațiilor `category` și `tags`**:
    Am adăugat afișarea categoriei și a etichetelor pentru fiecare sarcină. Relațiile sunt accesibile acum datorită `with(['category', 'tags'])` din metoda `index` din `TaskController`.

```php
<p><strong>Category:</strong> {{ $task->category->name ?? 'None' }}</p>
@foreach ($task->tags as $tag)
    <span>{{ $tag->name }}</span>
@endforeach

```

-   **Datele sunt dinamice, nu statice**:
    În versiunea veche, sarcinile erau hardcodate ca un array static. Acum, sarcinile sunt preluate din baza de date, iar accesul la date se face prin obiectele returnate de model.

```php
<a href="{{ route('tasks.show', $task->id) }}">
    {{ $task->title }}
</a>

```

-   **Schimbarea modului de iterare**:
    Iterația inițială folosea $task['title'] pentru a accesa datele din array-uri. Acum, folosim `$task->title`, deoarece datele sunt obiecte Eloquent și nu array-uri.

```php
@foreach ($tasks as $task)
    {{ $task->title }}
@endforeach

```

-   **Verificarea relațiilor goale**:
    Pentru a preveni erorile în cazul în care o sarcină nu are o categorie asociată, am adăugat o verificare pentru a afișa "None" dacă relația `category` este null.

```php
{{ $task->category->name ?? 'None' }}

```

Inițial fișierul `show.blade.php` este destinat afișării unei liste de sarcini (similar cu `index.blade.php`), așa că trebuie să-l rescriem pentru afișarea unei singure sarcini. Conform noilor cerințe, trebuie să-l transformăm astfel încât să afișeze detaliile unei sarcini individuale ('$task') și să integreze datele din relațiile `category` și `tags`.

În urma modificărilor:

-   **Schimbarea scopului vizualizării**:

Fișierul inițial afișa o listă de sarcini printr-un loop (`@foreach`). Pentru `show.blade.php`, trebuie să afișăm detaliile unei singure sarcini (`$task`), deoarece metoda `show` din controller transmite un singur obiect în view.

-   **Afișarea atributelor individuale**:

Titlul și descrierea sarcinii: Sunt afișate utilizând proprietățile modelului `$task`.

```php
<h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $task->title }}</h1>
<p class="text-gray-600 mb-4">{{ $task->description }}</p>
```

-   **Categoria sarcinii**:
    Relația `category` este accesată prin `$task->category->name`, iar dacă sarcina nu are categorie, se afișează `None` folosind operatorul null coalescing (`??`).

```php
<p><strong>Category:</strong> {{ $task->category->name ?? 'None' }}</p>
```

-   **Afișarea etichetelor (tags)**:

Etichetele sunt afișate sub formă de "bule" stilizate folosind un loop (`@foreach`) și clase CSS.
blade

```php
@foreach ($task->tags as $tag)
    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">{{ $tag->name }}</span>
@endforeach
```

-   **Datele de creare și actualizare**:

Folosim `created_at` și `updated_at` pentru a afișa datele formatate corespunzător. Metoda `format('d-m-Y H:i')` convertește timestamp-ul într-un format ușor de citit.
``php

<p><strong>Created at:</strong> {{ $task->created_at->format('d-m-Y H:i') }}</p>
<p><strong>Last updated:</strong> {{ $task->updated_at->format('d-m-Y H:i') }}</p>
```

**Conceptele de separare a responsabilităților (Single Responsibility)**

-   Fiecare vizualizare (`index`, `show`, etc.) are un scop clar.
-   `index.blade.php`: este destinat afișării listei de sarcini.
-   `show.blade.php`: este destinat afișării unei sarcini individuale.
    Dacă încercăm să îmbinăm ambele funcționalități (să afișăm și lista de sarcini printr-un `@foreach`, și detaliile unei singure sarcini (`$task`) simultan) într-un singur fișier (`show.blade.php`), încalcăm principiul separării responsabilităților, ceea ce duce la confuzie și cod greu de întreținut.

6. Actualizați metoda create pentru a afișa formularul de creare a unei sarcini și metoda store pentru a salva o sarcină nouă în baza de date.

    - **Notă**: Deoarece nu ați studiat încă formularele, folosiți obiectul Request pentru a obține datele. **De exemplu**:

```php
$request->input('title');
// sau
$request->all();
```

7. Actualizați metoda `edit` pentru a afișa formularul de editare a unei sarcini și metoda `update` pentru a salva modificările în baza de date.

8. Actualizați metoda `destroy` pentru a șterge o sarcină din baza de date.

## Sarcini Suplimentare

1. Creați modelul `Comment` pentru comentariile sarcinilor.

    - Adăugați câmpurile corespunzătoare în migrare.
    - Creați relații între modelele Task și Comment.

2. Adăugați posibilitatea de a adăuga comentarii la sarcini.

    - Actualizați vizualizarea pentru a afișa comentariile unei sarcini și pentru a vizualiza lista de comentarii și comentariul după `id`: `/task/{id}/comment, /task/{id}/comment/{comment_id}`.

3. Adăugați posibilitatea de a adăuga etichete la sarcini și folosiți tranzacții pentru a salva relațiile dintre sarcini și etichete.

```php
DB::transaction(function () use ($request) {
    // Crearea sarcinii
    // Legarea etichetelor la sarcină
});
```

## Întrebări de control

1. Ce sunt migrațiile și la ce se folosesc?

    - Migrațiile sunt fișiere care permit modificarea structurii bazei de date într-un mod controlat și ușor de urmărit. Acestea sunt folosite pentru a adăuga, modifica sau șterge tabele și coloane, asigurându-se că baza de date poate fi actualizată pe parcursul dezvoltării aplicației.

2. Ce sunt fabricile și seed-urile și cum simplifică procesul de dezvoltare și testare?

    - Fabricile sunt folosite pentru a crea date fictive pentru modelele tale. Seed-urile sunt folosite pentru a popula baza de date cu date de test sau cu date inițiale. Acestea simplifică dezvoltarea și testarea prin generarea rapidă a datelor necesare fără a fi nevoie să le introduci manual.

3. Ce este ORM? Care sunt diferențele dintre pattern-urile `DataMapper` și `ActiveRecord`?

    - ORM (Object-Relational Mapping) este o tehnică care permite interacționarea cu baza de date folosind obiecte în loc de interogări SQL.

    **ActiveRecord** combină logica aplicației cu manipularea datelor. Fiecare obiect reprezintă un rând dintr-o tabelă.

    **DataMapper** separă logica aplicației de manipularea datelor. Obiectele sunt separate de structura bazei de date.

4. Care sunt avantajele utilizării unui ORM comparativ cu interogările SQL directe?

    - Utilizarea unui ORM ajută la simplificarea interacțiunii cu baza de date, oferind un mod mai intuitiv și mai sigur de a lucra cu datele, fără a scrie manual interogări SQL. Acesta reduce erorile, îmbunătățește lizibilitatea codului și face aplicația mai ușor de întreținut.

5. Ce sunt tranzacțiile și de ce sunt importante în lucrul cu bazele de date?

    - Tranzacțiile sunt un set de operațiuni care sunt executate împreună. Dacă oricare dintre aceste operațiuni eșuează, toate sunt anulate, pentru a păstra integritatea bazei de date. Sunt importante pentru a asigura că datele rămân consistente și corecte, chiar și în caz de erori sau probleme.
