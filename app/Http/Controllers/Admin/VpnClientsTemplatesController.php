<?php

namespace App\Http\Controllers\Admin;

use App\Entity\VpnClientsTemplates;
use App\Entity\VpnGroups;
use App\Entity\VpnLog;
use App\Entity\VpnUsers;
use App\Http\Requests\Admin\VpnClientsTemplates\CreateRequest;
use App\Shared;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class VpnClientsTemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:config_edit')->only('create','store', 'destroy', 'edit', 'update', 'changeStatus');
    }

    public function index(Request $request)
    {

        if (Auth::user()->can('admin')) {
            $query = VpnClientsTemplates::orderBy('id', 'desc');
        } else {
            $query = VpnClientsTemplates::where('status', Shared::STATUS_ACTIVE)->orderBy('id', 'desc');
        }

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('protocol'))) {
            $query->where('protocol', $value);
        }

        if (!empty($value = $request->get('port'))) {
            $query->where('port', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('host'))) {
            $query->where('host', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('pageSize')) && (is_numeric($value))) {
            $clients = $query->paginate($value);
        } else {
            $clients = $query->paginate(Shared::DEFAULT_PAGINATE);
        }



        return view('admin.vpnclients.index', compact('clients'));
    }


    public function create()
    {
        return view('admin.vpnclients.create');
    }


    public function store(CreateRequest $request)
    {
        $ca_file = $request->file('ca_file');
        $cert_file = $request->file('cert_file');
        $key_file = $request->file('key_file');

        $caFileName = time().'-'.$ca_file->getClientOriginalName();
        $certFileName = time().'-'.$cert_file->getClientOriginalName();
        $keyFileName = time().'-'.$key_file->getClientOriginalName();

        Storage::disk('public')->put(
            VpnClientsTemplates::UPLOAD_PATH.'/'.$caFileName,  File::get($ca_file)
        );
        Storage::disk('public')->put(
            VpnClientsTemplates::UPLOAD_PATH.'/'.$certFileName,  File::get($cert_file)
        );
        Storage::disk('public')->put(
            VpnClientsTemplates::UPLOAD_PATH.'/'.$keyFileName,  File::get($key_file)
        );

        $user = VpnClientsTemplates::new(
            $request['name'],
            $request['protocol'],
            $request['host'],
            $request['port'],
            $caFileName,
            $certFileName,
            $keyFileName,
            $request['comment']
        );
        return redirect()->route('admin.vpnclients.show', ['id' => $user->id]);
    }

    public function show($id)
    {

        if (Auth::user()->can('admin')) {
            $client = VpnClientsTemplates::findOrFail($id);
        } else {
            $client = VpnClientsTemplates::where([
                ['id', $id],
                ['status', Shared::STATUS_ACTIVE]
            ])->firstOrFail();
        }
        return view('admin.vpnclients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = VpnClientsTemplates::findOrFail($id);
        return view('admin.vpnclients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = VpnClientsTemplates::findOrFail($id);
        $client->fill($request->except('ca_file', 'cert_file', 'key_file'));

        if($request->hasFile('ca_file')) {
            Storage::disk('public')->delete($client->getCAPath());
            $ca_file = $request->file('ca_file');
            $caFileName = time().'-'.$ca_file->getClientOriginalName();
            Storage::disk('public')->put(
                VpnClientsTemplates::UPLOAD_PATH.'/'.$caFileName,  File::get($ca_file)
            );
            $client->ca_file = $caFileName;
        }
        if($request->hasFile('cert_file')) {
            Storage::disk('public')->delete($client->getCertPath());
            $cert_file = $request->file('cert_file');
            $certFileName = time().'-'.$cert_file->getClientOriginalName();
            Storage::disk('public')->put(
                VpnClientsTemplates::UPLOAD_PATH.'/'.$certFileName,  File::get($cert_file)
            );
            $client->cert_file = $certFileName;
        }
        if($request->hasFile('key_file')) {
            Storage::disk('public')->delete($client->getKeyPath());
            $key_file = $request->file('key_file');
            $keyFileName = time().'-'.$key_file->getClientOriginalName();
            Storage::disk('public')->put(
                VpnClientsTemplates::UPLOAD_PATH.'/'.$keyFileName,  File::get($key_file)
            );
            $client->key_file = $keyFileName;
        }

        $client->save();
        return redirect()->route('admin.vpnclients.show', $client);
    }

    public function destroy($id)
    {
        $client = VpnClientsTemplates::findOrFail($id);
        Storage::disk('public')->delete($client->getCAPath());
        Storage::disk('public')->delete($client->getCertPath());
        Storage::disk('public')->delete($client->getKeyPath());
        $client->delete();
        return redirect()->route('admin.vpnclients.index');
    }

    public function changeStatus($id)
    {
        $client = VpnClientsTemplates::findOrFail($id);
        if($client->isActive()) {
            $client->block();
        } elseif($client->isBlocked()) {
            $client->activate();
        }
        return redirect()->route('admin.vpnclients.show', $client);
    }

    public function config($id)
    {
        $client = VpnClientsTemplates::findOrFail($id);
        $fileName = $client->name . '.ovpn';

        $ca = file_get_contents('storage/'.$client->getCAPath());
        $cert = file_get_contents('storage/'.$client->getCertPath());
        $key = file_get_contents('storage/'.$client->getKeyPath());

        $content = '';
        $optionsArray = [
            'client',
            'dev tun',
            'proto ' . $client->protocol,
            'remote ' . $client->host . ' ' . $client->port,
            'resolv-retry infinite',
            'nobind',
            'auth-nocache',
            'persist-key',
            'persist-tun',
            'auth-user-pass',
            'verb 3',
            'route-delay 5 30',
            'tap-sleep 5',
            'script-security 2',
            'auth MD5',
            '<ca>',
            $ca.'</ca>',
            '<cert>',
            $cert.'</cert>',
            '<key>',
            $key.'</key>',
        ];
        foreach ($optionsArray as $option) {
            $content .= $option."\r\n";
        }
        $headers = [
            'Content-type' => 'text/plain',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $fileName),
//            'Content-Length' => sizeof($content)
        ];

        return Response::make($content, 200, $headers);
    }
}
