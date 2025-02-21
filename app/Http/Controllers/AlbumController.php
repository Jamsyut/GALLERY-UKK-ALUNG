<?php
    namespace App\Http\Controllers;

    use App\Models\album;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Foto;

    class AlbumController extends Controller
    {
        public function index()
        {
            $albums = album::with('fotos')->where('user_id', Auth::id())->get();
            return view('albums.index', compact('albums'));
        }


        public function removePhoto($album_id, $foto_id)
        {
            $foto = Foto::where('user_id', Auth::id())->where('album_id', $album_id)->findOrFail($foto_id);


            $foto->update(['album_id' => null]);

            return redirect()->route('albums.show', $album_id)->with('success', 'Foto berhasil dihapus dari album.');
        }

        public function create()
        {
            return view('albums.create');
        }

        public function store(Request $request)
        {
            $request->validate([
                'nama_album' => 'required|string|max:15',
                'deskripsi' => 'required|string|max:50',
            ],[
                'nama_album.max'=> 'Maksimal huruf adalah 15',

                'deskripsi.max'=> 'Maksimal huruf adalah 50',
            ]);

            Album::create([
                'nama_album' => $request->nama_album,
                'deskripsi' => $request->deskripsi,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('albums.index')->with('success', 'Album berhasil dibuat.');
        }

        public function show ($id)
        {
            $album = Album::with('fotos')->findOrFail($id);

            return view('albums.show', compact('album'));
        }

        public function destroy($id)
        {
            $album = Album::findOrFail($id);
            $album->delete();

            return redirect()->route('albums.index')->with('success', 'Album berhasil dihapus');
        }

    }

