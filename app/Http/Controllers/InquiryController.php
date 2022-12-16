<?php

namespace App\Http\Controllers;

use App\Inquiry;
use App\Mail\SendOfferMail;
use App\Models\Admin\Auction;
use App\Models\Admin\EmailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'Anfragen';
        $this->session_name = "inquiry_table";
    }

    public function getFilterModal()
    {
        $return_array['ModalTitle'] = 'Anfragen Filter';
        return (string)view('inquiry-admin.filter-modal')->with($return_array);
    }

    public function deleteInquiryProcess(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id_array = explode(',', $request->id);
        foreach ($id_array as $id) {
            \App\Inquiry::deleteInquiry($id);
        }
        return redirect()->back()->with('message', __('admin-inquiry.deleteInquirySuccessMessage'));
    }

    public function getDeleteInquiryModal(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = 'Anfrage löschen';
        $return_array['id'] = $request->id;
        return (string)view('inquiry-admin.delete-inquiry-modal')->with($return_array);
    }

    public function updateInquiryProcess(Request $request)
    {
        $this->validate($request, [
            'created_at' => 'required',
            'domain' => 'required',
            'gender' => 'required',
            'surname' => 'required',
            'website_language' => 'required',
            'email' => 'required|email',
            'id' => 'required|numeric',
        ]);
        $domainDetails = \App\Domain::findDomainByName($request->domain);
        if (isset($domainDetails->id) && !empty($domainDetails->id)) {
            $requestArray = $request->except(['_token', 'domain']);
            $requestArray['domain_id'] = $domainDetails->id;
            \App\Inquiry::saveInquiry($requestArray);
            return redirect()->back()->with('message', __('admin-inquiry.updateInquirySuccessMessage'));
        } else {
            return redirect()->back()
                ->withInput($request->input())
                ->with('error', 'Ungültiger Domainname');
        }

    }

    public function editInquiry($id)
    {
        if (!is_numeric($id) || empty($id)) {
            dd('id not found');
        }
        $this->return_array['inquiry'] = \App\Inquiry::getInquiry($id);
        $this->return_array['domain'] = '{"id":' . $this->return_array['inquiry']->domain_id . ',"text":' . $this->return_array['inquiry']->domain->domain . ',"adomino_com_id":' . $this->return_array['inquiry']->domain->adomino_com_id . '}';
        return view('inquiry-admin.new-inquiry')->with($this->return_array);
    }

    public function anonymousInquiryProcess(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $id_array = explode(',', $request->id);
        foreach ($id_array as $id) {
            \App\Inquiry::anonymousInquiry($id);
        }
        return redirect()->back()->with('message', __('admin-inquiry.anonymousInquirySuccessMessage'));
    }

    public function getAnonymousInquiryModal(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        $return_array['ModalTitle'] = 'Anonyme Anfrage';
        $return_array['id'] = $request->id;
        return (string)view('inquiry-admin.anonymous-inquiry-modal')->with($return_array);
    }

    public function addNewInquiry()
    {
        return view('inquiry-admin.new-inquiry')->with($this->return_array);
    }

    public function addNewInquiryProcess(Request $request)
    {
        $this->validate($request, [
            'created_at' => 'required',
            'domain' => 'required',
            'gender' => 'required',
            'website_language' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
        ]);

        $domainDetails = \App\Domain::findDomainByName($request->domain);
        if (isset($domainDetails->id) && !empty($domainDetails->id)) {
            $requestArray = $request->except(['_token', 'domain']);
            $requestArray['domain_id'] = $domainDetails->id;
            \App\Inquiry::saveInquiry($requestArray);
            return redirect()->back()->with('message', __('admin-inquiry.addInquirySuccessMessage'));
        } else {
            return redirect()->back()
                ->withInput($request->input())
                ->with('error', 'Ungültiger Domainname');
        }
    }

    public function index()
    {
        \App\User::clearSession($this->session_name);
        $this->return_array['page_length'] = 500;
        $this->return_array['columns'] = array(
            'checkbox' => array(
                'name' => '',//<input type="checkbox" id="selectAllCheckbox"/>
                'sort' => false,
                'width' => '2px',
            ),
            'actions' => array(
                'name' => '',
                'sort' => false,
                'width' => '18px',
            ),
            'created_at' => array(
                'name' => 'Anfrage Uhrzeit',
                'sort' => true,
                'width' => '30px',
            ),
            'offer_time' => array(
                'name' => 'Angebot Uhrzeit',
                'sort' => true,
                'width' => '30px',
            ),
            'domains.domain' => array(
                'name' => 'Domain',
                'sort' => false,
                'width' => '100px',
            ),
            'offer_price' => array(
                'name' => 'Angebot Preis',
                'sort' => true,
                'width' => '30px',
            ),
            'gender' => array(
                'name' => 'Anrede',
                'sort' => false,
                'width' => '50px',
            ),
           /* 'prename' => array(
                'name' => 'Vorname',
                'sort' => false,
                'width' => '80px',
            ),*/
            'surname' => array(
                'name' => 'Nachname',
                'sort' => false,
                'width' => '120px',
            ),
            'email' => array(
                'name' => 'E-Mail',
                'sort' => false,
                'width' => '138px',
            ),
            'anonymous' => array(
                'name' => 'Anonymisieren',
                'sort' => false,
                'width' => '30px',
            ),
        );
        return view('inquiry-admin.index')->with($this->return_array);
    }

    public function getAllInquiryJson()
    {
        $query = \App\Inquiry::select('inquiries.*', 'domains.domain as domain_name')
            ->join('domains', 'domains.id', '=', 'inquiries.domain_id');
        if (isset($_REQUEST['filter']) && !empty($_REQUEST['filter'])) {
            session([$this->session_name => [
                'filter' => $_REQUEST['filter'],
                'search' => $_REQUEST['search']['value'],
                'page_length' => $_REQUEST['length'],
            ]]);
            $filterArray = json_decode($_REQUEST['filter'], true);
            if (isset($filterArray['no_of_days']) && !empty($filterArray['no_of_days']) && is_numeric($filterArray['no_of_days'])) {
                $query->whereBetween('inquiries.created_at', [date('Y-m-d', strtotime("-" . $filterArray['no_of_days'] . " days")) . " 00:00:00", date('Y-m-d') . " 23:59:59"]);
            }
            if (isset($filterArray['trashed']) && !empty($filterArray['trashed'])) {
                if ($filterArray['trashed'] == 'yes') {
                    $query->withTrashed();
                }
                if ($filterArray['trashed'] == 'only') {
                    $query->onlyTrashed();
                }
            }
        } elseif (isset($_REQUEST['search']['value'])) {
            session([$this->session_name => [
                'filter' => '',
                'search' => $_REQUEST['search']['value'],
                'page_length' => $_REQUEST['length'],
            ]]);
        }

        return DataTables::of($query)
            ->addColumn('checkbox', function ($inquiry) {
                return '<input type="checkbox" data-row-id="' . $inquiry->id . '" class="selectCheckBox"/>';
            })
            ->editColumn('created_at', function ($inquiry) {
                return '<p style="text-align: right;margin: 0px">' . date('Y-m-d H:i', strtotime($inquiry->created_at)) . '</p>';
            })
            ->editColumn('offer_time', function ($inquiry) {
                return '<p style="text-align: right;margin: 0px">' .( $inquiry->offer_time ? date('Y-m-d H:i', strtotime($inquiry->offer_time)) : '' ). '</p>';
            })
            ->editColumn('offer_price', function ($inquiry) {
                return '<p style="text-align: right;margin: 0px">' .( $inquiry->offer_price ? number_format($inquiry->offer_price , 0, ',', '.') : '' ). '</p>';
            })
            ->editColumn('domains.domain', function ($inquiry) {
                return '<a style="color:rgb(0 0 153)"  href="http://' . $inquiry->domain->domain . '" target="_blank">' . $inquiry->domain->domain . '</a>';
            })
            ->editColumn('gender', function ($inquiry) {
                if ($inquiry->gender === 'm') {
                    return 'Herr';
                } elseif ($inquiry->gender === 'f') {
                    return 'Frau';
                }else{
                    return 'Interessent';
                }
            })
            ->editColumn('prename', function ($inquiry) {
                return $inquiry->prename;
            })
            ->editColumn('surname', function ($inquiry) {
                return $inquiry->surname;
            })
            ->editColumn('email', function ($inquiry) {
                return $inquiry->email;
            })
            ->addColumn('anonymous', function ($inquiry) {
                return '<label data-href="' . route('get-anonymous-inquiry-modal') . '"
                data-id="' . $inquiry->id . '"
                style="margin-bottom: 2px;margin-top: 2px;padding:0px 4px 0px 4px"
                data-name="get-anonymous-inquiry-modal" class="OpenModal btn btn-primary btn-xs">' . ucfirst(__('admin-inquiry.anonymousButton')) . '</label>';
            })
            ->addColumn('actions', function ($inquiry) {
                return '
                <a href="' . route('edit-domain', [$inquiry->domain_id]) . '"><img src="' . url('/img/wpage.gif') . '"/></a>&nbsp;&nbsp;
                <a target="_blank" href="' . route('edit-inquiry', [$inquiry->id]) . '" 
                style="cursor: pointer;color: black"><i class="fa fa-edit"></i></a>';
//                &nbsp;&nbsp;
//                <label data-href="' . route('get-delete-inquiry-modal') . '"
//                data-id="' . $inquiry->id . '"
//                data-name="get-delete-inquiry-modal" style="cursor: pointer" class="OpenModal"><i class="fa fa-trash"></i></label>
            })
            ->rawColumns([
                'checkbox',
                'anonymous',
                'domain_details',
                'id',
                'created_at',
                'offer_time',
                'offer_price',
                'domains.domain',
                'gender',
                /*'prename',*/
                'surname',
                'website_language',
                'browser_language',
                'email',
                'ip',
                'actions',
            ])->make(true);
    }

    public function create_offer(Request $request, Inquiry $inquiry){
        $email = EmailTemplate::where(['lang' => $request->lang,'type' => 'offer' ])->first();
        if(!$email){
            return response()->json([
                'error' => 'E-Mail-Vorlage nicht gefunden.',
                'status' => 400,
            ], 200);
        }
        $inquiry->update([
            'prename' => $request->prename,
            'surname' => $request->surname,
            'email' => $request->email,
            'gender' => $request->gender,
            'website_language' => $request->lang,
            'offer_price' => $request->offer_price,
        ]);
        $domain = $inquiry->domain->domain;

        $gender = 'Sehr geehrter Herr';
        $name = $gender . ' ' . $inquiry->surname;
        if ($request->lang == 'en') {
            $gender = 'Dear Sir';
            $name = $gender . ' ' . $inquiry->surname;
        }
        if($inquiry->gender === 'f')  {
            $gender = 'Sehr geehrte Frau ';
            $name = $gender . ' ' . $inquiry->surname;
            if ($request->lang == 'en') {
                $gender = 'Dear Mrs';
                $name = $gender . ' ' . $inquiry->surname;
            }
        }
        if($inquiry->gender === 'i')  {
            $gender = 'Sehr geehrter Interessent';
            $name = $gender /* . ' '. $inquiry->prename*/;
            if ($request->lang == 'en') {
                $gender = 'Dear Interested Party';
                $name = $gender /*. ' ' . $inquiry->surname*/;
            }
        }

        $email_data['mail_to'] = $inquiry->email;
        $email_data['mail_from'] = ($email->sender_name ?? 'Adomino.net') .' <'.($email->sender_email ?? 'office@adomino.net').'>' ;
        $email_data['mail_from_email'] =  ($email->sender_email ?? 'office@adomino.net') ;
        $email_data['mail_from_name'] = ($email->sender_name ?? 'Adomino.net')  ;
        $email_data['bcc'] = $email->bcc ?? 'cc@day.eu';
        $email_data['subject'] = str_replace('[[domain]]', $domain , $email->email_subject);
        /*$step = number_format($auction->steps, 0 , ',', '.');
        $replace_tag = ['[[domain]]', '[[anrede-nachname]]', '[[auktion-startzeit]]', '[[auktion-endzeit]]', '[[auktion-startpreis]]', '[[auktion-endpreis]]', '[[auktion-tage]]', '[[auktion-schritt]]'];
        $replace_data = [$domain , $name , Carbon::parse($auction->start_date)->format('d.m.Y H:i'), Carbon::parse($auction->end_date)->format('d.m.Y H:i'), number_format($auction->start_price , 0 , ',', '.'), number_format($auction->end_price , 0 , ',', '.'), $auction->days, $step];
        */

        $replace_tag = ['[[anredeUndNachname]]','[[domain]]','[[vkpreis]]'];
        $replace_data = [$name, $domain , number_format($inquiry->offer_price, 0 , ',', '.')];
        $email_data['message'] = str_replace($replace_tag, $replace_data , $email->email_text);
        return response()->json([
            'message' => 'create_offer',
            'data' => $email_data,
            'status' => 200,
        ], 200);
    }
    public function send_offer(Request $request, Inquiry $inquiry){
        $inquiry->update([
            'offer_time' => Carbon::now(),
            'offer_price' => $request->offer_price,
        ]);
        Mail::to($request->mail_to)->send(new SendOfferMail($request->all()));
        return response()->json([
            'message' => 'Das Angebot wurde erfolgreich versendet.',
            'status' => 200,
            'data' => $request->all(),
        ], 200);
    }
}
