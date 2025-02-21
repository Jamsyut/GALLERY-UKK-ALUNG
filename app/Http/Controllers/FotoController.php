<?php

namespace App\Http\Controllers;

use id;
use App\Models\Foto;
use App\Models\Like;
use App\Models\Album;
use App\Models\KomentarFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class FotoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'desc');
        $visibility = $request->input('visibility');

        $query = Foto::where('user_id', Auth::id());

        if ($search) {
            $query->where('judul', 'like', "%$search%");
        }

        if ($visibility) {
            $query->where('visibility', $visibility);
        }

        $fotos = $query->orderBy('created_at', $sort)->paginate(9);
        $albums = Album::where('user_id', Auth::id())->get();

        return view('fotos.index', compact('fotos', 'search', 'sort', 'visibility', 'albums'));
    }


    public function updateAlbum(Request $request, $id)
{
    $request->validate([
        'album_id' => 'required|exists:albums,id',
    ]);

    $foto = Foto::where('user_id', Auth::id())->findOrFail($id);
    $foto->update([
        'album_id' => $request->album_id,
    ]);

    return redirect()->route('fotos.index')->with('success', 'Foto berhasil dimasukkan ke album.');
}



    public function toggleLike(Request $request)
    {
        try {
            $request->validate([
                'foto_id' => 'required|exists:fotos,id',
            ]);

            $foto = Foto::findOrFail($request->foto_id);
            $userId = auth()->id();

            $like = Like::where('foto_id', $foto->id)
                ->where('user_id', $userId)
                ->first();

            if (!$like) {
                Like::create([
                    'foto_id' => $foto->id,
                    'user_id' => $userId,
                    'status' => 'liked'
                ]);
                $status = 'liked';
            } else {
                $newStatus = $like->status === 'liked' ? 'unliked' : 'liked';
                $like->update(['status' => $newStatus]);
                $status = $newStatus;
            }

            $likeCount = Like::where('foto_id', $foto->id)
                ->where('status', 'liked')
                ->count();

            return response()->json([
                'status' => $status,
                'likeCount' => $likeCount,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat memproses like'
            ], 500);
        }
    }



    public function create()
    {
        $albums = Album::where('user_id', Auth::id())->get();
        return view('fotos.create', compact('albums'));
    }

    public function store(Request $request)
    {
        // dd($request)->all();
        $request->validate([
            'judul' => 'required|string|max:15',
            'deskripsi' => 'required|string|max:50',
            'image' => 'required|image|max:2048|mimes:jpg,png,jpeg',
            'album_id' => 'nullable|exists:albums,id',
            'visibility' => 'required|in:public,private',
        ],[
            'judul.max'=> 'Maksimal huruf adalah 15',

            'deskripsi.max' => 'Maksimal huruf adalah 50 ',

            'image.max' => 'Maksimal ukuran foto adalah 2mb',
            'image.mimes' => 'Format foto harus jpg,png,jpeg',


        ]);


        $path = $request->file('image')->store('uploads', 'public');

        Foto::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $path,
            'album_id' => $request->album_id,
            'user_id' => Auth::id(),
            'visibility' => $request->visibility,
        ]);

        return redirect()->route('fotos.index')->with('success', 'Foto berhasil diunggah.');
    }


    public function public(Request $request)
    {
        $query = Foto::where('visibility', 'public')->with(['user', 'likes' => function ($query) {
            $query->where('status', 'liked');
        }]);

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('sort')) {
            if ($request->sort == 'terbaru') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('created_at', 'asc');
            } elseif ($request->sort == 'like_terbanyak') {
                $query->withCount('likes')->orderBy('likes_count', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $fotos = $query->paginate(9);

        return view('fotos.public', compact('fotos'));
    }



    public function show($id)
    {
        $fotos = Foto::where('id', $id)
            ->with(['user', 'likes' => function ($query) {
                $query->where('status', 'liked');
            }])
            ->firstOrFail();

        return view('fotos.show', compact('fotos'));
    }

    public function storeKomentar(Request $request, $foto_id)
    {
        $request->validate([
            'komentar' => 'required|string|max:100',
        ],[
            'komentar'=> 'Maksimal huruf adalah 100'
        ]);

        KomentarFoto::create([
            'foto_id' => $foto_id,
            'user_id' => auth()->id(),
            'komentar' => $request->komentar,
        ]);
        return back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        $fotos = Foto::findOrFail($id);
    Storage::delete('public/uploads' . $fotos->image);
        $fotos->delete();

        return redirect()->route('fotos.index')->with('success', 'Foto berhasil dihapus.');
    }
}
