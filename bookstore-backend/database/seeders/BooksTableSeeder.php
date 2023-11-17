<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        $path = 'https://fakerapi.it/api/v1/books?_quantity=100';
        $data = file_get_contents($path);

        $books = json_decode($data, true);

        foreach ($books['data'] as $bookData) {
            Book::create($bookData);
        }
    }
}
