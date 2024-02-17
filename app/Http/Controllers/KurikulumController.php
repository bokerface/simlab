<?php

namespace App\Http\Controllers;

use App\Http\Requests\KurikulumMatakuliahSoftskillRequest;
use App\Http\Requests\KurikulumRequest;
use App\Http\Requests\KurikulumSoftskillRequest;
use App\Models\KurikulumMataKuliahSoftskill;
use App\Models\KurikulumSoftskill;
use App\Models\Softskill;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class KurikulumController extends Controller
{
    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $cur_year = date("Y");
        $daftar_kurikulum_softskill = DB::connection('sqlsrv')
            ->table("V_Kurikulum_Softskill")
            ->get()
            ->toArray();

        // dd($daftar_kurikulum_softskill);

        return view('/pages/admin/kurikulum/index', [
            'current_year' => $cur_year,
            'daftar_kurikulum_softskill' => $daftar_kurikulum_softskill
        ]);
    }

    public function kurikulum_praktikum_data()
    {
        $data = DB::connection('sqlsrv')
            ->table('V_Kurikulum')
            ->get()
            ->toArray();

        return json_encode($data);
    }

    public function kurikulum_softskill_data()
    {
        $data = DB::connection('sqlsrv')
            ->table('V_Kurikulum_Softskill')
            ->get()
            ->toArray();

        return json_encode($data);
    }

    public function kurikulum_tiap_tahun_ajaran()
    {
        $data = DB::table('V_Kurikulum_Angkatan')
            ->select('tahun', 'NAME_OF_CURRICULUM')
            ->leftJoin('V_Kurikulum_Softskill', 'V_Kurikulum_Softskill.KURIKULUM_ID', '=', 'V_Kurikulum_Angkatan.kurikulum')
            ->distinct()
            ->get()
            ->toArray();

        return json_encode($data);
    }

    public function store_kurikulum_tahun_ajaran_softskill(KurikulumSoftskillRequest $request)
    {
        $validated = $request->validated();

        $kurikulum_softskill = new KurikulumSoftskill();
        $kurikulum_softskill->kurikulum = $validated['KURIKULUM_ID'];
        $kurikulum_softskill->tahun = $validated['angkatan'];
        $kurikulum_softskill->save();

        return redirect()->back();

        // dd($request->validated());
    }

    public function buat_kurikulum()
    {
        $softskills = Softskill::all();
        foreach ($softskills as $softskill) {
            $data[] = [
                'nama' => $softskill->name_of_course,
                'id_praktikum' => $softskill->course_id,
            ];
        }
        // $view = (object)$data;
        // dd($this->paginate($data));
        // $data = $this->paginate($data);
        // $data->withPath(url('kurikulum/buat-kurikulum-baru/'));
        return view('pages/admin/kurikulum/buat-kurikulum', ['data' => $data]);
    }

    public function store_kurikulum(KurikulumRequest $request, KurikulumMatakuliahSoftskillRequest $matkul_request)
    {
        // dd($request->all());
        $validated_kurikulum = $request->validated();
        $validated_matkul = $matkul_request->validated();

        $id_kurikulum = "KUR-" . explode(' ', $validated_kurikulum['nama_kurikulum'])[1];

        $kurikulum_exist = KurikulumSoftskill::where('Kurikulum_ID', '=', $id_kurikulum)->first();

        if (empty($kurikulum_exist)) {
            $kurikulum_softskill = new KurikulumSoftskill();
            $kurikulum_softskill->KURIKULUM_ID = $id_kurikulum;
            $kurikulum_softskill->NAME_OF_CURRICULUM = $validated_kurikulum['nama_kurikulum'];
            if ($kurikulum_softskill->save()) {
                $matkul_kurikulum = new KurikulumMataKuliahSoftskill();

                foreach ($validated_matkul['id_praktikum'] as $key => $value) {
                    $data[] = [
                        'implemented_curriculum' => $id_kurikulum,
                        'course_id' => $value
                    ];
                }

                if ($matkul_kurikulum->insert($data)) {
                    return redirect()->to(url('kurikulum/buat-kurikulum-baru'))->with('success', ['type' => 'success', 'message' => 'Kurikulum Baru berhasil ditambahkan']);
                }
            }
        }

        return redirect()->back()->withErrors(['type' => 'danger', 'message' => 'Kurikulum Sudah Ada']);
    }

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
