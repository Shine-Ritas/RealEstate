<?php

namespace App\Livewire\Helper;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public string $currentLocale = '';

    /**
     * @var array<string, array{name: string, native: string, flag: string}>
     */
    public array $languages = [
        'en' => ['name' => 'English',  'native' => 'English',  'flag' => '🇬🇧'],
        'my' => ['name' => 'Myanmar',  'native' => 'မြန်မာ',     'flag' => '🇲🇲'],
        'th' => ['name' => 'Thai',     'native' => 'ไทย',        'flag' => '🇹🇭'],
        'zh' => ['name' => 'Chinese',  'native' => '中文',       'flag' => '🇨🇳'],
    ];

    public function mount(): void
    {
        $this->currentLocale = App::currentLocale();
    }

    public function switchLanguage(string $locale): Redirector|RedirectResponse|null
    {
        if (array_key_exists($locale, $this->languages)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            $this->currentLocale = $locale;

            // Optional: redirect to same page to refresh translations
            return redirect()->to(request()->header('Referer') ?? '/');
        }

        return null;
    }

    public function render(): View
    {
        return view('livewire.helper.language-switcher');
    }
}
