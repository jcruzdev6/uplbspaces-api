<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class Facility extends Model
{
    use HasFactory;
    /*protected $casts = [
        'available_days' => 'array',
    ];*/

    public function getAvailableDaysAttribute($value)
    {
        // $value will be the value of the 'available_days' column from the database
        // We'll remove the curly braces and split the string into an array
        return explode(',', trim($value, '{}'));
    }

    public function facility_type()
    {
        return $this->belongsTo('App\Models\FacilityType');
    }

    public function department_unit()
    {
        return $this->belongsTo('App\Models\DepartmentUnit');
    }

    public function facility_rates()
    {
        return $this->hasMany('App\Models\FacilityRate');
    }

    public function getGroupedDays()
    {
        $days = $this->available_days;
        if (empty($days)) {
            return null; // or an empty string, depending on your use case
        }

        // Create an array with the sequence of the day of the week
        $weekDaysSequence = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

        // Sort the days based on the sequence of the day of the week
        usort($days, function ($day1, $day2) use ($weekDaysSequence) {
            $day1Index = array_search($day1, $weekDaysSequence);
            $day2Index = array_search($day2, $weekDaysSequence);
            return $day1Index - $day2Index;
        });

        $groupedDays = [];
        $currentGroup = [$days[0]];

        // Iterate through the days, and group consecutive days together
        for ($i = 1; $i < count($days); $i++) {
            $currentDay = $days[$i];
            $previousDay = $days[$i - 1];

            $currentDayIndex = array_search($currentDay, $weekDaysSequence);
            $previousDayIndex = array_search($previousDay, $weekDaysSequence);

            if ($currentDayIndex - $previousDayIndex === 1) {
                // Continue adding days to the current group
                $currentGroup[] = $currentDay;
            } else {
                // End of consecutive days, add the current group to the result
                $groupedDays[] = $currentGroup[0] . ' - ' . end($currentGroup);
                // Start a new group with the current day
                $currentGroup = [$currentDay];
            }
        }

        // Add the last group to the result
        $groupedDays[] = $currentGroup[0] . ' - ' . end($currentGroup);

        // If there's only one group (all days are consecutive), return it as is
        if (count($groupedDays) === 1) {
            return $groupedDays[0];
        }

        return implode(', ', $groupedDays);
    }

}
