<?php

namespace Tests\Feature;

use App\Models\Specialist;
use App\Models\User;
use Database\Seeders\DocumentSeeder;
use Database\Seeders\TestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentTest extends TestCase
{
   use RefreshDatabase;
    public function test_specialist_can_store_documents(): void
    {
        Storage::fake('protected');
        $this->seed(TestSeeder::class);
        $user=User::has('specialist')->firstOrFail();
        $specialist = $user->specialist;
        $document1=UploadedFile::fake()->create('document.pdf', 1000);
        $document2=UploadedFile::fake()->create('document2.pdf', 1000);
        $imagecument=UploadedFile::fake()->image('document2.jpg')->size(1000);
        $response = $this->from('/test/route')->actingAs($user)->post(route('document.store'),[ 'files'=>[
            $document1,
            $document2,
            $imagecument
        ]]);
        $response->assertRedirect('/test/route')
        ->assertSessionHas('message', ['text' => 'Dodano pliki.', 'status' => 'success']);
        $specialist->refresh();
        $documents = $specialist->documents()->get();

        $this->assertCount(3,$documents);
        foreach($documents as $document)
        {
            Storage::disk('protected')->assertExists($document->path);
        }

        
    }

    public function test_user_can_delete_file()
    {
        Storage::fake('protected');
        $this->seed(TestSeeder::class);
        $user=User::has('specialist')->firstOrFail();
        $specialist = $user->specialist;
        $this->seed(DocumentSeeder::class);
        $document=$specialist->documents()->firstOrFail();

        $response = $this->from('/test/route')->actingAs($user)->delete(route('document.destroy',$document->id));
      
        $response->assertRedirect('/test/route')
        ->assertSessionHas('message', ['text' => 'Usunięto plik.', 'status' => 'success']);

        Storage::disk('protected')->assertMissing($document->path);
        $this->assertModelMissing($document);
    }

    public function test_user_can_download_file()
    {
        Storage::fake('protected');
        $this->seed(TestSeeder::class);
        $user=User::has('specialist')->firstOrFail();
        $specialist = $user->specialist;
        $this->seed(DocumentSeeder::class);
        $document=$specialist->documents()->firstOrFail();

        $response = $this->from('/test/route')->actingAs($user)->get(route('document.download',$document->id));

        $response->assertStreamedContent(Storage::disk('protected')->get($document->path));
    }
    public function test_user_cannot_download_other_user_file()
    {
        Storage::fake('protected');
        $this->seed(TestSeeder::class);
        $user=User::has('specialist')->firstOrFail();
        $specialist = $user->specialist;
        $this->seed(DocumentSeeder::class);
        $document=$specialist->documents()->firstOrFail();
        $otherUser=User::factory()->has(Specialist::factory())->create();
        $response = $this->from('/test/route')->actingAs($otherUser)->get(route('document.download',$document->id));

        $response->assertUnauthorized();
    }
}
