<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ServiceController extends CrudController
{
    protected string $model = Service::class;

    protected string $route = 'admin.services';

    protected string $title = 'Services';

    protected string $singular = 'service';

    protected string $orderBy = 'section';

    protected bool $reorderable = true;

    protected string $orderDir = 'asc';

    protected function defaults(): array
    {
        return ['is_published' => true, 'section' => 'gynaecology', 'kind' => 'treatment', 'is_educational' => true];
    }

    protected function filters(): array
    {
        return ['section' => ['label' => 'All sections', 'options' => Service::SECTIONS]];
    }

    protected function columns(): array
    {
        return [
            ['Title', fn ($s) => $s->title],
            ['Section', fn ($s) => Service::SECTIONS[$s->section] ?? $s->section],
            ['Type', fn ($s) => $s->section === 'fertility' ? ucfirst($s->kind) : '—'],
            ['Home', fn ($s) => $s->is_featured ? 'Featured' : '—'],
            ['Order', fn ($s) => $s->sort_order],
            ['Status', fn ($s) => $s->is_published ? 'published' : 'draft', 'badge'],
        ];
    }

    protected function fields(): array
    {
        return array_merge([
            ['name' => 'section', 'label' => 'Section', 'type' => 'select', 'options' => Service::SECTIONS, 'rules' => 'required|in:'.implode(',', array_keys(Service::SECTIONS))],
            ['name' => 'kind', 'label' => 'Fertility type', 'type' => 'select', 'options' => ['treatment' => 'Treatment', 'condition' => 'Condition / evaluation'], 'rules' => 'required|in:treatment,condition', 'help' => 'Only used for the Fertility section.'],
            ['name' => 'title', 'label' => 'Title', 'rules' => 'required|max:200'],
            ['name' => 'slug', 'label' => 'URL slug', 'rules' => 'nullable|max:200'],
            ['name' => 'icon', 'label' => 'Icon key', 'type' => 'select', 'options' => collect(['heart', 'search', 'flower', 'drop', 'calendar', 'shield', 'sparkle', 'baby', 'scope', 'sun', 'leaf', 'chat'])->mapWithKeys(fn ($i) => [$i => ucfirst($i)])->all(), 'rules' => 'nullable|max:30', 'blank' => 'Default'],
            ['name' => 'summary', 'label' => 'Summary', 'type' => 'textarea', 'rows' => 3, 'rules' => 'nullable|max:500'],
            ['name' => 'body', 'label' => 'Detailed content', 'type' => 'richtext', 'rules' => 'nullable'],
            ['name' => 'image', 'label' => 'Image', 'type' => 'image'],
            ['name' => 'who_for', 'label' => 'Who may benefit (one per line)', 'type' => 'textarea', 'rows' => 5, 'rules' => 'nullable|max:3000'],
            ['name' => 'steps', 'label' => 'Basic procedure steps (one per line)', 'type' => 'textarea', 'rows' => 6, 'rules' => 'nullable|max:3000'],
            ['name' => 'considerations', 'label' => 'Considerations (one per line)', 'type' => 'textarea', 'rows' => 5, 'rules' => 'nullable|max:3000'],
            ['name' => 'sort_order', 'label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer|min:0'],
            ['name' => 'is_featured', 'label' => 'Feature on homepage (fertility cards)', 'type' => 'toggle'],
            ['name' => 'is_educational', 'label' => 'Educational information only (not confirmed as offered by the doctor)', 'type' => 'toggle'],
            ['name' => 'is_published', 'label' => 'Published', 'type' => 'toggle'],
        ], $this->seo());
    }

    public function move(Request $request, int $id): RedirectResponse
    {
        $service = Service::findOrFail($id);
        $list = Service::where('section', $service->section)->orderBy('sort_order')->orderBy('id')->get()->values();
        $i = $list->search(fn ($s) => $s->id === $service->id);
        $j = $request->input('dir') === 'up' ? $i - 1 : $i + 1;
        if (isset($list[$j])) {
            $swap = $list->all();
            [$swap[$i], $swap[$j]] = [$swap[$j], $swap[$i]];
            foreach ($swap as $n => $s) {
                if ($s->sort_order !== $n) {
                    $s->update(['sort_order' => $n]);
                }
            }
            $this->flush();
        }

        return back();
    }
}