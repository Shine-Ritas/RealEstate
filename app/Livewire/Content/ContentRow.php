<?php

namespace App\Livewire\Content;

use App\Models\Content;
use Livewire\Component;

class ContentRow extends Component
{
    public Content $content;

    public string $en;

    public string $th;

    public string $my;

    public string $zh;

    public function mount(Content $content)
    {
        $this->content = $content;

        $this->en = $content->en;
        $this->th = $content->th;
        $this->my = $content->my;
        $this->zh = $content->zh;
    }

    protected function rules()
    {
        return [
            'en' => 'required',
            'th' => 'required',
            'my' => 'required',
            'zh' => 'required',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->content->update([
            'en' => $this->en,
            'th' => $this->th,
            'my' => $this->my,
            'zh' => $this->zh,
            'label' => $this->en
        ]);

        $this->dispatch('notify', [
            'variant' => 'success',
            'title' => 'success',
            'message' => 'Updated Successfully !',
        ]);
    }

    public function render()
    {
        return view('livewire.content.content-row');
    }
}
