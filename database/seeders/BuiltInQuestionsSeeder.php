<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\BuiltInQuestion;

class BuiltInQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [

            '1' => [
                [
                    'question_text' => 'What is your name?',
                    'question_type' => 'text',
                    'question_options' => null,
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,
                ],
                [
                    'question_text' => 'What is your age?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['18-24', '25-34', '35-44', '45-54', '55+']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,
                ],
                [
                    'question_text' => 'What is your gender?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Male', 'Female']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 3,
                ],
                 [
                    'question_text' => 'What is your religion?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Muslim', 'Christian', 'Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,
                ],
                [
                    'question_text' => 'What is your governorate?',
                    'question_type' => 'dropdown',
                    'question_options' => null,
                    'source_table' => 'governorates',
                    'depends_on' => null,
                    'order' => 5,
                ],
                [
                    'question_text' => 'What is your region?',
                    'question_type' => 'dropdown',
                    'question_options' => null,
                    'source_table' => 'regions',
                    'depends_on' => 'What is your governorate?', // Assuming this depends on the governorate question
                    'order' => 6,
                ],

            ],
            '2'=>[
                [
                    'question_text' => 'What is your marital status?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Single', 'Married', 'Divorced', 'Widowed']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,
                ],
                [
                    'question_text' => 'Do you have any children?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Yes', 'No']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,
                ],
                [
                    'question_text' => 'If yes, how many children do you have?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['1', '2', '3', '4', '5+']),
                    'source_table' => null,
                    'depends_on' => 'Do you have any children?',
                    'order' => 3,
                ],
                [
                    'question_text' => 'Do you live with your family?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Yes', 'No']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,
                ],
                 
            ],
            '3' => [
                [
                    'question_text' => 'What is your highest level of education?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['High School', 'Bachelor\'s Degree', 'Master\'s Degree', 'Doctorate', 'Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,
                ],
                [
                    'question_text' => 'What your field of study?',
                    'question_type' => 'text',
                    'question_options' => null,
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,
                ],
                [
                    'question_text' => 'What your university?',
                    'question_type' => 'text',
                    'question_options' => null,
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 3,
                ],
                 [
                    'question_text' => 'What your faculty?',
                    'question_type' => 'text',
                    'question_options' => null,
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,
                ],
                [
                    'question_text' => 'How satisfied are you with your education?',
                    'question_type' => 'slider',
                    'question_options' => json_encode([
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                        'labels' => [
                            1 => 'Very dissatisfied',
                            2 => 'Dissatisfied',
                            3 => 'Neutral',
                            4 => 'Satisfied',
                            5 => 'Very satisfied'
                        ]
                    ]),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 5,
                ],
            ],
                 '4' => [
                [
                    'question_text' => 'What is your current job?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Employed', 'Unemployed', 'Student', 'Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,
                ],
                [
                    'question_text' => 'Which field do you work in?',
                    'question_type' => 'text',
                    'question_options' => null,
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,
                ],
                [
                    'question_text' => 'How many years of experience do you have?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['0-1 years', '2-5 years', '3-5 years', '6-10 years', '10+ years']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 3,
                ],
                 [
                    'question_text' => 'What is your average monthly salary? (in EGP)',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['less than 7000', '7000-14000', '15000-24000', '25000-35000', '35000+']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,
                ],
                [
                    'question_text' => 'What is your average weekly working hours?',
                    'question_type' => 'slider',
                    'question_options' => json_encode([
                        'min' => 0,
                        'max' => 80,
                        'step' => 5,
                        'labels' => [
                            0 => '0 hours',
                            20 => '20 hours',
                            40 => '40 hours',
                            60 => '60 hours',
                            80 => '80+ hours'
                        ]
                    ]), 
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 5,
                ],
                 [
                    'question_text' => 'What is your work location?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Onsite', 'Remotely', 'Hybrid']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 6,
                ],
                 [
                    'question_text' => 'How satisfied are you with your work job?',
                    'question_type' => 'slider',
                    'question_options' => json_encode([
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                        'labels' => [
                            1 => 'Very dissatisfied',
                            2 => 'Dissatisfied',
                            3 => 'Neutral',
                            4 => 'Satisfied',
                            5 => 'Very satisfied'
                        ]
                    ]),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 7,
                ],
            ],
            '5'=>[
                 [
                    'question_text' => 'Do you buy online before?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Yes', 'No']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,
                ],
                 [
                    'question_text' => 'How often do you shop online?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Daily', 'Weekly','Monthly','Rarely','Never']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,
                ],
                [
                    'question_text' => 'Which type of product do you usually buy?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Electronics','Fashion','Books','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 3,
                ],
                [
                    'question_text' => 'What is your payment method?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Credit Card','Debit Card','Digital Wallet','Cash On Delivery']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,
                ],
                [
                    'question_text' => 'What do you like the most about shopping online?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Convenience','Lower prices','Product variety','Fast delivery','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 5,
                ],
                [
                    'question_text' => 'What challenges do you usually face when shopping online?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Delivery delays','Product quality','Payment issues','Customer service','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 6,
                ],
                 [
                    'question_text' => 'How satisfied are you with buy online?',
                    'question_type' => 'slider',
                    'question_options' => json_encode([
                        'min' => 1,
                        'max' => 5,
                        'step' => 1,
                        'labels' => [
                            1 => 'Very dissatisfied',
                            2 => 'Dissatisfied',
                            3 => 'Neutral',
                            4 => 'Satisfied',
                            5 => 'Very satisfied'
                        ]
                    ]),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 7,
                ],
            ],
            '6' =>[
                [
                    'question_text' => 'What do you mainly use technology for?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Work','Study-Communication & Social media','Entertainment (movies, games, music)','Online shopping','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 1,

                ],
                 [
                    'question_text' => ' Which devices do you use most often?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Smartphone','Laptop','Tablet','Desktop','Computer','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 2,

                ],
                 [
                    'question_text' => 'How many hours per day do you spend using technology (smartphone, computer, etc.)?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Less than 2 hours','2-4 hours','5-7 hours','More than 7 hours']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 3,

                ],
                [
                    'question_text' => 'Which operating system do you prefer?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Windows','macOS','Linux','iOS','Android','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 4,

                ],
                [
                    'question_text' => 'What do you value most when choosing a new device?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Performance','Price','Design','Brand','Battery life','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 5,

                ],
                [
                    'question_text' => 'How important is technology in your daily life?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Not important','Somewhat important','Very important','Essential']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 6,

                ],
                [
                    'question_text' => 'Which future technology excites you the most?',
                    'question_type' => 'multiple_choice',
                    'question_options' => json_encode(['Artificial Intelligence','Smart Homes','Virtual/Augmented Reality','Robotics','Other']),
                    'source_table' => null,
                    'depends_on' => null,
                    'order' => 7,

                ],  
            ]

        ];
                // نخزن الأسئلة اللي اتعملها insert عشان نرجع لها
         $insertedQuestions = [];

        DB::transaction(function () use ($sections, &$insertedQuestions) {
            foreach ($sections as $sectionName => $questions) {
                foreach ($questions as $data) {
                    $dependsOn = $data['depends_on'];
                    unset($data['depends_on']);

                    $question = BuiltInQuestion::create(array_merge($data, [
                        'section_id' => $sectionName,
                        'depends_on_question_id' => null, // نسيبه null دلوقتي
                    ]));

                    // نخزن السؤال بالـ text بتاعه عشان نربط عليه بعدين
                    $insertedQuestions[$data['question_text']] = $question->id;

                    // لو السؤال بيعتمد على سؤال تاني → نحدثه بعد الـ insert
                    if ($dependsOn && isset($insertedQuestions[$dependsOn])) {
                        $question->update([
                            'depends_on_question_id' => $insertedQuestions[$dependsOn],
                        ]);
                    }
                }
            }
        });
    }
}
