<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class VisitsController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Aufrufe IP';
        $this->session_name = "visits_table";
    }

    public function getFilterModal()
    {
        $return_array['ModalTitle'] = 'Aufrufe IP-Adresse Filter';
        return (string)view('visits-admin.filter-modal')->with($return_array);
    }

    public function index()
    {
        \App\User::clearSession($this->session_name);
        $this->return_array['page_length'] = 500;
        $this->return_array['columns'] = array(
            'created_at' => array(
                'name' => 'Uhrzeit',
                'sort' => true,
            ),
            'domains.domain' => array(
                'name' => 'Domain',
                'sort' => true,
            ),
            'ip' => array(
                'name' => 'IP-Adresse',
                'sort' => true,
            ),
        );
        return view('visits-admin.index')->with($this->return_array);
    }

    public function getAllVisitsJson()
    {
        return DataTables::of(\App\Visit::select('domains.domain', 'visits.*')->join('domains', 'domains.id', '=', 'visits.domain_id'))
            ->editColumn('created_at', function ($visits) {
                return '<p style="text-align: right;margin: 0px">' . $visits->created_at . '</p>';
            })
            ->editColumn('domains.domain', function ($visits) {
                return '<a style="color:rgb(0 0 153)"  href="http://' . $visits->domain . '" target="_blank">' . $visits->domain . '</a>';
            })
            ->editColumn('ip', function ($visits) {
                return '<p style="text-align: left;margin: 0px">' . $visits->ip . '</p>';
            })
            ->rawColumns([
                'created_at',
                'domains.domain',
                'ip',
            ])->make(true);
    }
}
