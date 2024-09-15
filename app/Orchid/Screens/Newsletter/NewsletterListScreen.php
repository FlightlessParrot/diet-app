<?php

namespace App\Orchid\Screens\Newsletter;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return ['downloadSpecialists'=>Storage::disk('protected')->url('newsletter/specjalisci.txt')];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'NewsletterListScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [Button::make('Generuj pliki z newsletterem')->method('write')];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Button::make('Pobierz plik z emailami specjalistów')->method('downloadSpecialists')->turbo(false)
            ]),
            Layout::rows([
                Button::make('Pobierz plik z emailami pacjentów')->method('downloadClients')->turbo(false)
            ]),

        ];
    }

    public function write(): void 
    {
        
        $specialists=User::has('specialist')->get()->map(fn(User $user)=>$user->email)->toArray();
        
        $clients=User::doesntHave('specialist')->get()->map(fn(User $user)=>$user->email)->toArray();
        Storage::disk('protected')->put('newsletter/specjalisci.txt',implode(',',$specialists));
        Storage::disk('protected')->put('newsletter/pacjenci.txt',implode(',',$clients));

        Toast::success('Wygenerowano nowe pliki.');
    }

    public function downloadSpecialists():StreamedResponse
    {
        return Storage::disk('protected')->download('newsletter/specjalisci.txt');
    }

    public function downloadClients():StreamedResponse
    {
        return Storage::disk('protected')->download('newsletter/pacjenci.txt');
    }
}
