<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Seksi;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('profiles.index')->with('profiles', Profile::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('profiles.create')->with('seksis', Seksi::where('status', 1)->get());
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
        $this->validate(
            $request,
            [
                'name' => 'required',
                'tanggal_lahir' => 'required',
                'no_hp' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'seksi' => 'required',
                'status' => 'required',
                'password' => 'required',
                // 'photo' => 'mimes:jpg,jpeg,png',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'tanggal_lahir.required' => 'Please input tanggal lahir, Thank You.',
                'no_hp.required' => 'Please input no hp, Thank You.',
                'email.required' => 'Please input email, Thank You.',
                'alamat.required' => 'Please input alamat, Thank You.',
                'seksi.required' => 'Please select seksi , Thank You.',
                'status.required' => 'Please set status, Thank You.',
                'password.required' => 'Please set password login, Thank You.',
                // 'photo.mimes' => 'Please select photo file format jpg,jpeg,png, Thank You.',
            ]
        );
        // dd($request->all());




        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_by' => auth()->user()->id,
        ]);
        $user->save();

        $profile = new Profile([
            //
            'user_id' => $user->id,
            'seksi_id' => $request->seksi,
            'name' => $request->name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        $profile->save();

        $userContact = new UserContact([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->no_hp,
            'email' => $request->email,
            'created_by' => auth()->user()->id,
        ]);

        $userContact->save();

        session()->flash('message', ' profile & user was created successfully.');
        return redirect(route('profiles.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
        return view('profiles.detail')->with('profile', $profile)->with('seksis', Seksi::where('status', 1)->get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //

        $this->validate(
            $request,
            [
                'name' => 'required',
                'tanggal_lahir' => 'required',
                'no_hp' => 'required',
                'email' => 'required',
                'alamat' => 'required',
                'seksi' => 'required',
                'status' => 'required',
                // 'photo' => 'mimes:jpg,jpeg,png',
            ],
            [
                'name.required' => 'Please input name, Thank You.',
                'tanggal_lahir.required' => 'Please input tanggal lahir, Thank You.',
                'no_hp.required' => 'Please input no hp, Thank You.',
                'email.required' => 'Please input email, Thank You.',
                'alamat.required' => 'Please input alamat, Thank You.',
                'seksi.required' => 'Please select seksi , Thank You.',
                'status.required' => 'Please set status, Thank You.',
                // 'photo.mimes' => 'Please select photo file format jpg,jpeg,png, Thank You.',
            ]
        );

        $user = User::find($profile->user_id);

        if ($request->password != null) {
            # code...
            // dump('pass ada');

            $user->update([
                'password' => bcrypt($request->password),
                'updated_by' => auth()->user()->id,
            ]);
            $user->save();
        }

        $profile->update([
            //
            'user_id' => $user->id,
            'seksi_id' => $request->seksi,
            'name' => $request->name,
            'tanggal_lahir' => $request->tanggal_lahir,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'created_by' => auth()->user()->id,
        ]);

        $profile->save();

        session()->flash('message', ' profile & user was updated successfully.');
        return view('profiles.detail')->with('profile', $profile)->with('seksis', Seksi::where('status', 1)->get());


        // dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
