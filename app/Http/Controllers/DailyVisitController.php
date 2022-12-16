<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class DailyVisitController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Aufrufe Tag';
        $this->session_name = "daily_visits_table";
    }

    public function getFilterModal()
    {
        $return_array['ModalTitle'] = 'Aufrufe Tag Filter';
        return (string)view('daily-visit-admin.filter-modal')->with($return_array);
    }

    public function index()
    {
        \App\User::clearSession($this->session_name);
        $this->return_array['page_length'] = 500;
        $this->return_array['columns'] = array(
            'day' => array(
                'name' => 'Uhrzeit',
                'sort' => true,
            ),
            'domains.domain' => array(
                'name' => 'Domain',
                'sort' => true,
            ),
            'visits' => array(
                'name' => '	Visits_Adomino_net',
                'sort' => false,
            ),
            'adomino_com_total' => array(
                'name' => '	Visits_Adomino_com',
                'sort' => false,
            ),
            'adomino_com_ok' => array(
                'name' => 'Adomino_com_OK',
                'sort' => false,
            ),
            'total' => array(
                'name' => 'Visits_Total',
                'sort' => false,
            ),
        );
        return view('daily-visit-admin.index')->with($this->return_array);
    }

    public function getAllDailyVisitJson()
    {
        return DataTables::of(\App\DailyVisit::select('daily_visits.*', 'domains.domain')->join('domains', 'domains.id', '=', 'daily_visits.domain_id'))
            ->editColumn('day', function ($dailyVisit) {
                return '<p style="text-align: right;margin: 0px">' . date('Y-m-d', strtotime($dailyVisit->day)) . '</p>';
            })
            ->editColumn('domains.domain', function ($dailyVisit) {
//                return $dailyVisit->domain . "--" . $dailyVisit->domain_id;
                return $dailyVisit->domain;
            })
            ->editColumn('visits', function ($dailyVisit) {
                return '<p style="text-align: right;margin: 0px">' . $dailyVisit->visits . '</p>';
            })
            ->addColumn('adomino_com_total', function ($dailyVisit) {
                if (empty($dailyVisit->total))
                    return '<p style="text-align: right;margin: 0px">0</p>';
                else
                    return '<p style="text-align: right;margin: 0px">' . ($dailyVisit->total - $dailyVisit->visits) . '</p>';
            })
            ->editColumn('adomino_com_ok', function ($dailyVisit) {
                if ($dailyVisit->adomino_com_ok) {
                    return '<p style="text-align:center; margin-bottom:0px; line-height:0px;"><i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i></p>';
                } else {
                    return '<p style="text-align:center; margin-bottom:0px; line-height:0px;"><i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i></p>';
                }
            })
            ->editColumn('total', function ($dailyVisit) {
                return '<p style="text-align: right;margin: 0px">' . $dailyVisit->total . '</p>';
            })
            ->rawColumns([
                'day',
                'domains.domain',
                'visits',
                'adomino_com_total',
                'adomino_com_ok',
                'total',
            ])->make(true);
    }
}
