<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Seed Categories
        $categories = [
            ['name' => 'IT & Telecommunications', 'slug' => 'it-telecommunications', 'description' => 'Information Technology and Telecommunications services'],
            ['name' => 'Construction & Works', 'slug' => 'construction-works', 'description' => 'Construction, engineering and infrastructure works'],
            ['name' => 'Professional Services', 'slug' => 'professional-services', 'description' => 'Legal, accounting, consulting and other professional services'],
            ['name' => 'Supply & Delivery', 'slug' => 'supply-delivery', 'description' => 'Supply and delivery of goods and materials'],
            ['name' => 'Maintenance & Support', 'slug' => 'maintenance-support', 'description' => 'Maintenance, support and repair services'],
            ['name' => 'Training & Development', 'slug' => 'training-development', 'description' => 'Training, development and capacity building services'],
        ];

        foreach ($categories as $category) {
            $this->db->table('categories')->insert($category);
        }

        // Seed Provinces
        $provinces = [
            ['name' => 'Eastern Cape', 'code' => 'EC'],
            ['name' => 'Free State', 'code' => 'FS'],
            ['name' => 'Gauteng', 'code' => 'GT'],
            ['name' => 'KwaZulu-Natal', 'code' => 'KN'],
            ['name' => 'Limpopo', 'code' => 'LP'],
            ['name' => 'Mpumalanga', 'code' => 'MP'],
            ['name' => 'Northern Cape', 'code' => 'NC'],
            ['name' => 'North West', 'code' => 'NW'],
            ['name' => 'Western Cape', 'code' => 'WC'],
        ];

        foreach ($provinces as $province) {
            $this->db->table('provinces')->insert($province);
        }

        // Seed Organs of State
        $organs = [
            [
                'name' => 'Department of Public Works',
                'slug' => 'department-public-works',
                'description' => 'National Department of Public Works',
                'contact_email' => 'info@publicworks.gov.za'
            ],
            [
                'name' => 'Department of Education',
                'slug' => 'department-education',
                'description' => 'National Department of Education',
                'contact_email' => 'info@education.gov.za'
            ],
            [
                'name' => 'Department of Health',
                'slug' => 'department-health',
                'description' => 'National Department of Health',
                'contact_email' => 'info@health.gov.za'
            ],
            [
                'name' => 'South African Police Service',
                'slug' => 'saps',
                'description' => 'South African Police Service',
                'contact_email' => 'info@saps.gov.za'
            ],
            [
                'name' => 'Department of Transport',
                'slug' => 'department-transport',
                'description' => 'National Department of Transport',
                'contact_email' => 'info@transport.gov.za'
            ],
            [
                'name' => 'Eskom Holdings',
                'slug' => 'eskom',
                'description' => 'Eskom Holdings SOC Ltd',
                'contact_email' => 'info@eskom.co.za'
            ],
            [
                'name' => 'South African Airways',
                'slug' => 'sa-airways',
                'description' => 'South African Airways',
                'contact_email' => 'info@flysaa.com'
            ],
        ];

        foreach ($organs as $organ) {
            $this->db->table('organs_of_state')->insert($organ);
        }

        echo "Initial data seeded successfully!";
    }
}
