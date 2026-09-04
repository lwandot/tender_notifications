<?php

namespace Config;

/**
 * Development mock data for tenders
 */
class DevMocks
{
    public array $tenders = [];

    public function __construct()
    {
        $this->tenders = [
            [
                'ocid' => 'DEV-001',
                'title' => 'Supply of Office Chairs',
                'procuring_entity' => ['name' => 'Local Municipality'],
                'organ_of_state' => ['name' => 'Municipal Office'],
                'province' => ['name' => 'Gauteng'],
                'description' => 'Supply and delivery of ergonomic office chairs',
                'category' => ['Furniture'],
                'status' => 'active',
                'tenderPeriod' => ['startDate' => date('Y-m-d'), 'endDate' => date('Y-m-d', strtotime('+7 days'))],
                'published_date' => date('Y-m-d'),
                'closing_date' => date('Y-m-d', strtotime('+7 days')),
            ],
            [
                'ocid' => 'DEV-002',
                'title' => 'Road Maintenance - Region A',
                'procuring_entity' => ['name' => 'Dept. of Transport'],
                'organ_of_state' => ['name' => 'Transport Dept'],
                'province' => ['name' => 'Western Cape'],
                'description' => 'Routine road maintenance works',
                'category' => ['Works'],
                'status' => 'active',
                'tenderPeriod' => ['startDate' => date('Y-m-d'), 'endDate' => date('Y-m-d', strtotime('+7 days'))],
                'published_date' => date('Y-m-d'),
                'closing_date' => date('Y-m-d', strtotime('+7 days')),
            ],
        ];
    }
}
