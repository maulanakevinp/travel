<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('user.show', compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function editProfil()
    {
        return view('user.edit-profil');
    }

    public function updateProfil(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $request->validate([
            'nama'  => ['required', 'string', 'max:32'],
            'nohp'  => ['required', 'digits_between:6,13'],
            'alamat' => ['required', 'string']
        ]);

        $user->name = $request->nama;
        $user->phone = $request->nohp;
        $user->address = $request->alamat;
        $user->save();

        alert()->success('Profil berhasil diperbarui','Berhasil');
        return redirect()->back();
    }

    public function pengaturan()
    {
        return view('user.pengaturan');
    }

    public function updatePengaturan(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $request->validate([
            'email'         => ['nullable', 'string', 'email', 'max:32', Rule::unique('users', 'email')->ignore($user)],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_lama' => ['required', 'string', 'min:8'],
        ]);

        if (Hash::check($request->password_lama, $user->password)) {
            $user->name = $request->name;

            if ($request->email) {
                $user->email = $request->email;
                $user->email_verified_at = null;
                $user->sendEmailVerificationNotification();
            }

            if ($request->password && $request->password_confirmation) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
            alert()->success('Pengaturan berhasil diperbarui','Berhasil');
            return redirect()->back();
        } else {
            alert()->error('Password yang anda masukkan salah','Gagal')->persistent();
            return redirect()->back();
        }
    }

    public function updateAvatar(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);

        $validator = Validator::make($request->all(), [
            'avatar' => ['required', 'image', 'mimes:png,jpeg', 'max:2048']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error'     => true,
                'message'   => $validator->errors()->all(),
                'avatar'    => $user->avatar
            ]);
        }

        if ($user->avatar != 'noavatar.jpg') {
            File::delete(storage_path('app/' . $user->avatar));
        }

        $user->avatar = $request->file('avatar')->store('public/avatar');
        $user->save();

        return response()->json([
            'error'     => false,
            'message'   => 'Foto profil berhasil diperbarui',
            'avatar'    => $user->avatar
        ]);
    }
}
