<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use Exception;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $companies = Company::orderBy('created_at', 'desc')->paginate(10);

        return view('company.index', compact('companies'));
    }


    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->get('remember'))) {

            return redirect()->intended('home');
        }
        return back()
            ->with('error', 'Oppes! You have entered invalid credentials')
            ->withInput($request->only('email'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function redirect(Request $request)
    {
        $client = new Client();

        $client->setAuthConfig(config('drive.client_credential'));
        $client->setRedirectUri(config('drive.redirect_url'));
        $client->addScope(Drive::DRIVE);

        if (!isset($request->code)) {
            $auth_url = $client->createAuthUrl();
            return view('admin.auth_drive', compact('auth_url'));
        }

        $client->fetchAccessTokenWithAuthCode($request->code);

        $token = $client->getAccessToken();
        session([
            'token' => $token['access_token'],
            'expireIn' => $token['expires_in'],
            'created' => $token['created'],
        ]);

        $auth_url = "";
        return view('admin.auth_drive', compact('auth_url'));
    }

    public function download()
    {
        dd(session('token'), session('expireIn'), session('created'));
        try {
            $client = new Client();
            $client->setAuthConfig(config('drive.client_credential'));
            $client->addScope(Drive::DRIVE);


            if (!session('token')) {
                return redirect()->route('google-drive.redirect');
            }


            $client->setAccessToken(session('token'));
            $fileId = '1MWVrUOfTqZGYSc1oUjlMIWxROjzFk4uk';
            $driveService = new Drive($client);


            $file = $driveService->files->get($fileId);

            // return $file->name;
            // $response = $driveService->files->get($fileId, array(
            //     'alt' => 'media'
            // ));

            // $content = $response->getBody()->getContents();
            // $result = Storage::put($file->name, $content);

            return Storage::download($file->name);
        } catch (\Throwable $e) {
            return "Error Message: " . $e;
        }
    }

    public function getFileName()
    {

        try {
            # code...
            $client = new Client();
            $client->setAuthConfig(config('drive.client_credential'));
            $client->addScope(Drive::DRIVE);

            // if (!session('token')) {
            //     return redirect()->route('google-drive.redirect');
            // }


            $client->setAccessToken(session('token'));
            $fileId = '1MWVrUOfTqZGYSc1oUjlMIWxROjzFk4uk';
            $fileId = '1QtpQODU0HSz1gWnyCNKDmewovIBzrJN9';
            $driveService = new Drive($client);

            // return view('admin.download', compact('driveService'));

            // dd($driveService);
            $file = $driveService->files->get($fileId);


            dd($file);

            return $file->webContentLink;
        } catch (\Throwable $e) {
            # code...
            return "Error Message: " . $e;
        }
    }


    // function download()
    // {
    //     try {
    //         $client = new Client();
    //         $client->setApplicationName("Testing");
    //         $client->setDeveloperKey("AIzaSyATm6-ynK5t1mGc1czaim_oMlDB4-D32Kw");
    //         $fileId = '1MWVrUOfTqZGYSc1oUjlMIWxROjzFk4uk';
    //         $client->addScope(Drive::DRIVE);
    //         $driveService = new Drive($client);

    //         $file = $driveService->files->get($fileId);

    //         $response = $driveService->files->get($fileId, array(
    //             'alt' => 'media'
    //         ));

    //         $content = $response->getBody()->getContents();
    //         $result = Storage::put($file->name, $content);

    //         return Storage::download($file->name);
    //         return $result;
    //     } catch (Exception $e) {
    //         return "Error Message: " . $e;
    //     }
    // }


    // function downloadFile()
    // {
    //     try {

    //         $client = new Client();
    //         $client->useApplicationDefaultCredentials();
    //         $client->addScope(Drive::DRIVE);
    //         $driveService = new Drive($client);
    //         $fileId = '0BwwA4oUTeiV1UVNwOHItT0xfa2M';
    //         $response = $driveService->files->get($fileId, array(
    //             'alt' => 'media'
    //         ));
    //         $content = $response->getBody()->getContents();
    //         return $content;
    //     } catch (Exception $e) {
    //         echo "Error Message: " . $e;
    //     }
    // }
}
