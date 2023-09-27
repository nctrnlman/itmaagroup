<?php

namespace App\Http\Controllers\Facilities;

use Illuminate\Http\Request;
use App\Models\Facilities\Atk;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class AtkController extends Controller
{
    public function index()
    {
        $atkList = Atk::all();
        return view('facilities.atk', ['atkList' => $atkList]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string|unique:atk,id_atk',
                'desc' => 'required|string',
            ]);

            Atk::create([
                'id_atk' => $request->input('id'),
                'description' => $request->input('desc'),
            ]);

            Alert::success('Success', 'ATK created successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to create ATK. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'id' => 'required|string|unique:atk,id_atk,' . $id,
                'desc' => 'required|string',
            ]);

            $atk = Atk::findOrFail($id);

            $atk->update([
                'id_atk' => $request->input('id'),
                'description' => $request->input('desc'),
            ]);

            Alert::success('Success', 'ATK updated successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to update ATK. ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $atk = Atk::find($id);
            $atk->delete();

            Alert::success('Success', 'ATK deleted successfully!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete ATK. ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
