<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CommonSetting;
use Illuminate\Http\Request;

class FreeMailBlacklistController extends Controller
{
    public function __construct()
    {
        $this->return_array['sidebar'] = 'mail_black_list';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mail_black_list = CommonSetting::where('key','black_list')->first();
        $this->return_array['black_list'] = $mail_black_list ? $mail_black_list->value :  '';
        return view('admin.auction.free_mail_blacklist.index', $this->return_array);
    }
    public function black_list(Request $request)
    {
        $request->validate([
            'black_list' => ['string', 'required']
        ]);
        $mail_black_list = CommonSetting::where('key','black_list')->first();
        if($mail_black_list){
            $mail_black_list->value = $request->black_list;
            $mail_black_list->save();
        }else{
            CommonSetting::create([
                'key' => 'black_list',
                'value' => $request->black_list,
            ]);
        }
        return redirect()->route('admin.black_list')->with('message' , 'Freemail Blacklist wurde gespeichert.');

    }


}
