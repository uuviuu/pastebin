<?php

namespace Tests\Feature\Controllers;

use App\Models\Paste;
use Tests\TestCase;

/*
* Командой php artisan test происходит тестирование: 
*  - доступа ко всем книгам
*  - создание, чтение, изменение и удаление одной книги
*/

class PasteControllerTest extends TestCase
{
    public function testIndex()
    {
        $response = $this->get('/api/pastes');
        $response->assertStatus(200);
        echo "\n\t\tTest index status 200\n\n";
    }
    public function testCreate()
    {
        $response = $this->json(
            'POST',
            '/api/pastes',
            [
                'title' => 'create_title',
                'author' => 'create_author',
                'year_of_publication'  => 2022,
                'description'  => 'create_description',
                'ISBN'  =>  'create_' . random_int(1, 2000),
            ]
        );
        $response->assertStatus(200);
        echo "\n\t\tTest create status 200, data sent\n\n";
    }
    public function testDetail()
    {
        $last_paste = Paste::latest()->first()['id'];
        $response = $this->get('/api/pastes/' . $last_paste);
        $response->assertStatus(200);
        echo "\n\t\tTest last detail status 200\n\n";
        dump($response->json());
    }
    public function testUpdate()
    {
        $last_paste = Paste::latest()->first()['id'];
        $response = $this->json(
            'PUT',
            '/api/pastes/' . $last_paste,
            [
                'title' => 'update_title',
                'author' => 'update_author',
                'year_of_publication'  => 2023,
                'description'  => 'update_description',
                'ISBN'  =>  'update_' . random_int(1, 2000),
            ]
        );
        $response->assertStatus(200);
        echo "\n\t\tTest update status 200, data update\n\n";
        dump($response->json());
    }
    public function testDelete()
    {
        $last_paste = Paste::latest()->first()['id'];
        $response = $this->delete('/api/pastes/' . $last_paste);
        $response->assertStatus(204);
        echo "\n\t\tTest delete status 200, data delete\n\n";
    }
}
