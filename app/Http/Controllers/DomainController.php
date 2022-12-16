<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class DomainController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Domains';
        $this->session_name = "domain_table";
    }

    public function getFilterDomainModal(Request $request)
    {
        $return_array['ModalTitle'] = __('admin-domain.filterDomainModalTitle');
        return (string)view('domain-admin.filter-modal')->with($return_array);
    }

    public function deleteDomainProcess(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        \App\Domain::deleteDomain($request->id);
        return redirect()->back()->with('message', __('admin-domain.deleteDomainSuccessMessage'));
    }

    public function getDeleteDomainModal(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = __('admin-domain.deleteDomainModalTitle');
        $return_array['id'] = $request->id;
        return (string)view('domain-admin.delete-modal')->with($return_array);
    }

    public function editDomain($id)
    {
        if (!is_numeric($id) || empty($id)) {
            dd('id not found');
        }
        $this->return_array['domain'] = \App\Domain::getDomain($id);
        $info = json_decode($this->return_array['domain']->info, true);
        $this->return_array['domain']->info_de = (isset($info['de']) && !empty($info['de'])) ? $info['de'] : '';
        $this->return_array['domain']->info_en = (isset($info['en']) && !empty($info['en'])) ? $info['en'] : '';
        $this->return_array['landingpage_mode'] = \App\Domain::getLandingPageMode();
        return view('domain-admin.new-domain')->with($this->return_array);
    }

    public function addNewDomainProcess(Request $request)
    {
        $this->validate($request, [
            'domain' => 'required|unique:domains,domain',
            'adomino_com_id' => 'unique:domains,adomino_com_id|numeric'
        ]);
        $requestArray = $request->except(['_token', 'old_url']);
        if (isset($requestArray['brandable']))
            $requestArray['brandable'] = 1;
        else
            $requestArray['brandable'] = 0;
        $requestArray['info'] = json_encode(array('de' => $requestArray['info_de'], 'en' => $requestArray['info_en']));
        \App\Domain::saveDomain($requestArray);
        return redirect()->back()->with('message', __('admin-domain.addDomainSuccessMessage'));
    }

    public function updateDomainProcess(Request $request)
    {
        $this->validate($request, [
            'domain' => 'required|unique:domains,domain,' . $request->id,
            'adomino_com_id' => 'numeric|unique:domains,adomino_com_id,' . $request->id,
        ]);
        $requestArray = $request->except(['_token', 'old_url']);
        if (isset($requestArray['brandable']))
            $requestArray['brandable'] = 1;
        else
            $requestArray['brandable'] = 0;
        $requestArray['info'] = json_encode(array('de' => $requestArray['info_de'], 'en' => $requestArray['info_en']));
        unset($requestArray['info_de']);
        unset($requestArray['info_en']);
        \App\Domain::saveDomain($requestArray);
        return redirect()->back()->with(['message' => __('admin-domain.updateDomainSuccessMessage'), 'old_url' => $request->old_url]);
    }

    public function addNewDomainPage()
    {
        $this->return_array['landingpage_mode'] = \App\Domain::getLandingPageMode();
        return view('domain-admin.new-domain')->with($this->return_array);
    }

    public function index()
    {
        \App\User::clearSession($this->session_name);
//        $this->return_array['page_length'] = -1;
//        $this->return_array['page_length'] = 10;
//        $this->return_array['columns'] = array(
////            'checkbox' => array(
////                'name' => '<input type="checkbox" id="selectAllCheckbox"/>',
////                'sort' => false,
////            ),
//            'id' => array(
//                'name' => 'ID',
//                'sort' => true,
//            ),
//            'info' => array(
//                'name' => 'Info',
//                'sort' => false,
//            ),
//            'domain' => array(
//                'name' => 'Domain',
//                'sort' => true,
//            ),
//            'title' => array(
//                'name' => 'Title',
//                'sort' => false,
//            ),
//            'adomino_com_id' => array(
//                'name' => 'Adomin.com ID',
//                'sort' => true,
//            ),
//            'landingpage_mode' => array(
//                'name' => 'Landing Page Modus',
//                'sort' => false,
//            ),
//            'brandable' => array(
//                'name' => 'Brandable',
//                'sort' => false,
//            ),
//            'actions' => array(
//                'name' => 'Actions',
//                'sort' => false,
//            ),
//        );
        if (isset($_REQUEST['is_filtered']) && !empty($_REQUEST['is_filtered']) && $_REQUEST['is_filtered'] == 'true') {
            $filter = $_REQUEST;
            $query = \App\Domain::query();
            if (isset($filter['is_deleted']) && $filter['is_deleted'] == 'yes') {
                $query->withTrashed();
            } elseif (isset($filter['is_deleted']) && $filter['is_deleted'] == 'only') {
                $query->onlyTrashed();
            }
            if (isset($filter['title']) && $filter['title'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('title')
                        ->where('title', '!=', '');
                });
            } elseif (isset($filter['title']) && $filter['title'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('title')
                        ->orWhere('title', '');
                });
            }
            if (isset($filter['info_en']) && $filter['info_en'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('info->en')
                        ->where('info->en', '!=', '');
                });
            } elseif (isset($filter['info_en']) && $filter['info_en'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('info->en')
                        ->orWhere('info->en', '');
                });
            }
            if (isset($filter['info_de']) && $filter['info_de'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('info->de')
                        ->where('info->de', '!=', '');
                });
            } elseif (isset($filter['info_de']) && $filter['info_de'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('info->de')
                        ->orWhere('info->de', '');
                });
            }
//            echo idn_to_utf8($this->return_array['domain']->domain_name, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
//            echo idn_to_ascii($this->return_array['domain']->domain_name, IDNA_DEFAULT, INTL_IDNA_VARIANT_UTS46);
//            die;
            if (isset($_REQUEST['search_params']) && !empty($_REQUEST['search_params'])) {
                $searchParams = trim($_REQUEST['search_params']);
                $query->where(function ($query) use ($searchParams) {
//                    $query->where('info->de', 'like', '%' . $searchParams . '%')
//                        ->orwhere('info->en', 'like', '%' . $searchParams . '%')
                    $query->orwhere('domain', 'like', '%' . $searchParams . '%');
//                        ->orwhere('title', 'like', '%' . $searchParams . '%')
//                        ->orwhere('landingpage_mode', 'like', '%' . $searchParams . '%');
                });
            }
            if (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'id') {
                $this->return_array['domains'] = $query->orderBy('adomino_com_id', $_REQUEST['sort_type'])->get();
            } elseif (isset($_REQUEST['sort']) && !empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'domain') {
                $this->return_array['domains'] = $query->orderBy('domain', $_REQUEST['sort_type'])->get();
            } else {
                $this->return_array['domains'] = $query->orderBy('domain', 'asc')->get();
            }
            $this->return_array['domain_count'] = \App\Domain::getCountAllDomain();
        }
        return view('domain-admin.index')->with($this->return_array);
    }

    public function getAllDomain()
    {
        $domains = \App\Domain::getAllDomain(true)->toArray();
        $more = false;
        $domain_data = array();
        if (isset($domains['data']) && !empty($domains['data'])) {
            $more = true;
            $domain_data = $domains['data'];
        }
        return response()->json(['results' => $domain_data, 'pagination' => ['more' => $more]]);
    }

    public function getAllDomainsJson()
    {
        $query = \App\Domain::query();
        if (isset($_REQUEST['filter'])) {
            $filter = json_decode($_REQUEST['filter'], true);
            if (isset($filter['is_deleted']) && $filter['is_deleted'] == 'yes') {
                $query->withTrashed();
            } elseif (isset($filter['is_deleted']) && $filter['is_deleted'] == 'only') {
                $query->onlyTrashed();
            }
            if (isset($filter['title']) && $filter['title'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('title')
                        ->where('title', '!=', '');
                });
            } elseif (isset($filter['title']) && $filter['title'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('title')
                        ->orWhere('title', '');
                });
            }
            if (isset($filter['info_en']) && $filter['info_en'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('info->en')
                        ->where('info->en', '!=', '');
                });
            } elseif (isset($filter['info_en']) && $filter['info_en'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('info->en')
                        ->orWhere('info->en', '');
                });
            }
            if (isset($filter['info_de']) && $filter['info_de'] == 'yes') {
                $query->where(function ($query) {
                    $query->whereNotNull('info->de')
                        ->where('info->de', '!=', '');
                });
            } elseif (isset($filter['info_de']) && $filter['info_de'] == 'no') {
                $query->where(function ($query) {
                    $query->whereNull('info->de')
                        ->orWhere('info->de', '');
                });
            }
        }

        return DataTables::of($query)
            ->addColumn('checkbox', function ($domain) {
                return '<input type="checkbox" data-row-id="' . $domain->id . '" class="selectCheckBox"/>';
            })
            ->editColumn('id', function ($domain) {
                return $domain->id;
            })
            ->editColumn('info', function ($domain) {
                $info = '';
                if (!empty($domain->getTranslation('info', 'de'))) {
                    $info .= 'd';
                }
                if (!empty($domain->getTranslation('info', 'en'))) {
                    $info .= 'e';
                }
                return $info;
            })
            ->editColumn('domain', function ($domain) {
                return $domain->domain;
            })
            ->editColumn('title', function ($domain) {
                return $domain->title;
            })
            ->editColumn('adomino_com_id', function ($domain) {
                return $domain->adomino_com_id;
            })
            ->editColumn('landingpage_mode', function ($domain) {
                return \App\Domain::getLandingPageMode()[$domain->landingpage_mode];
            })
            ->editColumn('brandable', function ($domain) {
                if ($domain->brandable) {
                    return '<i class="fa fa-check-circle" style="font-size: 20px;color: #67b100;"></i>';
                } else {
                    return '<i class="fa fa-times-circle" style="font-size: 20px;color: #ff0000b5;"></i>';
                }
            })
            ->addColumn('actions', function ($domain) {
                return '
                <a href="' . route('edit-domain', [$domain->id]) . '"
                style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                <label data-href="' . route('get-delete-domain-modal') . '"
                data-id="' . $domain->id . '"
                data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>';
            })
            ->rawColumns([
                'checkbox',
                'id',
                'info',
                'domain',
                'title',
                'adomino_com_id',
                'landingpage_mode',
                'brandable',
                'actions',
            ])->make(true);
    }
}
