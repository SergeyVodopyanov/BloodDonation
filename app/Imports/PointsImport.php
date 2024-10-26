<?php

namespace App\Imports;

use App\Models\Point;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class PointsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $Point = Point::where('city', $row['gorod'])
                                ->where('address', $row['adres'])
                                ->first();

        if ($Point) {
            $Point->update([
                'first_blood_group_count' => $row['gruppa_krovi'] == 1 ? $row['kolicestvo'] : $Point->first_blood_group_count,
                'second_blood_group_count' => $row['gruppa_krovi'] == 2 ? $row['kolicestvo'] : $Point->second_blood_group_count,
                'third_blood_group_count' => $row['gruppa_krovi'] == 3 ? $row['kolicestvo'] : $Point->third_blood_group_count,
                'fourth_blood_group_count' => $row['gruppa_krovi'] == 4 ? $row['kolicestvo'] : $Point->fourth_blood_group_count,
            ]);
        } else {
            $Point = new Point([
                'title' => 'Поликлиника ' . rand(1, 100),
                'city' => $row['gorod'],
                'address' => $row['adres'],
                'geolocation' => $row['geolokaciia'],
                'first_blood_group_count' => $row['gruppa_krovi'] == 1 ? $row['kolicestvo'] : 0,
                'second_blood_group_count' => $row['gruppa_krovi'] == 2 ? $row['kolicestvo'] : 0,
                'third_blood_group_count' => $row['gruppa_krovi'] == 3 ? $row['kolicestvo'] : 0,
                'fourth_blood_group_count' => $row['gruppa_krovi'] == 4 ? $row['kolicestvo'] : 0,
            ]);
            $Point->save();
        }

        return $Point;
    }
}
