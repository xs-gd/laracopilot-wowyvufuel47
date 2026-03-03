<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReferenceTransaction;
use App\Models\Librarian;

class ReferenceTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $librarianIds = Librarian::pluck('id')->toArray();

        $transactions = [
            ['patron_name' => 'Alice Brown',      'question' => 'Where is the restroom?',                                         'answer' => 'Second floor, turn left at the elevator.',                        'type' => 'directional',     'duration' => 1,  'notes' => ''],
            ['patron_name' => 'Bob Martinez',     'question' => 'How do I find peer-reviewed articles on climate change?',         'answer' => 'Use JSTOR or EBSCOhost databases available on our website.',      'type' => 'research',        'duration' => 15, 'notes' => 'Showed patron database navigation'],
            ['patron_name' => 'Carol White',      'question' => 'Do you have books by Toni Morrison?',                            'answer' => 'Yes, found 12 titles in our catalog.',                           'type' => 'informational',   'duration' => 5,  'notes' => ''],
            ['patron_name' => 'Daniel Lee',       'question' => 'Can you recommend a good mystery novel?',                        'answer' => 'Recommended Gone Girl and The Girl with the Dragon Tattoo.',      'type' => 'reader_advisory', 'duration' => 10, 'notes' => 'Patron enjoyed psychological thrillers'],
            ['patron_name' => 'Eva Johnson',      'question' => 'How do I print from my laptop?',                                 'answer' => 'Connect to LibraryPrint WiFi and use the print portal.',          'type' => 'technology',      'duration' => 8,  'notes' => 'Assisted with driver installation'],
            ['patron_name' => 'Frank Garcia',     'question' => 'What are the library hours on holidays?',                        'answer' => 'Provided printed holiday schedule.',                              'type' => 'informational',   'duration' => 2,  'notes' => ''],
            ['patron_name' => 'Grace Kim',        'question' => 'I need help finding genealogy records for my family.',           'answer' => 'Introduced Ancestry.com and local census microfilm collection.',  'type' => 'research',        'duration' => 30, 'notes' => 'Very engaged patron, will return'],
            ['patron_name' => 'Henry Turner',     'question' => 'Where is the periodicals section?',                              'answer' => 'Ground floor, east wing near the windows.',                      'type' => 'directional',     'duration' => 1,  'notes' => ''],
            ['patron_name' => 'Irene Scott',      'question' => 'Can I access the New York Times archive?',                       'answer' => 'Yes, through ProQuest Historical Newspapers with library card.', 'type' => 'informational',   'duration' => 6,  'notes' => ''],
            ['patron_name' => 'Jack Robinson',    'question' => 'Help me understand how to use the self-checkout machine.',       'answer' => 'Walked patron through the process step by step.',                 'type' => 'technology',      'duration' => 5,  'notes' => ''],
            ['patron_name' => 'Karen Young',      'question' => 'What books do you recommend for learning Python?',               'answer' => 'Recommended Automate the Boring Stuff and Python Crash Course.',  'type' => 'reader_advisory', 'duration' => 12, 'notes' => 'Patron is a beginner programmer'],
            ['patron_name' => 'Leo Anderson',     'question' => 'I need statistics on US immigration for a research paper.',     'answer' => 'Directed to Census Bureau data and ProQuest Statistical.',       'type' => 'research',        'duration' => 20, 'notes' => 'College student writing thesis'],
            ['patron_name' => 'Maria Lopez',      'question' => 'Do you have audiobooks in Spanish?',                            'answer' => 'Yes, available through Libby app with library card.',            'type' => 'informational',   'duration' => 7,  'notes' => ''],
            ['patron_name' => 'Nathan Clark',     'question' => 'How do I renew my library card?',                               'answer' => 'Can be done online or at the circulation desk with ID.',          'type' => 'informational',   'duration' => 3,  'notes' => ''],
            ['patron_name' => 'Olivia Hall',      'question' => 'Where can I find a quiet study room?',                          'answer' => 'Rooms 204 and 206 on the second floor, reserve at front desk.',   'type' => 'directional',     'duration' => 2,  'notes' => ''],
            ['patron_name' => 'Peter Walker',     'question' => 'Can you help me cite sources in APA format?',                   'answer' => 'Provided APA citation guide and demonstrated Purdue OWL.',       'type' => 'research',        'duration' => 18, 'notes' => 'High school student'],
            ['patron_name' => 'Quinn Harris',     'question' => 'Do you have large print books for seniors?',                   'answer' => 'Yes, dedicated large print section on ground floor.',            'type' => 'informational',   'duration' => 4,  'notes' => ''],
            ['patron_name' => 'Rosa Martinez',    'question' => 'I cannot connect to the library WiFi.',                         'answer' => 'Reset patron device network settings, connection resolved.',      'type' => 'technology',      'duration' => 10, 'notes' => 'iPhone connectivity issue'],
            ['patron_name' => 'Samuel Davis',     'question' => 'What good sci-fi books came out this year?',                    'answer' => 'Recommended Project Hail Mary and Piranesi.',                    'type' => 'reader_advisory', 'duration' => 8,  'notes' => ''],
            ['patron_name' => 'Teresa Wilson',    'question' => 'How do I access e-books from home?',                            'answer' => 'Explained OverDrive and Libby app setup process.',               'type' => 'technology',      'duration' => 15, 'notes' => 'Patron is elderly, needed extra patience'],
        ];

        foreach ($transactions as $index => $data) {
            ReferenceTransaction::create(array_merge($data, [
                'librarian_id' => $librarianIds[$index % count($librarianIds)],
            ]));
        }
    }
}