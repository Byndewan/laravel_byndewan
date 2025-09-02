<?php

namespace App\Http\Controllers\Rs;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    public function index()
    {
        $rumahSakits = RumahSakit::all();
        return view('rumah_sakit.index', compact('rumahSakits'));
    }

    public function create()
    {
        return view('rumah_sakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:rumah_sakits,email',
            'telepon' => 'required|numeric|digits_between:12,15',
        ]);

        RumahSakit::create($request->all());

        return redirect()->route('rumah-sakit.index')
            ->with('success', 'Rumah sakit berhasil ditambahkan.');
    }

    public function show(RumahSakit $rumahSakit)
    {
        return view('rumah_sakit.show', compact('rumahSakit'));
    }

    public function edit(RumahSakit $rumahSakit)
    {
        return view('rumah_sakit.edit', compact('rumahSakit'));
    }

    public function update(Request $request, RumahSakit $rumahSakit)
    {
        $request->validate([
            'nama_rumah_sakit' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:rumah_sakits,email,' . $rumahSakit->id,
            'telepon' => 'required|numeric|digits_between:12,15',
        ]);

        $rumahSakit->update($request->all());

        return redirect()->route('rumah-sakit.index')
            ->with('success', 'Rumah sakit berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rumahSakit = RumahSakit::find($id);

        if (!$rumahSakit) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        $checked = false;
        foreach (['pasiens'] as $rel) {
            if (method_exists($rumahSakit, $rel)) {
                $checked = true;
                if ($rumahSakit->{$rel}()->exists()) {
                    $count = $rumahSakit->{$rel}()->count();
                    return response()->json([
                        'error' => "Tidak dapat menghapus rumah sakit. Masih ada {$count} pasien terkait dengan rumah sakit ini."
                    ], 422);
                }
            }
        }

        if (! $checked) {
            if (Pasien::where('rumah_sakit_id', $rumahSakit->id)->exists()) {
                $count = Pasien::where('rumah_sakit_id', $rumahSakit->id)->count();
                return response()->json([
                    'error' => "Tidak dapat menghapus rumah sakit. Masih ada {$count} pasien terkait dengan rumah sakit ini."
                ], 422);
            }
        }

        $rumahSakit->delete();

        return response()->json(['success' => 'Data rumah sakit berhasil dihapus.']);
    }

}
