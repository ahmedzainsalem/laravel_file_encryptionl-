<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SoareCostin\FileVault\Facades\FileVault;
use App\File;
use App\Organization;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $files = Storage::files('files/' . auth()->user()->id);
        $organizations = Organization::all();
        
        // Filter out the .DS_Store file
        $files = array_filter($files, function ($file) {
            return $file !== 'files/' . auth()->user()->id . '/.DS_Store';
        });

        return view('home', compact('files','organizations'));
    }

    /**
     * Store a user uploaded file
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'userFile' => 'required|file|mimes:doc,docx,xls,xlsx,ppt,pptx|max:2048',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        if ($request->hasFile('userFile') && $request->file('userFile')->isValid()) {
            $filename = Storage::putFile('files/' . auth()->user()->id, $request->file('userFile'));
            
            $fileEX = $request->file('userFile');
            $fileEX = $fileEX->getClientOriginalExtension();

            // check if we have a valid file uploaded
            if ($filename) {
                   FileVault::encrypt($filename);
                 
                   $encryfilename = str_replace('files/1/', '', $filename);
                   $encryfilename = pathinfo($encryfilename, PATHINFO_FILENAME) .".".$fileEX.'.enc';


                 // Save file details to the database
                    $file = new File();
                    $file->user_id = auth()->user()->id;
                    $file->filename = $encryfilename;
                    $file->organization_id = $request->input('organization_id'); 
                    $file->save();

            }
        }

        return redirect()->route('home')->with('message', 'Upload complete');
    }

    /**
     * Download a file
     *
     * @param  string  $filename
     * @return \Illuminate\Http\Response
     */
    public function downloadFile(Request $request)
    {
        $filename = request()->input('filename');

        // Basic validation to check if the file exists and is in the user directory
        if (!Storage::has('files/' . auth()->user()->id . '/' . $filename)) {
            // abort(404);
            return back()->with('faildmessage', 'File Not found');

            ?>
            <script>
                    alert('Not found');
            </script>
            <?php
        }

        // Check if the filename exists in the files table
        $file = File::where('filename', $filename)->where('user_id', auth()->user()->id)->first();

        if (!$file) {
            // abort(404);
            return back()->with('faildmessage', 'File Not found');
            ?>
            <script>
                    alert('Not Found');
            </script>
            <?php
        }

        // Ask for the public key before downloading the file
        $publicKey = request()->input('public_key');

        if ($publicKey !== $file->organization->public_key) {
            // abort(403, 'Invalid public key');
            return back()->with('faildmessage', 'Invalid public key');
            ?>
            <script>
                    alert('Invalid public key');
            </script>
            <?php
        }


        return response()->streamDownload(function () use ($filename) {
            FileVault::streamDecrypt('files/' . auth()->user()->id . '/' . $filename);
        }, Str::replaceLast('.enc', '', $filename));
    }

}
