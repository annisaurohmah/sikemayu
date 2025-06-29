<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HasYearFilter
{
    /**
     * Get selected year from request or use current year as default
     *
     * @param Request $request
     * @return int
     */
    protected function getSelectedYear(Request $request): int
    {
        return $request->get('tahun', now()->year);
    }

    /**
     * Get years range for dropdown (current year - 10 years)
     *
     * @return array
     */
    protected function getYearsRange(): array
    {
        $currentYear = now()->year;
        $years = [];
        
        for ($year = $currentYear; $year >= ($currentYear - 10); $year--) {
            $years[$year] = $year;
        }
        
        return $years;
    }
}
