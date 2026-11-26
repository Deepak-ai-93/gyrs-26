@extends('layouts.public')

@section('title', 'About GYRS | Gujarat Youth Rojgar Setu')
@section('meta_description', 'Learn how GYRS brings job discovery, application tools and career resources together for job seekers across Gujarat.')

@section('content')
    <div class="about-page">
        <section class="about-hero" aria-labelledby="about-title">
            <div class="container">
                <div class="about-hero-grid">
                    <div class="about-hero-copy">
                        <p class="about-eyebrow"><x-icon name="sparkles" :size="16" /> About the portal</p>
                        <h1 id="about-title">A clearer path from skills to opportunity.</h1>
                        <p class="about-lead">
                            GYRS brings job discovery, application tools and career resources into one accessible place,
                            helping people across Gujarat explore their options and take the next step with confidence.
                        </p>
                        <div class="about-hero-actions">
                            <x-button variant="primary" :href="route('home').'#job-explorer'">
                                <x-icon name="search" :size="17" /> Explore opportunities
                            </x-button>
                            <x-button variant="outline" :href="route('candidate.register')">
                                Create a candidate profile
                            </x-button>
                        </div>
                        <p class="about-note"><x-icon name="check-circle" :size="16" /> Free to explore and create a candidate profile</p>
                    </div>

                    <aside class="about-journey-card" aria-label="How the portal supports your next step">
                        <div class="about-journey-heading">
                            <span class="about-journey-icon"><x-icon name="map-pin" :size="20" /></span>
                            <div>
                                <p class="about-card-kicker">Your next step, made simpler</p>
                                <h2>One place to move forward</h2>
                            </div>
                        </div>
                        <ol class="about-journey-list">
                            <li>
                                <span class="about-step-number">01</span>
                                <div><strong>Discover</strong><span>Find vacancies by role, skills and district.</span></div>
                            </li>
                            <li>
                                <span class="about-step-number">02</span>
                                <div><strong>Prepare</strong><span>Build a profile that reflects your experience.</span></div>
                            </li>
                            <li>
                                <span class="about-step-number">03</span>
                                <div><strong>Take action</strong><span>Save opportunities and keep track of applications.</span></div>
                            </li>
                            <li>
                                <span class="about-step-number">04</span>
                                <div><strong>Keep growing</strong><span>Explore résumé insights and skill-building ideas.</span></div>
                            </li>
                        </ol>
                    </aside>
                </div>
            </div>
        </section>

        <section class="about-section about-purpose" aria-labelledby="about-purpose-title">
            <div class="container">
                <div class="about-purpose-grid">
                    <div>
                        <p class="about-section-label">Why GYRS exists</p>
                        <h2 id="about-purpose-title">Make the search feel more connected.</h2>
                    </div>
                    <div class="about-purpose-copy">
                        <p>
                            Finding the right role can mean moving between vacancy listings, application details and
                            career advice. GYRS brings these useful steps together so job seekers can spend less time
                            searching in different places and more time making informed decisions.
                        </p>
                        <p>
                            Whether you are starting out, changing direction or building on what you already know,
                            the portal helps you explore opportunities across Gujarat at your own pace.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section about-features" aria-labelledby="about-features-title">
            <div class="container">
                <div class="about-section-heading">
                    <p class="about-section-label">What you can do</p>
                    <h2 id="about-features-title">Tools for each part of your career journey.</h2>
                    <p>Start with what you need now, and come back when you are ready for the next step.</p>
                </div>
                <div class="about-feature-grid">
                    <article class="about-feature-card">
                        <span class="about-feature-icon"><x-icon name="search" :size="21" /></span>
                        <h3>Explore opportunities</h3>
                        <p>Browse open vacancies and narrow your search by keyword, employment type or district.</p>
                        <a href="{{ route('home') }}#job-explorer" class="about-text-link">
                            Browse jobs <x-icon name="arrow-right" :size="16" />
                        </a>
                    </article>
                    <article class="about-feature-card">
                        <span class="about-feature-icon about-feature-icon-info"><x-icon name="user" :size="21" /></span>
                        <h3>Keep your profile ready</h3>
                        <p>Bring your qualifications, location and skills together in one candidate profile.</p>
                        <a href="{{ route('candidate.register') }}" class="about-text-link">
                            Create a profile <x-icon name="arrow-right" :size="16" />
                        </a>
                    </article>
                    <article class="about-feature-card">
                        <span class="about-feature-icon about-feature-icon-warm"><x-icon name="sparkles" :size="21" /></span>
                        <h3>Plan what comes next</h3>
                        <p>Use résumé insights, job matches and skill plans to identify practical next steps.</p>
                        <a href="{{ route('candidate.login') }}" class="about-text-link">
                            Visit candidate portal <x-icon name="arrow-right" :size="16" />
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section class="about-section about-values" aria-labelledby="about-values-title">
            <div class="container">
                <div class="about-values-panel">
                    <div class="about-values-heading">
                        <p class="about-section-label">Designed around job seekers</p>
                        <h2 id="about-values-title">A practical, people-first experience.</h2>
                        <p>Useful information should be easy to find and straightforward to act on.</p>
                    </div>
                    <div class="about-values-list">
                        <div><x-icon name="check-circle" :size="19" /><span><strong>Clear information</strong> — explore vacancy details before deciding what to do next.</span></div>
                        <div><x-icon name="map-pin" :size="19" /><span><strong>Local discovery</strong> — find opportunities across districts and employment types.</span></div>
                        <div><x-icon name="refresh" :size="19" /><span><strong>Progress you can follow</strong> — revisit saved roles and application updates in your portal.</span></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-section about-cta-section" aria-labelledby="about-cta-title">
            <div class="container">
                <div class="about-cta">
                    <div>
                        <p class="about-section-label">Your next step starts here</p>
                        <h2 id="about-cta-title">Ready to explore what is possible?</h2>
                        <p>Browse current opportunities or create a profile to make your search your own.</p>
                    </div>
                    <div class="about-hero-actions">
                        <x-button variant="primary" :href="route('home')">
                            <x-icon name="search" :size="17" /> Find opportunities
                        </x-button>
                        <x-button variant="outline" :href="route('candidate.register')">
                            Join as a candidate
                        </x-button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
