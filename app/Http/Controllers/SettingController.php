<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

use App\Traits\Watzap;
use App\Traits\EmailTraits;
class SettingController extends Controller
{
    use Watzap, EmailTraits;
    public function tes_wa()
    {
        //

        $params = [];
        // $params['target'] = '082110711099, 082110711099';
        $params['user_id'] = '3';
        // $params['role']     = 'business_owner, brandcomm';
        $params['message']  = 'Hallo [NAME]';
        // $params['image']    = 'https://www.telkomsel.com/sites/default/files/mainlogo-2022-rev.png';

        $this->send_watzap($params);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('settings.index')->with('settings', Setting::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('seksi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
        return view('settings.detail')->with('setting', $setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
        $this->validate(
            $request,
            [
                'key' => 'required',
                'value' => 'required',
                'desc' => 'required',
            ],
            [
                'key.required' => 'Please input key, Thank You.',
                'value.required' => 'Please Input value, Thank You.',
                'desc.required' => 'Input Description, Thank You.',
            ]
        );
        // dd($request->all());

        $setting->update([
            'key' => $request->key,
            'value' => $request->value,
            'description' => $request->desc,
            'updated_by' => auth()->user()->id,
        ]);
        $setting->save();

        session()->flash('message', ' setting was updated successfully.');
        return redirect(route('settings.index'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
