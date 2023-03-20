<?php

namespace Tests\Feature\Controllers\Api;

use App\Enums\Access;
use App\Models\Paste;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

/*
* Командой php artisan test происходит тестирование: 
* - доступа ко всем пастам
* - создание, чтение, изменение и удаление одной пасты
*/

class ApiPasteControllerTest extends TestCase
{
    protected $user;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        parent::setUp();

        $this->user = User::where('name', 'admin')->first();
    }

    public function testPaginate()
    {
        $response = $this->json(
            'GET',
            route('api.pastes')
            . "?api_token={$this->user->api_token}"
        );

        $response->assertStatus(200);
        echo "\n\t\tTest Paginate status 200\n\n";
    }

    public function testCreate()
    {
        $response = $this->json(
            'POST',
            route('api.pastes.create')
            . "?api_token={$this->user->api_token}",
            [
                'created_by_id' => $this->user->id,
                'expiration_time' => null,
                'access'  => Access::PUBLIC,
                'paste_hash'  => Str::random(),
                'locale'  =>  'php',
                'paste'  =>  'test paste',
            ]
        );

        $response->assertStatus(200);
        echo "\n\t\tTest create status 200, data sent\n\n";
    }

    public function testDetail()
    {
        $testPaste = Paste::latest()->first();

        $response = $this->json(
            'GET',
            route('api.pastes.detail')
            .'?api_token='. $this->user->api_token
            . '&pasteHash=' . $testPaste->paste_hash
        );

        $response->assertStatus(200);
        echo "\n\t\tTest last detail status 200\n\n";
        dump($response->json());
    }

    public function testRemove()
    {
        $testPaste = Paste::latest()->first();

        $response = $this->json(
            'POST',
            route('api.pastes.remove')
            .'?api_token='. $this->user->api_token
            . '&pasteHash=' . $testPaste->paste_hash
        );

        $response->assertStatus(200);
        echo "\n\t\tTest delete status 200, data delete\n\n";
    }
}
