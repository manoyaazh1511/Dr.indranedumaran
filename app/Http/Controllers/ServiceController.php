<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Post;
use App\Models\PregnancyStage;
use App\Models\Service;
use App\Support\Seo;

class ServiceController extends Controller
{
    private const PAGES = [
        'fertility' => ['title' => 'Fertility care', 'intro' => 'Gentle, structured support whether you are planning a pregnancy, have been trying for a while, or are living with a condition such as PCOS.', 'desc' => 'Fertility assessment, PCOS care and fertility treatment options explained by Dr. Indhra Nedumaran.'],
        'gynaecology' => ['title' => 'Gynaecology', 'intro' => 'Diagnosis and treatment of conditions affecting the female reproductive system — with clear explanations at every step.', 'desc' => 'Gynaecological disorders, procedures and menopause care with Dr. Indhra Nedumaran.'],
        'maternity' => ['title' => 'Pregnancy & maternity care', 'intro' => 'Support before, during and after pregnancy: antenatal check-ups, birth planning and postpartum recovery.', 'desc' => 'Prenatal care, birth planning and postpartum support with Dr. Indhra Nedumaran.'],
    ];

    public function index(string $section)
    {
        $page = self::PAGES[$section] ?? abort(404);

        if ($section === 'fertility') {
            return $this->fertility($page);
        }

        return view('pages.services', [
            'section' => $section, 'page' => $page,
            'services' => Service::published()->where('section', $section)->get(),
            'faqs' => Faq::published()->where('section', $section)->whereNull('service_id')->get(),
            'stages' => $section === 'maternity' ? PregnancyStage::published()->get() : collect(),
            'seo' => Seo::make($page['title'], $page['desc']),
        ]);
    }

    public function show(string $slug, string $section)
    {
        abort_unless(isset(self::PAGES[$section]), 404);
        $service = Service::published()->where('section', $section)->where('slug', $slug)->firstOrFail();

        return view('pages.service', [
            'section' => $section, 'page' => self::PAGES[$section], 'service' => $service,
            'faqs' => $service->faqs()->get(),
            'posts' => $section === 'fertility' ? $this->fertilityPosts(3) : collect(),
            'others' => Service::published()->where('section', $section)->whereKeyNot($service->id)->limit(4)->get(),
            'seo' => Seo::make($service->meta_title ?: $service->title, $service->meta_description ?: $service->summary, media_url($service->image), 'article'),
        ]);
    }

    private function fertility(array $page)
    {
        $all = Service::published()->where('section', 'fertility')->with('faqs')->get();
        $treatments = $all->where('kind', 'treatment')->values();

        return view('pages.fertility', [
            'page' => $page,
            'highlights' => $treatments->whereIn('slug', ['ivf', 'iui'])->values(),
            'treatments' => $treatments->whereNotIn('slug', ['ivf', 'iui'])->values(),
            'conditions' => $all->where('kind', 'condition')->values(),
            'faqs' => Faq::published()->where('section', 'fertility')->whereNull('service_id')->get(),
            'posts' => $this->fertilityPosts(6),
            'seo' => Seo::make('Fertility & reproductive care', 'Educational guide to IVF, IUI, ICSI, ovulation induction, fertility assessment and preservation, PCOS, endometriosis, male-factor infertility and recurrent pregnancy loss.', asset('images/articles/understanding-the-ivf-journey-from-consultation-to-pregnancy-test.webp')),
        ]);
    }

    private function fertilityPosts(int $limit)
    {
        return Post::published()->with('category')
            ->whereHas('category', fn ($q) => $q->where('slug', 'fertility'))
            ->latest('published_at')->limit($limit)->get();
    }
}