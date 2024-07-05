<?php

namespace Database\Seeders;

use App\Models\Issue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Issue::create([
            'title' => 'Ticket Machine Malfunction',
            'description' => 'Encountered a malfunctioning ticket machine at the train station, preventing the purchase of tickets for the journey. Despite several attempts, the machine displayed errors or did not respond, necessitating alternative payment methods and causing delays in boarding.',
            'status' => 1,
            'category' => 3,
            'priority' => 2,
            'user_id' => 1,
        ]);

        Issue::create([
            'title' => 'Escalator Out of Service',
            'description' => 'Noticed that one of the escalators at the LRT station was out of service, forcing commuters to use the stairs or overcrowded elevators. The absence of the escalator posed challenges for elderly passengers, individuals with disabilities, and those carrying heavy luggage or strollers.',
            'status' => 1,
            'category' => 1,
            'priority' => 3,
            'user_id' => 1,
        ]);

        Issue::create([
            'title' => 'Broken Bench at KL Sentral Station',
            'description' => 'Noticed a broken bench at platform 3 of KL Sentral Station. The bench appeared damaged with missing parts, making it unusable for passengers waiting for trains. This issue poses an inconvenience, especially during peak hours when seating is limited.',
            'status' => 1,
            'category' => 1,
            'priority' => 1,
            'user_id' => 1,
        ]);

        Issue::create([
            'title' => 'Escalator Down at Ampang Park LRT Station',
            'description' => 'Encountered an out-of-service escalator at the Ampang Park LRT Station. The escalator leading to the concourse level was not functioning, forcing passengers to use stairs, which may pose challenges for elderly or differently-abled individuals.',
            'status' => 1,
            'category' => 1,
            'priority' => 3,
            'user_id' => 1,
        ]);
    }
}
