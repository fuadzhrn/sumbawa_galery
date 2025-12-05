<?php

namespace App\Http\Controllers;

use App\Models\Seniman;
use Illuminate\Http\Request;

class SenimanController extends Controller
{
    /**
     * Display a listing of seniman
     */
    public function index()
    {
        $seniman = Seniman::with(['user', 'kategori'])->paginate(10);
        return view('admin.seniman', compact('seniman'));
    }

    /**
     * Show seniman detail (for modal/view)
     */
    public function show(Seniman $seniman)
    {
        return response()->json($seniman->load(['user', 'kategori']));
    }

    /**
     * Delete seniman
     */
    public function destroy(Seniman $seniman)
    {
        $seniman->delete();
        return redirect()->route('admin.seniman')->with('success', 'Seniman berhasil dihapus');
    }
}
