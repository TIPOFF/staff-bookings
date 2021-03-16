<?php

declare(strict_types=1);

namespace Tipoff\StaffBookings;

use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;

class StaffBookings extends Tool
{
    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot(): void
    {
        Nova::script('booking', __DIR__.'/../dist/js/tool.js');
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View
     */
    public function renderNavigation(): View
    {
        return view('booking::navigation');
    }
}
