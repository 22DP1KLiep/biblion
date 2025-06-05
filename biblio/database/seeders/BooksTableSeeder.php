<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Genre;


class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'description' => 'Distopiska stāsts par totalitārismu un vajāšanu.',
                'image' => null,
                'published_year' => 1949,
            ],
            [
                'title' => 'Nokautēt medību putnu',
                'author' => 'Harper Lee',
                'description' => 'Romāns par rasu nevienlīdzību ASV dienvidos.',
                'image' => null,
                'published_year' => 1960,
            ],
            [
                'title' => 'Lielais Gatsbijs',
                'author' => 'F. Scott Fitzgerald',
                'description' => 'Kritika par Amerikāņu sapni 1920. gados.',
                'image' => null,
                'published_year' => 1925,
            ],
            [
                'title' => 'Leptība un aizspriedumi',
                'author' => 'Jane Austen',
                'description' => 'Klasisks romāns par mīlestību un sociālo stāvokli.',
                'image' => null,
                'published_year' => 1813,
            ],
            [
                'title' => 'Moby-Dick',
                'author' => 'Herman Melville',
                'description' => 'Stāsts par kapteini Ahaba mānīgo vajāšanu pēc milzīgā vaļa.',
                'image' => null,
                'published_year' => 1851,
            ],
            [
                'title' => 'Simts gadu vientulība',
                'author' => 'Gabriel García Márquez',
                'description' => 'Maģiskā reālisma romāns par Buendīju ģimenes uzplaukumu un sabrukumu.',
                'image' => null,
                'published_year' => 1967,
            ],
            [
                'title' => 'Karš un miers',
                'author' => 'Leo Tolstoy',
                'description' => 'Episks romāns par Krievijas sabiedrību Napoleona laikmetā.',
                'image' => null,
                'published_year' => 1869,
            ],
            [
                'title' => 'Rudzu sargi',
                'author' => 'J.D. Salinger',
                'description' => 'Stāsts par pusaudžu vientulību un nemieriem.',
                'image' => null,
                'published_year' => 1951,
            ],
            [
                'title' => 'Gredzenu pavēlnieks',
                'author' => 'J.R.R. Tolkien',
                'description' => 'Fantāzijas epopēja par cīņu starp labo un ļauno.',
                'image' => null,
                'published_year' => 1954,
            ],
            [
                'title' => 'Brāļi Karamazovi',
                'author' => 'Fyodor Dostoevsky',
                'description' => 'Filozofisks romāns par ticību, šaubām un brīvo gribu.',
                'image' => null,
                'published_year' => 1880,
            ],
            [
                'title' => 'Doktors Živago',
                'author' => 'Boris Pasternak',
                'description' => 'Romāns par mīlestību un revolūciju Krievijā.',
                'image' => null,
                'published_year' => 1957,
            ],
            [
                'title' => 'Anna Karenina',
                'author' => 'Leo Tolstoy',
                'description' => 'Romāns par mīlestību, greizsirdību un sabiedrības normas.',
                'image' => null,
                'published_year' => 1877,
            ],
            [
                'title' => 'Lolita',
                'author' => 'Vladimir Nabokov',
                'description' => 'Romāns par aizliegtu mīlestību un morāles robežām.',
                'image' => null,
                'published_year' => 1955,
            ],
            [
                'title' => 'Ulysses',
                'author' => 'James Joyce',
                'description' => 'Modernistisks romāns par vienas dienas notikumiem Dublinasā.',
                'image' => null,
                'published_year' => 1922,
            ],
            [
                'title' => 'Kāds pārlaidās pār dzeguzes ligzdu',
                'author' => 'Ken Kesey',
                'description' => 'Romāns par psihiatrisko slimnīcu un sabiedrības normas.',
                'image' => null,
                'published_year' => 1962,
            ],
            [
                'title' => 'Fahrenheit 451',
                'author' => 'Ray Bradbury',
                'description' => 'Distopiska stāsts par grāmatu aizliegšanu un cenzūru.',
                'image' => null,
                'published_year' => 1953,
            ],
            [
                'title' => 'Dzīve un liktenis',
                'author' => 'Vasilijs Grossmans',
                'description' => 'Romāns par Staļingrada kauju un cilvēka dzīvi totalitārā režīmā.',
                'image' => null,
                'published_year' => 1959,
            ],
            [
                'title' => 'Zilā putna meklējumos',
                'author' => 'Maurice Maeterlinck',
                'description' => 'Allegorisks stāsts par laimes meklējumiem.',
                'image' => null,
                'published_year' => 1908,
            ],
            [
                'title' => 'Dāma ar sunīti',
                'author' => 'Anton Čehovs',
                'description' => 'Stāsts par aizliegtu mīlestību un morāles dilemmām.',
                'image' => null,
                'published_year' => 1899,
            ],
            [
                'title' => 'Kāds skrēja pāri dzeguzes ligzdu',
                'author' => 'Ken Kesey',
                'description' => 'Romāns par psihiatrisko slimnīcu un sabiedrības normas.',
                'image' => null,
                'published_year' => 1962,
            ],
            [
                'title' => 'Svešais',
                'author' => 'Alberts Kamī',
                'description' => 'Eksistenciāls romāns par dzīves absurdu un bezjēdzību.',
                'image' => null,
                'published_year' => 1942,
            ],
            [
                'title' => 'Mīlestība Kolkasā laikā',
                'author' => 'Gabriel García Márquez',
                'description' => 'Romāns par mīlestību un likteni Kolkasā.',
                'image' => null,
                'published_year' => 1985,
            ],
            [
                'title' => 'Zvejnieka bērni',
                'author' => 'Lūcija Berķe',
                'description' => 'Stāsts par zvejnieku ģimeni un viņu dzīvi pie jūras.',
                'image' => null,
                'published_year' => 1972,
            ],
            [
                'title' => 'Mēness un ugunskurs',
                'author' => 'Jānis Jaunsudrabiņš',
                'description' => 'Romāns par lauku dzīvi un cilvēku attiecībām.',
                'image' => null,
                'published_year' => 1921,
            ],
            [
                'title' => 'Pēdējā vasara',
                'author' => 'Inese Zandere',
                'description' => 'Stāsts par mīlestību un zaudējumiem.',
                'image' => null,
                'published_year' => 2005,
            ],
            [
                'title' => 'Ziemassvētku stāsti',
                'author' => 'Rainis',
                'description' => 'Stāstu krājums par ziemassvētkiem un to nozīmi.',
                'image' => null,
                'published_year' => 1925,
            ],
            [
                'title' => 'Spoki',
                'author' => 'Rūdolfs Blaumanis',
                'description' => 'Stāsts par spokiem un cilvēku bailēm.',
                'image' => null,
                'published_year' => 1902,
            ],
            [
                'title' => 'Dzīvības koks',
                'author' => 'Anna Sakse',
                'description' => 'Romāns par dzīvi un nāvi, mīlestību un naidu.',
                'image' => null,
                'published_year' => 1934,
            ],
            [
                'title' => 'Māja pie ezera',
                'author' => 'Jānis Ezeriņš',
                'description' => 'Stāsts par māju pie ezera un tās iemītniekiem.',
                'image' => null,
                'published_year' => 1938,
            ],
            [
                'title' => 'Vēja zīmes',
                'author' => 'Vizma Belševica',
                'description' => 'Dzejoļu krājums par dzīvi un dabu.',
                'image' => null,
                'published_year' => 1965,
            ],
            [
                'title' => 'Mākslinieka dzīve',
                'author' => 'Jānis Akuraters',
                'description' => 'Romāns par mākslinieka dzīvi un viņa cīņu ar sevi.',
                'image' => null,
                'published_year' => 1920,
            ],
            [
                'title' => 'Pieci stāsti par mīlestību',
                'author' => 'Zigmunds Skujiņš',
                'description' => 'Stāstu krājums par mīlestību un tās dažādajām formām.',
                'image' => null,
                'published_year' => 1998,
            ],
            [
                'title' => 'Rīgas stāsti',
                'author' => 'Andrejs Upīts',
                'description' => 'Stāstu krājums par Rīgu un tās iedzīvotājiem.',
                'image' => null,
                'published_year' => 1940,
            ],
            [
                'title' => 'Baltā grāmata',
                'author' => 'Jānis Jaunsudrabiņš',
                'description' => 'Romāns par dzīvi un nāvi, mīlestību un naidu.',
                'image' => null,
                'published_year' => 1921,
            ],
            [
                'title' => 'Mīlestība un tumsa',
                'author' => 'Jānis Rainis',
                'description' => 'Dzejoļu krājums par mīlestību un tumsu.',
                'image' => null,
                'published_year' => 1905,
            ],
            [
                'title' => 'Pēdējā vēstule',
                'author' => 'Anna Brigadere',
                'description' => 'Stāsts par pēdējo vēstuli un tās nozīmi.',
                'image' => null,
                'published_year' => 1920,
            ],
            [
                'title' => 'Ziemas stāsti',
                'author' => 'Rūdolfs Blaumanis',
                'description' => 'Stāstu krājums par ziemu un tās burvību.',
                'image' => null,
                'published_year' => 1905,
            ],
            [
                'title' => 'Mīlestība un naids',
                'author' => 'Jānis Akuraters',
                'description' => 'Romāns par mīlestību un naidu, dzīvi un nāvi.',
                'image' => null,
                'published_year' => 1920,
            ],
            [
                'title' => 'Pieci stāsti par dzīvi',
                'author' => 'Zigmunds Skujiņš',
                'description' => 'Stāstu krājums par dzīvi un tās dažādajām formām.',
                'image' => null,
                'published_year' => 1998,
            ],
            [
                'title' => 'Rīgas stāsti',
                'author' => 'Andrejs Upīts',
                'description' => 'Stāstu krājums par Rīgu un tās iedzīvotājiem.',
                'image' => null,
                'published_year' => 1940,
            ],
            [
                'title' => 'Baltā grāmata',
                'author' => 'Jānis Jaunsudrabiņš',
                'description' => 'Romāns par dzīvi un nāvi, mīlestību un naidu.',
                'image' => null,
                'published_year' => 1921,
            ],
            [
                'title' => 'Mīlestība un tumsa',
                'author' => 'Jānis Rainis',
                'description' => 'Dzejoļu krājums par mīlestību un tumsu.',
                'image' => null,
                'published_year' => 1905,
            ],
            [
                'title' => 'Pēdējā vēstule',
                'author' => 'Anna Brigadere',
                'description' => 'Stāsts par pēdējo vēstuli un tās nozīmi.',
                'image' => null,
                'published_year' => 1920,
            ],
            [
                'title' => 'Ziemas stāsti',
                'author' => 'Rūdolfs Blaumanis',
                'description' => 'Stāstu krājums par ziemu un tās burvību.',
                'image' => null,
                'published_year' => 1905,
            ],
        ];

        DB::table('books')->insert($books);

        $allBooks = Book::all();
        $allGenres = Genre::all();

        foreach ($allBooks as $book) {
            $book->genres()->attach(
                $allGenres->random(2)->pluck('id')->toArray()
            );
        }

    }
}
