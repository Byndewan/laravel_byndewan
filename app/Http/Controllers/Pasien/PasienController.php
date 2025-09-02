<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $rumahSakits = RumahSakit::all();
        $selectedRS = $request->get('rumah_sakit_id');

        $pasiens = Pasien::when($selectedRS, function($query) use ($selectedRS) {
            return $query->where('rumah_sakit_id', $selectedRS);
        })->with('rumahSakit')->get();

        return view('pasien.index', compact('pasiens', 'rumahSakits', 'selectedRS'));
    }

    public function create()
    {
        $rumahSakits = RumahSakit::all();
        return view('pasien.create', compact('rumahSakits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric|digits_between:10,15',
            'rumah_sakit_id' => 'required|exists:rumah_sakits,id'
        ]);

        Pasien::create($request->all());

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        $rumahSakits = RumahSakit::all();
        return view('pasien.edit', compact('pasien', 'rumahSakits'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|numeric|digits_between:10,15',
            'rumah_sakit_id' => 'required|exists:rumah_sakits,id'
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil diperbarui.');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Pasien berhasil dihapus.']);
        }

        return redirect()->route('pasien.index')
            ->with('success', 'Pasien berhasil dihapus.');
    }

    public function getByRumahSakit($rumahSakitId)
    {
        $pasiens = Pasien::where('rumah_sakit_id', $rumahSakitId)->get();
        return response()->json($pasiens);
    }
}
