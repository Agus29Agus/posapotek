<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('setting.index');
    }

    public function show()
    {
        return Setting::first();
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $setting->name_company = $request->name_company;
        $setting->phone = $request->phone;
        $setting->address = $request->address;
        $setting->discount = $request->discount;
        $setting->type_nota = $request->type_nota;

        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $name = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $name);

            $setting->path_logo = "/img/$name";
        }

        if ($request->hasFile('path_card_member')) {
            $file = $request->file('path_card_member');
            $name = 'logo-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $name);

            $setting->path_card_member = "/img/$name";
        }

        $setting->update();

        return response()->json('Data Submitted', 200);
    }
}
