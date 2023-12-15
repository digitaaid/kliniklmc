<?php

namespace App\Http\Controllers;

use App\Models\FileUploadPasien;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class FileUploadController extends APIController
{
    public function index(Request $request)
    {
        $fileuploads = FileUploadPasien::with(['pasien'])->get();
        return view('sim.fileupload_index', compact([
            'request',
            'fileuploads',
        ]));
    }
    public function update($id, Request $request)
    {
        if ($request->file) {
            try {
                $url = 'http://103.39.50.206/lmc/public/api/uploadfile';
                $file               = request('file');
                $file_path          = $file->getPathname();
                $file_mime          = $file->getMimeType('application/pdf');
                $file_uploaded_name = $file->getClientOriginalName();
                $client = new Client();
                $response = $client->request("POST", $url, [
                    /** Multipart form data is your actual file upload form */
                    'multipart' => [
                        [
                            /** This is the actual fields name that you will use to access in API */
                            'name'      => 'file',
                            'filename' => $file_uploaded_name,
                            'Mime-Type' => $file_mime,

                            /** This is the main line, we are reading from file temporary uploaded location  */
                            'contents' => fopen($file_path, 'r'),
                        ],
                        /** Other form fields here, as we can't send form_fields with multipart same time */
                        [
                            /** This is the form filed that we will use to acess in API */
                            'name' => 'form-data',
                            /** We need to use json_encode to send the encoded data */
                            'contents' => json_encode(
                                [
                                    'nama' => 'Channaveer',
                                ]
                            )
                        ]
                    ]
                ]);
                $responseData = json_decode($response->getBody(), true);
                $res = json_decode(json_encode($responseData));
                if ($res->metadata->code == 200) {
                    $request['fileurl'] = $res->metadata->message;
                    $request['type'] = $file_mime;
                } else {
                    Alert::error('Mohon Maaf', $res->metadata->code);
                    return redirect()->back();
                }
            } catch (\Throwable $th) {
                Alert::error('Mohon Maaf', $th->getMessage());
                return redirect()->back();
            }
        }
        $file = FileUploadPasien::find($id);
        $file->update(
            $request->all()
        );
        Alert::success('Success', 'File Upload Pasien berhasil diperbaharui');
        return redirect()->back();
    }
    public function store(Request $request)
    {
        try {
            $url = 'http://103.39.50.206/lmc/public/api/uploadfile';
            $file               = request('file');
            $file_path          = $file->getPathname();
            $file_mime          = $file->getMimeType('application/pdf');
            $file_uploaded_name = $file->getClientOriginalName();
            $client = new Client();
            $response = $client->request("POST", $url, [
                /** Multipart form data is your actual file upload form */
                'multipart' => [
                    [
                        /** This is the actual fields name that you will use to access in API */
                        'name'      => 'file',
                        'filename' => $file_uploaded_name,
                        'Mime-Type' => $file_mime,

                        /** This is the main line, we are reading from file temporary uploaded location  */
                        'contents' => fopen($file_path, 'r'),
                    ],
                    /** Other form fields here, as we can't send form_fields with multipart same time */
                    [
                        /** This is the form filed that we will use to acess in API */
                        'name' => 'form-data',
                        /** We need to use json_encode to send the encoded data */
                        'contents' => json_encode(
                            [
                                'nama' => 'Channaveer',
                            ]
                        )
                    ]
                ]
            ]);
            $responseData = json_decode($response->getBody(), true);
            $res = json_decode(json_encode($responseData));
            if ($res->metadata->code == 200) {
                $request['fileurl'] = $res->metadata->message;
                $request['type'] = $file_mime;
                FileUploadPasien::create($request->all());
                Alert::success('Success', 'Upload File Penunjang Pasien Berhasil');
            } else {
                Alert::error('Mohon Maaf', $res->metadata->code);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Alert::error('Mohon Maaf', $th->getMessage());
        }
        return redirect()->back();
    }
    public function destroy($id, Request $request)
    {
        $file = FileUploadPasien::find($id);
        $file->delete();
        Alert::success('Success', 'File Penunjang Pasien berhasil dihapus.');
        return redirect()->back();
    }
    public function fileupload_norm(Request $request)
    {
        $files = FileUploadPasien::where('norm', $request->norm)->get();
        return $this->sendResponse($files, 200);
    }
}
