<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Librarian;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        $librarians = [
            ['employee_id' => 'EMP-001', 'name' => 'Margaret Collins',  'email' => 'margaret.collins@library.org',  'phone' => '555-0101', 'department' => 'Reference Services',  'active' => true,  'hire_date' => '2015-03-12'],
            ['employee_id' => 'EMP-002', 'name' => 'James Whitfield',   'email' => 'james.whitfield@library.org',   'phone' => '555-0102', 'department' => 'Cataloging',          'active' => true,  'hire_date' => '2018-07-01'],
            ['employee_id' => 'EMP-003', 'name' => 'Susan Nakamura',    'email' => 'susan.nakamura@library.org',    'phone' => '555-0103', 'department' => 'Children Services',   'active' => true,  'hire_date' => '2012-09-15'],
            ['employee_id' => 'EMP-004', 'name' => 'David Okafor',      'email' => 'david.okafor@library.org',      'phone' => '555-0104', 'department' => 'Digital Resources',   'active' => true,  'hire_date' => '2020-01-20'],
            ['employee_id' => 'EMP-005', 'name' => 'Emily Thornton',    'email' => 'emily.thornton@library.org',    'phone' => '555-0105', 'department' => 'Archives',            'active' => true,  'hire_date' => '2010-06-30'],
            ['employee_id' => 'EMP-006', 'name' => 'Robert Vasquez',    'email' => 'robert.vasquez@library.org',    'phone' => '555-0106', 'department' => 'Circulation',         'active' => true,  'hire_date' => '2017-11-08'],
            ['employee_id' => 'EMP-007', 'name' => 'Linda Park',        'email' => 'linda.park@library.org',        'phone' => '555-0107', 'department' => 'Reference Services',  'active' => true,  'hire_date' => '2019-04-22'],
            ['employee_id' => 'EMP-008', 'name' => 'Thomas Briggs',     'email' => 'thomas.briggs@library.org',     'phone' => '555-0108', 'department' => 'Acquisitions',        'active' => false, 'hire_date' => '2014-08-17'],
            ['employee_id' => 'EMP-009', 'name' => 'Patricia Dumont',   'email' => 'patricia.dumont@library.org',   'phone' => '555-0109', 'department' => 'Special Collections', 'active' => true,  'hire_date' => '2011-02-28'],
            ['employee_id' => 'EMP-010', 'name' => 'Carlos Rivera',     'email' => 'carlos.rivera@library.org',     'phone' => '555-0110', 'department' => 'Youth Services',      'active' => true,  'hire_date' => '2021-05-10'],
            ['employee_id' => 'EMP-011', 'name' => 'Angela Foster',     'email' => 'angela.foster@library.org',     'phone' => '555-0111', 'department' => 'Outreach',            'active' => true,  'hire_date' => '2016-10-03'],
            ['employee_id' => 'EMP-012', 'name' => 'Michael Chen',      'email' => 'michael.chen@library.org',      'phone' => '555-0112', 'department' => 'Technology Services', 'active' => true,  'hire_date' => '2022-03-14'],
            ['employee_id' => 'EMP-013', 'name' => 'Rachel Summers',    'email' => 'rachel.summers@library.org',    'phone' => '555-0113', 'department' => 'Interlibrary Loan',  'active' => false, 'hire_date' => '2013-12-05'],
            ['employee_id' => 'EMP-014', 'name' => 'William Adams',     'email' => 'william.adams@library.org',     'phone' => '555-0114', 'department' => 'Reference Services',  'active' => true,  'hire_date' => '2009-07-19'],
            ['employee_id' => 'EMP-015', 'name' => 'Dorothy Singh',     'email' => 'dorothy.singh@library.org',     'phone' => '555-0115', 'department' => 'Adult Programming',  'active' => true,  'hire_date' => '2023-01-09'],
        ];

        foreach ($librarians as $data) {
            Librarian::create($data);
        }
    }
}