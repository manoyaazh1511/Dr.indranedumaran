<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Educational fertility content. Safe to re-run: records are matched by slug / question,
 * and existing admin edits to services are overwritten only for the seeded slugs.
 * Run alone with: php artisan db:seed --class=FertilitySeeder
 */
class FertilitySeeder extends Seeder
{
    public function run(): void
    {
        Service::where('slug', 'fertility-treatments')->delete();

        foreach ($this->services() as $i => $s) {
            $service = Service::updateOrCreate(['slug' => $s['slug']], [
                'section' => 'fertility',
                'kind' => $s['kind'],
                'title' => $s['title'],
                'icon' => $s['icon'],
                'summary' => $s['summary'],
                'body' => '<p>'.implode('</p><p>', $s['body']).'</p>',
                'who_for' => implode("\n", $s['who']),
                'steps' => implode("\n", $s['steps']),
                'considerations' => implode("\n", $s['cons']),
                'is_featured' => $s['featured'] ?? false,
                'is_educational' => true,
                'is_published' => true,
                'sort_order' => $i,
                'meta_title' => Str::limit($s['title'].' explained', 70, ''),
                'meta_description' => Str::limit($s['summary'], 155),
            ]);
            foreach ($s['faqs'] as $j => [$q, $a]) {
                Faq::updateOrCreate(['service_id' => $service->id, 'question' => $q], ['answer' => $a, 'section' => 'fertility', 'sort_order' => $j, 'is_published' => true]);
            }
        }

        foreach ([
            ['Are fertility treatments guaranteed to work?', 'No. Outcomes depend on age, the cause of infertility, ovarian reserve, sperm quality and many other factors. A doctor can explain what may be realistic for your situation.'],
            ['When should we see a doctor about conceiving?', 'Generally after 12 months of trying, or after 6 months if the woman is 35 or older. Earlier review is sensible with irregular periods, known conditions or previous pelvic surgery.'],
            ['Does infertility affect only women?', 'No. In roughly a third of couples a male factor is involved, and in some couples both partners contribute. That is why assessment usually includes both partners.'],
            ['Can lifestyle changes help?', 'Healthy weight, balanced nutrition, regular activity, not smoking and limiting alcohol can support general reproductive health. They are often discussed alongside medical assessment.'],
            ['Does Dr. Indhra Nedumaran offer every treatment described here?', 'The treatment pages are educational. Please contact the clinic to confirm which investigations and treatments are available and where they are provided.'],
        ] as $i => [$q, $a]) {
            Faq::updateOrCreate(['question' => $q, 'service_id' => null], ['answer' => $a, 'section' => 'fertility', 'sort_order' => $i, 'is_published' => true]);
        }

        $this->posts();
    }

    private function services(): array
    {
        return [
            [
                'slug' => 'ivf', 'kind' => 'treatment', 'icon' => 'flask', 'featured' => true,
                'title' => 'IVF – In Vitro Fertilisation',
                'summary' => 'Eggs and sperm are combined in a laboratory before an embryo is transferred into the uterus.',
                'body' => ['In vitro fertilisation (IVF) is a form of assisted reproduction. Eggs are collected from the ovaries and combined with sperm in a laboratory. Any resulting embryo is grown for a few days and then placed in the uterus, with the aim of a pregnancy.', 'IVF is usually considered after simpler options, or when specific factors such as blocked tubes, significant male-factor infertility or advanced age make other treatments less likely to help. It is carried out in a licensed fertility laboratory.'],
                'who' => ['Blocked or damaged fallopian tubes', 'Endometriosis that has not responded to other care', 'Reduced egg quality or ovarian reserve', 'Male-factor infertility (often with ICSI)', 'Unexplained infertility after other treatments'],
                'steps' => ['Consultation and fertility assessment', 'Ovarian stimulation with injectable medicines and monitoring scans', 'Egg collection under sedation', 'Fertilisation of eggs with sperm in the laboratory', 'Embryo culture for several days', 'Embryo transfer into the uterus', 'Pregnancy blood test about two weeks later'],
                'cons' => ['Success rates vary widely with age and cause; no outcome can be guaranteed', 'Hormone injections can cause bloating, mood changes and, rarely, ovarian hyperstimulation', 'Multiple pregnancy risk is reduced by transferring a single embryo where suitable', 'Treatment involves time, cost and emotional demands, and counselling can help'],
                'faqs' => [['Is IVF painful?', 'Injections and scans cause mild discomfort. Egg collection is done with sedation or anaesthesia, and cramping afterwards is usually manageable.'], ['How many cycles might be needed?', 'It varies. Some people conceive in the first cycle, others need several, and some may not conceive. Your doctor can discuss expectations individually.'], ['Does IVF always involve ICSI?', 'No. ICSI is used when sperm quality is a concern or fertilisation has failed before. Many cycles use conventional IVF.']],
            ],
            [
                'slug' => 'iui', 'kind' => 'treatment', 'icon' => 'drop', 'featured' => true,
                'title' => 'IUI – Intrauterine Insemination',
                'summary' => 'Prepared sperm is placed into the uterus around ovulation.',
                'body' => ['Intrauterine insemination (IUI) places specially prepared sperm directly into the uterus around the time of ovulation. It is a simpler and less invasive treatment than IVF and is often tried first in suitable couples.', 'It may be done in a natural cycle or combined with ovulation-stimulating tablets or injections, with ultrasound monitoring to time the procedure.'],
                'who' => ['Mild male-factor infertility', 'Unexplained infertility', 'Cervical factors or ovulation problems', 'Same-sex couples or single women using donor sperm', 'Open fallopian tubes confirmed on testing'],
                'steps' => ['Assessment, including a tubal patency check', 'Optional ovulation induction with monitoring', 'Semen sample prepared in the laboratory', 'Insemination with a thin catheter, similar to a smear test', 'Rest for a short time, then normal activity', 'Pregnancy test about two weeks later'],
                'cons' => ['Per-cycle chances are lower than IVF and several cycles may be advised', 'Not suitable if both fallopian tubes are blocked', 'Stimulation medicines carry a small risk of twins or higher multiples', 'Mild cramping or spotting can occur'],
                'faqs' => [['Is IUI painful?', 'Most people feel mild cramping at most. The procedure takes a few minutes and needs no anaesthetic.'], ['How many IUI cycles are usually tried?', 'Often up to three to six, depending on age and findings. If it has not worked, your doctor may discuss IVF.']],
            ],
            [
                'slug' => 'icsi', 'kind' => 'treatment', 'icon' => 'target', 'featured' => true,
                'title' => 'ICSI – Intracytoplasmic Sperm Injection',
                'summary' => 'A single sperm is injected directly into an egg during assisted fertilisation.',
                'body' => ['Intracytoplasmic sperm injection (ICSI) is a laboratory technique used within an IVF cycle. An embryologist selects one sperm and injects it directly into a mature egg to assist fertilisation.'],
                'who' => ['Low sperm count, poor movement or abnormal shape', 'Sperm retrieved surgically from the testis or epididymis', 'Previous failed or very low fertilisation with standard IVF', 'Frozen sperm samples of limited quantity'],
                'steps' => ['IVF-style stimulation and egg collection', 'Preparation of the sperm sample', 'Injection of one sperm into each mature egg', 'Overnight check for fertilisation', 'Embryo culture and transfer as in IVF'],
                'cons' => ['Not every egg fertilises, and not every embryo develops', 'Genetic counselling may be advised in severe male-factor infertility', 'It adds laboratory cost compared with standard IVF', 'It is not needed for every IVF cycle'],
                'faqs' => [['Is ICSI better than IVF?', 'Not in general. It helps in specific situations, such as significant male-factor infertility, but gives no clear advantage when sperm quality is normal.']],
            ],
            [
                'slug' => 'ovulation-induction', 'kind' => 'treatment', 'icon' => 'sun', 'featured' => true,
                'title' => 'Ovulation Induction',
                'summary' => 'Medication-assisted stimulation of ovulation with clinical monitoring.',
                'body' => ['Ovulation induction uses medicines to encourage the ovaries to release one or a few eggs. It is a common first step for people who do not ovulate regularly, such as with PCOS, and can be used with timed intercourse or IUI.'],
                'who' => ['Irregular or absent ovulation', 'PCOS-related ovulation problems', 'Women preparing for IUI'],
                'steps' => ['Confirm the cause with history, blood tests and ultrasound', 'Start tablets or injections for a set number of days', 'Follicle monitoring with ultrasound scans', 'Timing of intercourse or insemination', 'Pregnancy test if the period is delayed'],
                'cons' => ['Scans are needed to limit the chance of multiple pregnancy', 'Side effects can include hot flushes, mood changes and headaches', 'Treatment is usually limited to a number of cycles', 'Weight management and lifestyle changes may improve response'],
                'faqs' => [['Does ovulation induction always lead to twins?', 'No. Multiple pregnancy is uncommon, and careful monitoring helps keep the risk low.'], ['How long can treatment continue?', 'Your doctor will set a plan, often a limited number of cycles, and review it if pregnancy has not occurred.']],
            ],
            [
                'slug' => 'fertility-assessment', 'kind' => 'treatment', 'icon' => 'search', 'featured' => true,
                'title' => 'Fertility Assessment',
                'summary' => 'Hormone testing, ultrasound, semen analysis and reproductive health evaluation.',
                'body' => ['A fertility assessment looks for factors affecting conception in both partners. It is usually the first step and helps decide whether lifestyle measures, simple treatments or assisted reproduction are most suitable.'],
                'who' => ['Couples trying for 12 months or more (6 months if the woman is 35+)', 'Irregular or absent periods', 'Known conditions such as endometriosis, fibroids or PCOS', 'Previous pelvic infection or surgery'],
                'steps' => ['Detailed medical, menstrual and sexual history', 'Examination and pelvic ultrasound', 'Blood tests, such as hormone levels and ovarian reserve markers', 'Semen analysis for the male partner', 'Checking the fallopian tubes when indicated', 'Discussion of results and a personalised plan'],
                'cons' => ['Both partners should usually be assessed', 'Some tests are timed to the menstrual cycle', 'In some couples no clear cause is found'],
                'faqs' => [['Do both of us need tests?', 'Yes, usually. A semen analysis is simple and often done early.'], ['How long does an assessment take?', 'Most tests are completed within one or two menstrual cycles, depending on timing.']],
            ],
            [
                'slug' => 'fertility-preservation', 'kind' => 'treatment', 'icon' => 'snow', 'featured' => true,
                'title' => 'Fertility Preservation',
                'summary' => 'Information about egg, sperm and embryo freezing where appropriate.',
                'body' => ['Fertility preservation means freezing eggs, sperm or embryos so that they can be used later. It may be discussed before medical treatments that can affect fertility, or when people wish to delay parenthood.'],
                'who' => ['People about to begin chemotherapy or pelvic radiotherapy', 'Those with conditions that may reduce ovarian reserve', 'People choosing to delay having children', 'Partners wanting to store sperm before treatment'],
                'steps' => ['Specialist consultation and baseline tests', 'Egg freezing: stimulation, egg collection and vitrification', 'Sperm freezing: sample collection and storage', 'Embryo freezing if a partner or donor sperm is used', 'Storage with consent and review of storage terms'],
                'cons' => ['Freezing does not guarantee a future pregnancy', 'Chances are better when eggs are frozen at a younger age', 'Storage is time-limited and has recurring costs', 'Legal and consent requirements apply'],
                'faqs' => [['What is the best age to freeze eggs?', 'Egg quality declines with age, so younger ages generally give better outcomes. A doctor can advise individually.']],
            ],
            [
                'slug' => 'embryo-transfer', 'kind' => 'treatment', 'icon' => 'baby',
                'title' => 'Embryo Transfer',
                'summary' => 'Placing one or more embryos into the uterus after laboratory culture.',
                'body' => ['Embryo transfer is the final stage of an IVF or ICSI cycle. A soft catheter passes through the cervix and places the embryo in the uterine cavity under ultrasound guidance.', 'Transfers can be fresh, soon after egg collection, or frozen, in a later cycle once the uterus has been prepared.'],
                'who' => ['Anyone with a suitable embryo after IVF or ICSI', 'Those using frozen embryos from an earlier cycle'],
                'steps' => ['Embryo quality and number are reviewed', 'Uterine lining is prepared with medicines', 'A catheter places the embryo under ultrasound guidance', 'Hormone support may continue afterwards', 'A pregnancy test follows about two weeks later'],
                'cons' => ['The procedure is quick and usually needs no anaesthetic', 'Single-embryo transfer lowers the chance of twins', 'Not every transferred embryo implants'],
                'faqs' => [['Do I need bed rest afterwards?', 'No strict bed rest is required. Gentle normal activity is generally fine, and your clinic will advise you.']],
            ],
            [
                'slug' => 'blastocyst-culture', 'kind' => 'treatment', 'icon' => 'dna',
                'title' => 'Blastocyst Culture',
                'summary' => 'Growing embryos in the laboratory for five to six days before transfer or freezing.',
                'body' => ['Blastocyst culture extends embryo growth to day five or six, when an embryo has developed into a blastocyst with distinct cell types. It can help embryologists choose embryos with better development potential.'],
                'who' => ['People with several good-quality embryos', 'Those aiming for single-embryo transfer', 'Cycles where freezing embryos is planned'],
                'steps' => ['Fertilised eggs are cultured in incubators', 'Development is checked on days three, five and six', 'Suitable blastocysts are transferred or vitrified'],
                'cons' => ['Some embryos stop developing before day five, so fewer may be available', 'It may not suit people with only one or two embryos', 'It does not guarantee implantation'],
                'faqs' => [['Is a blastocyst transfer always better?', 'Not always. It suits some patients, but a day-three transfer may be better when few embryos are available.']],
            ],
            [
                'slug' => 'donor-assisted-reproduction', 'kind' => 'treatment', 'icon' => 'users',
                'title' => 'Donor-assisted Reproduction',
                'summary' => 'Using donor eggs, sperm or embryos, with counselling and legal safeguards.',
                'body' => ['Donor-assisted reproduction uses eggs, sperm or embryos from a donor. It may be considered when a person cannot use their own gametes, or to avoid passing on a genetic condition.', 'Regulations on donation and surrogacy differ and are set by law, so counselling and proper consent are essential.'],
                'who' => ['Premature ovarian insufficiency or very low ovarian reserve', 'Severe male-factor infertility with no sperm available', 'Genetic conditions that could be passed on', 'Single women and same-sex couples where permitted by law'],
                'steps' => ['Counselling about emotional and legal aspects', 'Screening and matching of the donor', 'Cycle synchronisation and treatment (IUI or IVF)', 'Embryo transfer and early pregnancy follow-up'],
                'cons' => ['Legal consent and local regulations must be followed', 'Emotional support and counselling are strongly encouraged', 'Cost and availability vary'],
                'faqs' => [['Is counselling required?', 'It is strongly recommended and often a legal or clinic requirement, to help you think through the decisions.']],
            ],
            [
                'slug' => 'pcos-care', 'kind' => 'condition', 'icon' => 'flower',
                'title' => 'PCOS-related Fertility Care',
                'summary' => 'Cycle regulation, ovulation support and long-term health care in polycystic ovary syndrome.',
                'body' => ['Polycystic ovary syndrome (PCOS) is one of the commonest causes of irregular ovulation. Many people with PCOS conceive with lifestyle support and simple treatment, and some need further help.'],
                'who' => ['Irregular, infrequent or absent periods', 'Signs of raised androgens such as acne or excess hair', 'Difficulty conceiving'],
                'steps' => ['Confirm diagnosis with history, blood tests and ultrasound', 'Discuss lifestyle, weight and metabolic health', 'Ovulation induction if needed', 'IUI or IVF where simpler steps do not work'],
                'cons' => ['PCOS affects long-term metabolic health, so regular review is useful', 'Higher sensitivity to stimulation raises the risk of ovarian hyperstimulation, so monitoring is important'],
                'faqs' => [['Can I get pregnant naturally with PCOS?', 'Many people with PCOS do, especially with cycle tracking and lifestyle support. Help is available if it takes longer.']],
            ],
            [
                'slug' => 'endometriosis-related-infertility', 'kind' => 'condition', 'icon' => 'heart',
                'title' => 'Endometriosis-related Infertility',
                'summary' => 'How endometriosis can affect fertility and the options for care.',
                'body' => ['Endometriosis occurs when tissue similar to the womb lining grows outside the uterus. It can cause painful periods and may affect the ovaries, tubes and egg quality, making conception harder for some.'],
                'who' => ['Painful periods or pelvic pain with difficulty conceiving', 'Known or suspected endometriosis', 'Ovarian endometriomas (cysts)'],
                'steps' => ['Assessment with ultrasound, and sometimes MRI or laparoscopy', 'Discussion of surgery, medicine and timing of conception', 'Fertility treatments such as IUI or IVF if needed'],
                'cons' => ['Surgery may help some people but can reduce ovarian reserve, so it is individualised', 'Hormonal medicines used for pain relief prevent pregnancy while in use'],
                'faqs' => [['Does everyone with endometriosis have trouble conceiving?', 'No. Many people with endometriosis conceive without treatment, though others need help.']],
            ],
            [
                'slug' => 'male-factor-infertility', 'kind' => 'condition', 'icon' => 'users',
                'title' => 'Male-factor Infertility',
                'summary' => 'Semen analysis and evaluation when sperm count, movement or shape affect conception.',
                'body' => ['Male-factor issues contribute to infertility in a large share of couples. Evaluation usually begins with a semen analysis and a medical history.'],
                'who' => ['Abnormal semen analysis', 'History of testicular problems, infections or surgery', 'Couples with unexplained infertility'],
                'steps' => ['Semen analysis, repeated if abnormal', 'Examination and hormone tests', 'Lifestyle review: smoking, alcohol, heat exposure, medicines', 'Treatments such as IUI, IVF or ICSI as suitable', 'Referral to a urologist or andrologist where relevant'],
                'cons' => ['Semen quality varies between samples', 'Some causes are treatable, others are managed with assisted reproduction'],
                'faqs' => [['How should I prepare for a semen test?', 'Clinics usually advise two to five days of abstinence and will give clear instructions on collecting the sample.']],
            ],
            [
                'slug' => 'recurrent-pregnancy-loss-evaluation', 'kind' => 'condition', 'icon' => 'shield',
                'title' => 'Recurrent Pregnancy Loss Evaluation',
                'summary' => 'A sensitive, structured evaluation after repeated miscarriages.',
                'body' => ['Recurrent pregnancy loss is usually defined as two or more pregnancy losses. Many losses are due to chromosomal changes in the embryo and are not caused by anything the parents did. Evaluation aims to look for treatable factors.'],
                'who' => ['Two or more miscarriages', 'Loss of a pregnancy in the second trimester', 'Known uterine or clotting conditions'],
                'steps' => ['Review of history and previous pregnancies', 'Blood tests including thyroid, blood sugar and clotting-related tests', 'Ultrasound to check the shape of the uterus', 'Genetic testing of both partners when advised', 'Plan for monitoring and support in the next pregnancy'],
                'cons' => ['In many cases no cause is found and the outlook is still often positive', 'Emotional support is an important part of care'],
                'faqs' => [['Does a miscarriage mean I did something wrong?', 'No. Most miscarriages are caused by chromosomal abnormalities that cannot be prevented.']],
            ],
        ];
    }

    private function posts(): void
    {
        $cat = Category::where('slug', 'fertility')->value('id');
        $disclaimer = '<p><em>This article is for general education only and is not medical advice. Please speak to a qualified doctor about your own situation.</em></p>';
        $items = [
            ['Understanding the IVF journey: from consultation to pregnancy test', 'A step-by-step, plain-language look at what usually happens during an IVF cycle.', ['<p>An IVF cycle follows a series of stages. The details vary between clinics and patients, but the overall pathway is similar.</p>', '<h2>The main stages</h2><ol><li><strong>Consultation:</strong> your history, previous tests and goals are reviewed.</li><li><strong>Assessment:</strong> hormone tests, ultrasound and a semen analysis.</li><li><strong>Ovarian stimulation:</strong> injections help several eggs mature, with scans to monitor.</li><li><strong>Egg retrieval:</strong> a short procedure under sedation.</li><li><strong>Fertilisation:</strong> eggs and sperm are combined, or ICSI is used.</li><li><strong>Embryo culture:</strong> embryos grow in the laboratory for several days.</li><li><strong>Embryo transfer:</strong> an embryo is placed in the uterus.</li><li><strong>Pregnancy test:</strong> a blood test about two weeks after transfer.</li></ol>', '<p>No treatment can guarantee a pregnancy, and emotional support is an important part of the journey.</p>']],
            ['IVF vs IUI: understanding the difference', 'How the two treatments differ in steps, invasiveness and who they may suit.', ['<p>Both IUI and IVF are assisted reproduction treatments, but they work differently.</p>', '<ul><li><strong>IUI</strong> places prepared sperm in the uterus, so fertilisation still happens inside the body.</li><li><strong>IVF</strong> combines eggs and sperm in a laboratory and transfers an embryo.</li></ul>', '<p>IUI is simpler and less costly, while IVF has higher per-cycle chances but involves more medication and procedures. Which is suitable depends on age, tubal health, sperm quality and previous treatment.</p>']],
            ['Male-factor infertility: what a semen analysis can tell you', 'Why semen testing is an early step in any fertility assessment.', ['<p>A semen analysis measures sperm count, movement and shape, along with volume. It is simple, non-invasive and an important early test.</p>', '<h2>Next steps</h2><p>If results are abnormal, they are usually repeated and followed by an examination, hormone tests and lifestyle review. Treatments from lifestyle changes to IUI, IVF or ICSI may be discussed.</p>']],
        ];
        foreach ($items as $i => [$title, $excerpt, $paras]) {
            $slug = Str::slug($title);
            $body = implode('', $paras).$disclaimer;
            Post::updateOrCreate(['slug' => $slug], [
                'category_id' => $cat, 'title' => $title, 'excerpt' => $excerpt, 'body' => $body,
                'featured_image' => '/images/articles/'.$slug.'.webp', 'image_alt' => $title,
                'status' => 'published', 'published_at' => now()->subDays(1 + $i), 'is_featured' => false,
                'reading_time' => reading_time($body), 'meta_description' => $excerpt,
            ]);
        }
    }
}
