<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_about_page_is_public_and_links_to_candidate_actions(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('A clearer path from skills to opportunity.')
            ->assertSee(route('home').'#job-explorer', false)
            ->assertSee(route('candidate.register'), false);
    }
}
