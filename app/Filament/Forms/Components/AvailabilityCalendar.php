<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class AvailabilityCalendar extends Field
{
    protected string $view = 'filament.forms.components.availability-calendar';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([]);

        $this->afterStateHydrated(function (AvailabilityCalendar $component, $state) {
            if (is_null($state) || ! is_array($state)) {
                $component->state([]);
            }
        });

        $this->dehydrateStateUsing(function ($state) {
            if (! is_array($state)) {
                return [];
            }

            return $state;
        });
    }
}
