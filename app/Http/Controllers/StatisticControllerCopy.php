<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use DataTables;

class StatisticControllerCopy extends Controller
{
    public function __construct()
    {
        set_time_limit(0);
        $this->return_array['sidebar'] = 'STATISTIK';
        $this->defaultDays = 9;
        $this->session_name = "statistics_table";
    }

    public function getFilterStatisticModal()
    {
        $return_array['ModalTitle'] = __('admin-statistics.filterDomainModalTitle');
        $return_array['tabIndexFalse'] = false;
        return (string)view('statistics-admin.filter-modal')->with($return_array);
    }

    public function index_new()
    {
        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'id' => array(
                'name' => '#',
                'sort' => false,
                'width' => '40px',
            ),
            'domains.adomino_com_id' => array(
                'name' => 'ID',
                'sort' => true,
                'width' => '40px',
            ),
            'domains.domain' => array(
                'name' => 'Domain',
                'sort' => true,
                'width' => '290px',
            ),
            'schnitt' => array(
                'name' => 'Schnitt',
                'sort' => false,
                'width' => '65px',
            ),
            'total' => array(
                'name' => 'Total',
                'sort' => true,
                'width' => '60px',
            )
        );
        /*return view('statistics-admin.index')->with($this->return_array);*/
        /*return $this->return_array;*/
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) && (bool)strtotime($_REQUEST['from_date']) === true) {
            $end_date = date('y-m-d', strtotime($_REQUEST['from_date']));
        } else {
            $end_date = date('y-m-d', strtotime('-1 day'));
        }
        if (isset($_REQUEST['no_of_days']) && !empty($_REQUEST['no_of_days']) && is_numeric($_REQUEST['no_of_days'])) {
            $start_date = date('y-m-d', strtotime('- ' . ($_REQUEST['no_of_days'] - 1) . ' days', strtotime($end_date)));
        } else {
            $start_date = date('y-m-d', strtotime('- ' . $this->defaultDays . ' days', strtotime($end_date)));
        }
        $columns = Schema::getColumnListing('visits_per_days');
        /*return $columns;*/
        $dateColumns = array();
        foreach ($columns as $column) {
            if (strpos($column, "day") !== false) {
                $columnDate = str_replace('day', '', $column);
                if (\App\statistic::check_in_range($start_date, $end_date, $columnDate)) {
                    $dateColumns[strtotime($columnDate)] = $column;
                }
            }
        }

        /*return $columns;*/
        krsort($dateColumns);
        foreach ($dateColumns as $dateColumn) {
            $date = date('d.m', strtotime(str_replace('day', '', $dateColumn)));
            $this->return_array['columns'][$dateColumn] = array(
                'name' => $date,
                'sort' => false,
                'width' => '50px',
            );
        }
        /*return $columns;*/
        $this->return_array['datas'] = array();
        $this->return_array['summary_table_columns'] = array();
        if (isset($_REQUEST['no_of_days'])) {
            $query = \App\statistic::select('visits_per_days.*', 'domains.domain as domain_name', 'domains.adomino_com_id as adominId')->join('domains', 'domains.id', '=', 'visits_per_days.domain_id');
            if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
                $search = trim($_REQUEST['search']);
                $query->where(function ($query) use ($search) {
                    $query->where('domains.domain', 'like', '%' . $search . '%');
//                        ->orwhere('domains.adomino_com_id', 'like', '%' . $search . '%');
                });
            }
            if (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'id') {
                $this->return_array['datas'] = $query->orderBy('domains.adomino_com_id', $_REQUEST['sort_type'])->get();
            } elseif (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain') {
                $this->return_array['datas'] = $query->orderBy('domains.domain', $_REQUEST['sort_type'])->get();
            } else {
                $this->return_array['datas'] = $query->orderBy('domains.adomino_com_id', 'asc')->get();
            }
            $dateColumns = array();
            foreach ($columns as $column) {
                if (strpos($column, "day") !== false) {
                    $columnDate = str_replace('day', '', $column);
                    if (\App\statistic::check_in_range($start_date, $end_date, $columnDate)) {
                        $dateColumns[strtotime($columnDate)] = $column;
                    }
                }
            }
            krsort($dateColumns);
            $this->return_array['custom_columns'] = array();
            foreach ($dateColumns as $dateColumn) {
                array_push($this->return_array['custom_columns'], $dateColumn);
            }
            $this->return_array['table_columns'] = $columns;
            $this->return_array['start_date'] = $start_date;
            $this->return_array['end_date'] = $end_date;

            $schnittCount = 0;
            $totalCount = 0;
//            echo '<pre>';
//            print_r($this->return_array['custom_columns']);
//            die;
            foreach ($this->return_array['datas'] as $statisticData) {
                try {
                    $statisticDetails = \App\statistic::getStatisticCount($columns, $start_date, $end_date, $statisticData);
                    $schnittCount += number_format(($statisticDetails[1] / $statisticDetails[0]), 2, '.', ',');
                    $totalCount += $statisticDetails[1];
                } catch (\Exception $exception) {
                    $schnittCount += 0;
                    $totalCount += 0;
                }
            }
            array_push($this->return_array['summary_table_columns'], $schnittCount);
            array_push($this->return_array['summary_table_columns'], $totalCount);
            foreach ($this->return_array['custom_columns'] as $custom_column) {
                $dateCount = 0;
                foreach ($this->return_array['datas'] as $statisticData) {
                    $dateCount += $statisticData->$custom_column;
                }
                array_push($this->return_array['summary_table_columns'], $dateCount);
            }
        }
        $this->return_array['total_count'] = \App\statistic::getContentCount();
        return view('statistics-admin.index')->with($this->return_array);
    }
    public function index()
    {
        User::clearSession($this->session_name);
        $this->return_array['page_length'] = -1;
        $this->return_array['columns'] = array(
            'id' => array(
                'name' => '#',
                'sort' => false,
                'width' => '40px',
            ),
            'domains.adomino_com_id' => array(
                'name' => 'ID',
                'sort' => true,
                'width' => '40px',
            ),
            'domains.domain' => array(
                'name' => 'Domain',
                'sort' => true,
                'width' => '290px',
            ),
            'schnitt' => array(
                'name' => 'Schnitt',
                'sort' => false,
                'width' => '65px',
            ),
            'total' => array(
                'name' => 'Total',
                'sort' => true,
                'width' => '60px',
            )
        );
        if (isset($_REQUEST['from_date']) && !empty($_REQUEST['from_date']) && (bool)strtotime($_REQUEST['from_date']) === true) {
            $end_date = date('y-m-d', strtotime($_REQUEST['from_date']));
        } else {
            $end_date = date('y-m-d', strtotime('-1 day'));
        }
        if (isset($_REQUEST['no_of_days']) && !empty($_REQUEST['no_of_days']) && is_numeric($_REQUEST['no_of_days'])) {
            $start_date = date('y-m-d', strtotime('- ' . ($_REQUEST['no_of_days'] - 1) . ' days', strtotime($end_date)));
        } else {
            $start_date = date('y-m-d', strtotime('- ' . $this->defaultDays . ' days', strtotime($end_date)));
        }
        $columns = Schema::getColumnListing('visits_per_days');
        $dateColumns = array();
        foreach ($columns as $column) {
            if (strpos($column, "day") !== false) {
                $columnDate = str_replace('day', '', $column);
                if (\App\statistic::check_in_range($start_date, $end_date, $columnDate)) {
                    $dateColumns[strtotime($columnDate)] = $column;
                }
            }
        }
        krsort($dateColumns);
        foreach ($dateColumns as $dateColumn) {
            $date = date('d.m', strtotime(str_replace('day', '', $dateColumn)));
            $this->return_array['columns'][$dateColumn] = array(
                'name' => $date,
                'sort' => false,
                'width' => '50px',
            );
        }
        $this->return_array['datas'] = array();
        $this->return_array['summary_table_columns'] = array();
        if (isset($_REQUEST['no_of_days'])) {
           /* $query = \App\statistic::select('visits_per_days.*', 'domains.domain as domain_name', 'domains.adomino_com_id as adominId')->join('domains', 'domains.id', '=', 'visits_per_days.domain_id');*/
            $query = \App\statistic::select('visits_per_days.*', 'domains.domain', 'domains.adomino_com_id')->join('domains', 'domains.id', '=', 'visits_per_days.domain_id');
            if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
                $search = trim($_REQUEST['search']);
                $query->where(function ($query) use ($search) {
                    $query->where('domains.domain', 'like', '%' . $search . '%');
//                        ->orwhere('domains.adomino_com_id', 'like', '%' . $search . '%');
                });
            }
            if (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'id') {
                $this->return_array['datas'] = $query->orderBy('domains.adomino_com_id', $_REQUEST['sort_type'])->get();
            } elseif (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain') {
                $this->return_array['datas'] = $query->orderBy('domains.domain', $_REQUEST['sort_type'])->get();
            } else {
                $this->return_array['datas'] = $query->orderBy('domains.adomino_com_id', 'asc')->get();
            }
            $dateColumns = array();
            foreach ($columns as $column) {
                if (strpos($column, "day") !== false) {
                    $columnDate = str_replace('day', '', $column);
                    if (\App\statistic::check_in_range($start_date, $end_date, $columnDate)) {
                        $dateColumns[strtotime($columnDate)] = $column;
                    }
                }
            }
            krsort($dateColumns);
            $this->return_array['custom_columns'] = array();
            foreach ($dateColumns as $dateColumn) {
                array_push($this->return_array['custom_columns'], $dateColumn);
            }
            $this->return_array['table_columns'] = $columns;
            $this->return_array['start_date'] = $start_date;
            $this->return_array['end_date'] = $end_date;

            $schnittCount = 0;
            $totalCount = 0;
//            echo '<pre>';
//            print_r($this->return_array['custom_columns']);
//            die;
            foreach ($this->return_array['datas'] as $statisticData) {
                try {
                    $statisticDetails = \App\statistic::getStatisticCount($columns, $start_date, $end_date, $statisticData);
                    $schnittCount += number_format(($statisticDetails[1] / $statisticDetails[0]), 2, '.', ',');
                    $totalCount += $statisticDetails[1];
                } catch (\Exception $exception) {
                    $schnittCount += 0;
                    $totalCount += 0;
                }
            }
            array_push($this->return_array['summary_table_columns'], $schnittCount);
            array_push($this->return_array['summary_table_columns'], $totalCount);
            foreach ($this->return_array['custom_columns'] as $custom_column) {
                $dateCount = 0;
                foreach ($this->return_array['datas'] as $statisticData) {
                    $dateCount += $statisticData->$custom_column;
                }
                array_push($this->return_array['summary_table_columns'], $dateCount);
            }
        }
        $this->return_array['total_count'] = \App\statistic::getContentCount();
        return view('statistics-admin.index')->with($this->return_array);
    }


    public function getAllStatisticsJson()
    {
        $query = \App\statistic::select('visits_per_days.*', 'domains.domain as domain_name', 'domains.adomino_com_id as adominId')->join('domains', 'domains.id', '=', 'visits_per_days.domain_id');
        $no_of_days = 0;
        if (isset($_REQUEST['filter'])) {
            $filter = json_decode($_REQUEST['filter'], true);
            if (isset($filter['no_of_days']) && !empty($filter['no_of_days']) && is_numeric($filter['no_of_days'])) {
                $no_of_days = $filter['no_of_days'];
            }
        }
        if (!empty($no_of_days)) {
            $start_date = date('y-m-d', strtotime('- ' . $no_of_days . ' days'));
        } else {
            $start_date = date('y-m-d', strtotime('- ' . $this->defaultDays . ' days'));
        }
        $end_date = date('y-m-d', strtotime('-1 day'));
        $columns = Schema::getColumnListing('visits_per_days');
        $dataTableObject = DataTables::of($query)
            ->editColumn('id', function ($statistic) {
                return '<p style="text-align: right;margin: 0px">' . $statistic->id . '</p>';
            })
            ->editColumn('domains.domain', function ($statistic) {
                return \App\Domain::displayDomain($statistic->domain_name, $statistic->domain_id);
            })
            ->editColumn('domains.adomino_com_id', function ($statistic) {
                return '<p style="text-align: right;margin: 0px">' . $statistic->adominId . '</p>';
            })
            ->addColumn('schnitt', function ($statistic) use ($columns, $start_date, $end_date) {
                try {
                    $statisticDetails = \App\statistic::getStatisticCount($columns, $start_date, $end_date, $statistic);
                    return '<p style="text-align: right;margin: 0px">' . number_format(($statisticDetails[1] / $statisticDetails[0]), 2, '.', ',') . '</p>';
                } catch (\Exception $exception) {
                    return '<p style="text-align: right;margin: 0px">0</p>';
                }
            })
            ->addColumn('total', function ($statistic) use ($columns, $start_date, $end_date) {
                $statisticDetails = \App\statistic::getStatisticCount($columns, $start_date, $end_date, $statistic);
                return '<p style="text-align: right;margin: 0px">' . $statisticDetails[1] . '</p>';
            });
        $rawColumns = [
            'domains.domain',
            'id',
            'domains.adomino_com_id',
            'schnitt',
            'total',
        ];
        $dateColumns = array();
        foreach ($columns as $column) {
            if (strpos($column, "day") !== false) {
                $columnDate = str_replace('day', '', $column);
                if (\App\statistic::check_in_range($start_date, $end_date, $columnDate)) {
                    array_push($rawColumns, $column);
                    $dateColumns[strtotime($columnDate)] = $column;
                }
            }
        }
        krsort($dateColumns);
        foreach ($dateColumns as $dateColumn) {
            $dataTableObject->addColumn($dateColumn, function ($statistic) use ($dateColumn) {
                return '<p style="text-align: right;margin: 0px">' . $statistic->$dateColumn . '</p>';
            });
        }
        return $dataTableObject->rawColumns($rawColumns)->make(true);
    }


}
