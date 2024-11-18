<?php

namespace App\Helpers;

use App\Models\Country;
use App\Models\District;
use App\Models\Jamiat\Campus;
use App\Models\Jamiat\EducationLevel;
use App\Models\Jamiat\Exam;
use App\Models\Jamiat\Grade;
use App\Models\Jamiat\Language;
use App\Models\Province;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class JamiaHelper
{

    public static function grades()
    {
        return Grade::where("status", "active")->get();
    }

    public static function educationLevels()
    {
        return EducationLevel::all();
    }

    public static function languages()
    {
        return Language::all();
    }

    public static function exams()
    {
        return Exam::all();
    }

    public static function campuses()
    {
        return Campus::all();
    }

    public static function countries()
    {
        return Country::all();
    }

    public static function afgProDis()
    {
        $afg_provinces = Province::where('country_id', 1)->get();
        $afg_districts = District::whereIn('province_id', $afg_provinces->pluck('id'))->get();
        return [
            'provinces' => $afg_provinces,
            'districts' => $afg_districts
        ];
    }

    public static function applyStudentFilters(Builder $query, Request $request)
    {
        return $query->when($request->form_id, function ($query) use ($request) {
            $query->where('students.form_id', 'like', "%$request->form_id%");
        })
            ->when($request->filter_name, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->filter_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->filter_name . '%')
                    ->orWhereRaw("CONCAT(name, ' ', last_name) LIKE ?", ["%$request->filter_name%"]);
            })
            ->when($request->tazkira_no, function ($query) use ($request) {
                $query->whereHas('tazkira', function ($q) use ($request) {
                    $q->where('tazkira_no', 'like', '%' . $request->tazkira_no . '%');
                });
            })
            ->when($request->filter_address_type_id, function ($query) use ($request) {
                $query->where('address_type_id', $request->filter_address_type_id);
            })
            ->when($request->phone, function ($query) use ($request) {
                $phone = substr($request->phone, 1);
                $query->where('phone', 'like',  "%$phone%");
            })
            ->when($request->filter_country_id, function ($query) use ($request) {
                $query->whereHas('school.province.country', function ($q) use ($request) {
                    $q->where('country_id', $request->filter_country_id);
                });
            })
            ->when($request->filter_province_id, function ($query) use ($request) {
                $query->whereHas('permanentDistrict.province', function ($q) use ($request) {
                    $q->where('province_id', $request->filter_province_id);
                });
            })
            // ->when($request->filter_district_id, function ($query) use ($request) {
            //     $query->where('current_district_id', $request->filter_district_id);
            // })
            // ->when($request->filter_village, function ($query) use ($request) {
            //     $query->where('current_village', 'like', '%' . $request->filter_village . '%');
            // })
            ->when($request->user_group_id, function ($query) use ($request) {
                $query->whereHas('createdBy.userGroup', function ($query) use ($request) {
                    $query->where('id', $request->user_group_id);
                });
            })
            ->when($request->user_id, function ($query) use ($request) {
                $query->whereHas('createdBy', function ($query) use ($request) {
                    $query->where('id', $request->user_id);
                });
            })
            ->when($request->school_id, function ($query) use ($request) {
                $query->where('school_id', $request->school_id);
            })
            ->when($request->appreciation_id, function ($query) use ($request) {
                $query->where('appreciation_id', $request->appreciation_id);
            })
            ->when($request->address_type_id, function ($query) use ($request) {
                $query->where('address_type_id', $request->address_type_id);
            });
    }

    public static function studentAppreciationBadge($appreciation)
    {
        $badgeColor = '';
        switch ($appreciation?->id) {
            case 1:
                $badgeColor = 'primary';
                break;
            case 2:
                $badgeColor = 'info';
                break;
            case 3:
                $badgeColor = 'success';
                break;
            case 4:
                $badgeColor = 'warning';
                break;
        }

        return "<span
        class='badge bg-$badgeColor'
        >" . $appreciation?->name . '</span>';
    }

    public static function studentExamStatus($status)
    {
        $badgeColor = '';
        $badgeText = '';
        switch ($status) {
            case 'class selected':
                $badgeColor = 'primary';
                $badgeText = __('jamiat.class_selected');
                break;
            case 'created':
                $badgeColor = 'success';
                break;
            case 2:
                $badgeColor = 'info';
                break;
            case 3:
                $badgeColor = 'success';
                break;
            default:
                $badgeColor = 'warning';
                $badgeText = __('jamiat.pending');
                break;
        }

        return "<span
        class='badge bg-$badgeColor'
        >" . $badgeText . '</span>';
    }
}
