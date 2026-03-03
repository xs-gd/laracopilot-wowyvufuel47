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

        $patronTypes      = ['Studente Triennale', 'Studente Magistrale', 'Dottorando', 'Docente', 'Ricercatore', 'Personale Tecnico-Amministrativo', 'Utente Esterno', 'Visiting Scholar'];
        $channels         = ['in_person', 'phone', 'email', 'chat', 'virtual'];
        $transactionTypes = ['ready_reference', 'research', 'directional', 'instructional', 'reader_advisory', 'technical'];
        $subjects         = ['Biologia Molecolare', 'Storia Medievale', 'Diritto Civile', 'Matematica Applicata', 'Letteratura Italiana', 'Economia Politica', 'Ingegneria del Software', 'Chimica Organica', 'Filosofia Contemporanea', 'Sociologia', 'Psicologia Cognitiva', 'Fisica Quantistica', 'Archeologia Classica', 'Diritto Penale', 'Nutrizione e Dietetica'];
        $resources        = ['PubMed, Web of Science', 'JSTOR, Google Scholar', 'Catalogo OPAC, SBN', 'LexisNexis, DeJure', 'IEEE Xplore, ACM Digital Library', 'Scopus, Emerald', 'Archivio Storico Universitario', 'Banche dati in abbonamento'];
        $statuses         = ['pending', 'in_progress', 'closed', 'closed', 'closed', 'referred'];
        $complexities     = ['simple', 'simple', 'moderate', 'complex'];
        $questions        = [
            'Come posso trovare articoli scientifici sulla biologia molecolare degli ultimi 5 anni?',
            'Ho bisogno di fonti primarie sulla storia medievale italiana.',
            'Dove posso accedere alle banche dati giuridiche per la mia tesi di laurea?',
            'Cerco manuali di matematica applicata per il corso di laurea magistrale.',
            'Quali risorse digitali sono disponibili per la letteratura italiana del Novecento?',
            'Come si accede alle riviste di economia in abbonamento?',
            'Ho bisogno di aiuto per trovare articoli di informatica su machine learning.',
            'Dove trovo i testi classici di chimica organica disponibili in biblioteca?',
            'Cerco materiale per la mia ricerca in filosofia contemporanea.',
            'Quali banche dati sociologiche sono disponibili per i ricercatori?',
            'Come posso scaricare articoli da PubMed attraverso la biblioteca?',
            'Ho bisogno di informazioni sui brevetti nel campo della fisica applicata.',
            'Dove sono conservati i manoscritti storici dell archivio universitario?',
            'Cerco testi di diritto penale comparato internazionale.',
            'Quali riviste di nutrizione clinica sono accessibili online?',
            'Come si usa il catalogo OPAC per trovare libri prestati?',
            'Ho bisogno di supporto per la ricerca bibliografica della mia tesi dottorale.',
            'Quali sono le banche dati disponibili per psicologia cognitiva?',
            'Come posso accedere agli archivi storici digitali della biblioteca?',
            'Cerco documentazione tecnica su reti neurali e intelligenza artificiale.',
        ];
        $responses = [
            'Ho illustrato le principali banche dati disponibili e le modalita di accesso.',
            'Ho fornito indicazioni sulle fonti primarie disponibili in archivio.',
            'Ho guidato il ricercatore nelle banche dati giuridiche in abbonamento.',
            'Ho mostrato come cercare manuali nel catalogo e nelle risorse digitali.',
            'Ho indicato le raccolte digitali disponibili e i percorsi di ricerca.',
            'Ho spiegato le procedure di accesso alle riviste elettroniche.',
            'Ho illustrato come utilizzare IEEE Xplore e ACM Digital Library.',
            'Ho aiutato nella ricerca dei testi nel catalogo fisico e digitale.',
            'Ho fornito una lista di riviste e banche dati di filosofia disponibili.',
            'Ho mostrato le risorse sociologiche disponibili e le modalita di ricerca.',
        ];

        $transactions = [];
        $dates = [];
        for ($i = 0; $i < 150; $i++) {
            $daysAgo = rand(0, 730);
            $dates[] = date('Y-m-d', strtotime("-{$daysAgo} days"));
        }

        $times = ['08:30:00','09:00:00','09:30:00','10:00:00','10:30:00','11:00:00','11:30:00','12:00:00','14:00:00','14:30:00','15:00:00','15:30:00','16:00:00','16:30:00','17:00:00'];

        for ($i = 0; $i < 150; $i++) {
            ReferenceTransaction::create([
                'transaction_date'   => $dates[$i],
                'transaction_time'   => $times[array_rand($times)],
                'librarian_id'       => $librarianIds[array_rand($librarianIds)],
                'patron_type'        => $patronTypes[array_rand($patronTypes)],
                'channel'            => $channels[array_rand($channels)],
                'transaction_type'   => $transactionTypes[array_rand($transactionTypes)],
                'subject_area'       => $subjects[array_rand($subjects)],
                'question_summary'   => $questions[array_rand($questions)],
                'response_summary'   => rand(0, 3) > 0 ? $responses[array_rand($responses)] : null,
                'resources_used'     => rand(0, 3) > 0 ? $resources[array_rand($resources)] : null,
                'duration_minutes'   => rand(0, 10) > 1 ? rand(5, 120) : null,
                'status'             => $statuses[array_rand($statuses)],
                'complexity_level'   => $complexities[array_rand($complexities)],
                'follow_up_required' => rand(0, 4) === 0,
                'notes'              => rand(0, 3) === 0 ? 'Utente soddisfatto del servizio ricevuto.' : null,
                'recorded_by'        => 'Administrator',
            ]);
        }
    }
}