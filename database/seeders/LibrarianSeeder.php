<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Librarian;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF');
        DB::table('reference_transactions')->truncate();
        DB::table('librarians')->truncate();
        DB::statement('PRAGMA foreign_keys = ON');

        $librarians = [
            ['name' => 'Luca Bianchi',       'email' => 'luca.bianchi@biblioteca.edu',       'employee_id' => 'BIB-0001', 'department' => 'Biblioteca Centrale',  'specialization' => 'Ricerca Interdisciplinare',  'phone' => '+39 06 1234 5678', 'hire_date' => '2015-09-01', 'active' => true,  'role' => 'department_head',      'role_notes' => 'Responsabile della Biblioteca Centrale dal 2020.'],
            ['name' => 'Giulia Ferrari',     'email' => 'giulia.ferrari@biblioteca.edu',     'employee_id' => 'BIB-0002', 'department' => 'Sezione Scienze',       'specialization' => 'Biologia e Medicina',        'phone' => '+39 06 1234 5679', 'hire_date' => '2012-03-15', 'active' => true,  'role' => 'senior_librarian',     'role_notes' => null],
            ['name' => 'Marco Ricci',        'email' => 'marco.ricci@biblioteca.edu',        'employee_id' => 'BIB-0003', 'department' => 'Sezione Umanistica',    'specialization' => 'Letteratura e Storia',       'phone' => '+39 06 1234 5680', 'hire_date' => '2018-11-20', 'active' => true,  'role' => 'reference_specialist', 'role_notes' => null],
            ['name' => 'Sara Conti',         'email' => 'sara.conti@biblioteca.edu',         'employee_id' => 'BIB-0004', 'department' => 'Sezione Giuridica',     'specialization' => 'Diritto e Giurisprudenza',  'phone' => '+39 06 1234 5681', 'hire_date' => '2016-06-10', 'active' => true,  'role' => 'department_head',      'role_notes' => 'Responsabile della Sezione Giuridica.'],
            ['name' => 'Antonio Esposito',   'email' => 'antonio.esposito@biblioteca.edu',   'employee_id' => 'BIB-0005', 'department' => 'Sezione Informatica',   'specialization' => 'Informatica e Tecnologia',  'phone' => '+39 06 1234 5682', 'hire_date' => '2020-01-08', 'active' => true,  'role' => 'systems_librarian',    'role_notes' => null],
            ['name' => 'Federica Romano',    'email' => 'federica.romano@biblioteca.edu',    'employee_id' => 'BIB-0006', 'department' => 'Sezione Economica',     'specialization' => 'Economia e Finanza',        'phone' => '+39 06 1234 5683', 'hire_date' => '2014-04-22', 'active' => true,  'role' => 'senior_librarian',     'role_notes' => null],
            ['name' => 'Davide Marino',      'email' => 'davide.marino@biblioteca.edu',      'employee_id' => 'BIB-0007', 'department' => 'Archivio Storico',      'specialization' => 'Archivistica e Patrimonio', 'phone' => '+39 06 1234 5684', 'hire_date' => '2010-09-30', 'active' => true,  'role' => 'archivist',            'role_notes' => 'Esperto in manoscritti medievali.'],
            ['name' => 'Valentina Greco',    'email' => 'valentina.greco@biblioteca.edu',    'employee_id' => 'BIB-0008', 'department' => 'Sezione Medica',        'specialization' => 'Scienze della Salute',      'phone' => '+39 06 1234 5685', 'hire_date' => '2019-03-01', 'active' => true,  'role' => 'librarian',            'role_notes' => null],
            ['name' => 'Roberto Lombardi',   'email' => 'roberto.lombardi@biblioteca.edu',   'employee_id' => 'BIB-0009', 'department' => 'Biblioteca Centrale',   'specialization' => 'Servizi Digitali',          'phone' => '+39 06 1234 5686', 'hire_date' => '2017-07-15', 'active' => true,  'role' => 'systems_librarian',    'role_notes' => null],
            ['name' => 'Chiara Fontana',     'email' => 'chiara.fontana@biblioteca.edu',     'employee_id' => 'BIB-0010', 'department' => 'Sezione Umanistica',    'specialization' => 'Arte e Architettura',       'phone' => '+39 06 1234 5687', 'hire_date' => '2021-02-10', 'active' => true,  'role' => 'cataloger',            'role_notes' => null],
            ['name' => 'Paolo Martini',      'email' => 'paolo.martini@biblioteca.edu',      'employee_id' => 'BIB-0011', 'department' => 'Sezione Scienze',       'specialization' => 'Chimica e Fisica',          'phone' => '+39 06 1234 5688', 'hire_date' => '2013-05-18', 'active' => true,  'role' => 'reference_specialist', 'role_notes' => null],
            ['name' => 'Elena Barbieri',     'email' => 'elena.barbieri@biblioteca.edu',     'employee_id' => 'BIB-0012', 'department' => 'Sezione Giuridica',     'specialization' => 'Diritto Amministrativo',    'phone' => '+39 06 1234 5689', 'hire_date' => '2022-08-01', 'active' => true,  'role' => 'librarian',            'role_notes' => null],
            ['name' => 'Stefano Moretti',    'email' => 'stefano.moretti@biblioteca.edu',    'employee_id' => 'BIB-0013', 'department' => 'Archivio Storico',      'specialization' => 'Manoscritti e Incunaboli',  'phone' => '+39 06 1234 5690', 'hire_date' => '2009-11-03', 'active' => true,  'role' => 'archivist',            'role_notes' => 'Responsabile del fondo storico universitario.'],
            ['name' => 'Alessia De Luca',    'email' => 'alessia.deluca@biblioteca.edu',     'employee_id' => 'BIB-0014', 'department' => 'Sezione Medica',        'specialization' => 'Farmacologia',              'phone' => '+39 06 1234 5691', 'hire_date' => '2023-01-15', 'active' => true,  'role' => 'trainee',              'role_notes' => 'Tirocinio post-laurea magistrale.'],
            ['name' => 'Francesco Gallo',    'email' => 'francesco.gallo@biblioteca.edu',    'employee_id' => 'BIB-0015', 'department' => 'Sezione Economica',     'specialization' => 'Marketing e Management',    'phone' => '+39 06 1234 5692', 'hire_date' => '2011-06-20', 'active' => false, 'role' => 'cataloger',            'role_notes' => null],
        ];

        foreach ($librarians as $data) {
            Librarian::create($data);
        }
    }
}