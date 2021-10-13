<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'World',
                'Мир',
                'die Welt',
                'Le monde',
                'El mundo',
                'Il mondo',
                'Świat',
                'Svět',
                'Värld',
                'Verden',
                '世界',
                '세계',
                '#007bff',
            ],
            [
                'Fun',
                'Развлечения',
                'der Spaß',
                "L'amusement",
                'La diversión',
                'Il divertimento',
                'Zabawa',
                'Zábava',
                'Roligt',
                'Moro',
                '楽しい',
                '장난',
                'green',
            ],
            [
                'Lifehacks',
                'Лайфхаки',
                'Lifehacks',
                'Lifehacks',
                'Trucos de la vida',
                'Lifehacks',
                'Lifehacks',
                'Lifehacks',
                'Lifehacks',
                'Livstips',
                'ライフハック',
                'Lifehacks',
                'red',
            ],
            [
                'Design',
                'Дизайн',
                'das Design',
                'Le désign',
                'El diseño',
                'Il design',
                'Design',
                'Design',
                'Design',
                'Design',
                '設計',
                '디자인',
            ],
            [
                'Tech',
                'Технологии',
                'die Technologie',
                'La technologie',
                'La tecnología',
                'La tecnologia',
                'Technologia',
                'Technologie',
                'Teknologi',
                'Teknologi',
                '技術',
                '공학',
            ],
            [
                'Business',
                'Бизнес',
                'das Geschäft',
                "L'affaires",
                'Los negocios',
                'Gli affari',
                'Biznes',
                'Byznys',
                'Företag',
                'Forretning',
                'ビジネス',
                '사업',
            ],
            [
                'Science',
                'Наука',
                'die Wissenschaft',
                'La science',
                'La ciencia',
                'La scienza',
                'Nauka',
                'Věda',
                'Vetenskap',
                'Vitenskap',
                '理科',
                '과학',
            ],
            [
                'Programming',
                'Разработка',
                'die Programmierung',
                'La programmation',
                'La programación',
                'La programmazione',
                'Programowanie',
                'Programování',
                'Programmering',
                'Programmering',
                'プログラミング',
                '프로그램 작성',
            ],
            [
                'Style',
                'Стиль',
                'der Stil',
                'Le style',
                'El estilo',
                'Lo stile',
                'Styl',
                'Styl',
                'Stil',
                'Stil',
                '流儀',
                '스타일',
                '#dc2ac6',
            ],
            [
                'Travel',
                'Путешествия',
                'die Reise',
                'Voyage',
                'Los viajes',
                'Viaggiare',
                'Podróż',
                'Turistika',
                'Resa',
                'Reise',
                '旅行',
                '여행',
            ]
        ];

        foreach ($data as $name) {
            Category::factory()
                ->create([
                    'name_en' => $name[0],
                    'name_ru' => $name[1],
                    'name_de' => $name[2],
                    'name_fr' => $name[3],
                    'name_es' => $name[4],
                    'name_it' => $name[5],
                    'name_pl' => $name[6],
                    'name_cz' => $name[7],
                    'name_se' => $name[8],
                    'name_no' => $name[9],
                    'name_jp' => $name[10],
                    'name_kr' => $name[11],
                    'alias' => Str::slug($name[0]),
                    'color' => $name[12] ?? null,
                ]);
        }
    }
}
