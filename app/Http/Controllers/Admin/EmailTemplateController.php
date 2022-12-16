<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'email_templates';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $template = null)
    {
        $this->return_array['email_template'] = '';
        $this->return_array['template'] = '';
        if ($template) {
            $email_template = EmailTemplate::find($template);
            if ($email_template) {
                $this->return_array['email_template'] = $email_template;
                $this->return_array['template'] = $template;
            }else {
                return redirect()->back();
            }
        }

        $this->return_array['email_template_types'] = EmailTemplate::orderBy('order_no', 'asc')->groupBy('type')->get();
        $this->return_array['email_templates'] = EmailTemplate::orderBy('order_no', 'asc')->get();
        
        return view('admin.dynamic_content.email_template.index', $this->return_array);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'template_name' => ['required', 'string']
        ]);
        $default_email_template_name = 'Auktion einladen (Deutsch)';
        $template = EmailTemplate::create($request->all());
        if ($template->template_name == $default_email_template_name) {
            $template->update([
                'default' => true
            ]);
        }
        return response()->json([
            'message' => 'Created'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\EmailTemplate  $email_template
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $email_template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\EmailTemplate  $email_template
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $email_tempalte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\EmailTemplate  $email_template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailTemplate $email_template)
    {
        $request->validate([
            'sender_name' => ['required', 'string'],
            'sender_email' => ['required', 'string'],
            'bcc' => ['nullable', 'string'],
            'email_subject' => ['required', 'string'],
            'email_text' => ['required', 'string'],
        ]);
        $email_template->update($request->all());
        return response()->json([
            'message' => 'E-Mail-Vorlage wurde gespeichert!',
            'status' => 200
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\EmailTemplate  $email_template
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $email_template)
    {
        //
    }
}
