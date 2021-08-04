<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

use App\Divisi;
use App\Countries;
use App\Currencies;
use App\Perusahaan;
use App\Unit;
use App\Quotation;
use App\Customer;
use App\Style;
use App\Brand;
use App\StyleSample;
use App\Color;
use App\Fabricconst;
use App\Fabriccomp;
use App\Sizes;
use App\Mcp;
use Intervention\Image\Size;

class AutocompleteController extends Controller
{
    function divisi(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Divisi::where(DB::raw('upper(nama_divisi)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
					<li hidden id="kd_dvsi' . $no . '"><a href="#" class="dropdown-item" onclick="pilihDivisi(' . $no . ');">' . strtoupper($row->id) . '</a></li>
					<li id="dvsi' . $no . '"><a href="#" class="dropdown-item" onclick="pilihDivisi(' . $no . ');">' . strtoupper($row->nama_divisi) . '</a></li>
					';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function country(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Countries::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
					<li hidden id="code' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCountry(' . $no . ');">' . strtoupper($row->kode) . '</a></li>
					<li id="name' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCountry(' . $no . ');">' . strtoupper($row->name) . '</a></li>
					';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function currency(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Currencies::where(DB::raw('upper(nama)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
					<li hidden id="code' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCurrency(' . $no . ');">' . strtoupper($row->code) . '</a></li>
					<li id="nama' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCurrency(' . $no . ');">' . strtoupper($row->nama) . '</a></li>
					';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function perusahaan(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Perusahaan::where(DB::raw('upper(nama_perusahaan)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
					<li hidden id="kd_per' . $no . '"><a href="#" class="dropdown-item" onclick="pilihPer(' . $no . ');">' . strtoupper($row->kd_perusahaan) . '</a></li>
					<li id="per' . $no . '"><a href="#" class="dropdown-item" onclick="pilihPer(' . $no . ');">' . strtoupper($row->nama_perusahaan) . '</a></li>
					';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function satuan(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Unit::where(DB::raw('upper(code)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
					<li id="stn' . $no . '"><a href="#" class="dropdown-item" onclick="pilihSatuan(' . $no . ');">' . strtoupper($row->code) . '</a></li>';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function quotation(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Quotation::where(DB::raw('upper(code)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="code_quo' . $no . '"><a href="#" class="dropdown-item" onclick="pilihQuotation(' . $no . ');">' . strtoupper($row->code) . '</a></li>
        			<li id="quo' . $no . '"><a href="#" class="dropdown-item" onclick="pilihQuotation(' . $no . ');">' . strtoupper($row->code) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function mcp(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Mcp::where(DB::raw('upper(number)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
                    <li hidden id="number_mcp' . $no . '"><a href="#" class="dropdown-item" onclick="pilihMcp(' . $no . ');">' . strtoupper($row->number) . '</a></li>
                    <li id="mcp' . $no . '"><a href="#" class="dropdown-item" onclick="pilihMcp(' . $no . ');">' . strtoupper($row->number) . '</a></li>
                    ';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function customer(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Customer::where(DB::raw('upper(nama)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="code_cust' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCustomer(' . $no . ');">' . strtoupper($row->code) . '</a></li>
        			<li id="cust' . $no . '"><a href="#" class="dropdown-item" onclick="pilihCustomer(' . $no . ');">' . strtoupper($row->nama) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function style(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Style::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_sty' . $no . '"><a href="#" class="dropdown-item" onclick="pilihStyle(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="sty' . $no . '"><a href="#" class="dropdown-item" onclick="pilihStyle(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function brand(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Brand::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_br' . $no . '"><a href="#" class="dropdown-item" onclick="pilihBrand(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="br' . $no . '"><a href="#" class="dropdown-item" onclick="pilihBrand(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function sample_type(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = StyleSample::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_smpt' . $no . '"><a href="#" class="dropdown-item" onclick="pilihSample_type(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="smpt' . $no . '"><a href="#" class="dropdown-item" onclick="pilihSample_type(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function garment_type(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = StyleSample::where(DB::raw('upper(tipe)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_gar_type' . $no . '"><a href="#" class="dropdown-item" onclick="pilihGarmentType(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="gar_type' . $no . '"><a href="#" class="dropdown-item" onclick="pilihGarmentType(' . $no . ');">' . strtoupper($row->tipe) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function color(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Color::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="code_col' . $no . '"><a href="#" class="dropdown-item" onclick="pilihColor(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="col' . $no . '"><a href="#" class="dropdown-item" onclick="pilihColor(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function color_form(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Color::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="code_col' . $no . '"><a href="#" class="dropdown-item" onclick="pilihColor_form(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="col' . $no . '"><a href="#" class="dropdown-item" onclick="pilihColor_form(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function size(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Sizes::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="code_siz' . $no . '"><a href="#" class="dropdown-item" onclick="pilihSize(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="siz' . $no . '"><a href="#" class="dropdown-item" onclick="pilihSize(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function fabricconst(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabricconst::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabricconstruct(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabricconstruct(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function fabriccomp(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabriccomp::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->where('fabricconstruct_id', $request->get('id_fabricconst'))
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabriccompost(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabriccompost(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function fabricconst_edit(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabricconst::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_fabricconst_edit' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabricconstructedit(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="fabricconst_edit' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabricconstructedit(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function fabriccomp_edit(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabriccomp::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->where('fabricconstruct_id', $request->get('id_fabricconst_edit'))
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="id_fabriccomp_edit' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabriccompostedit(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="fabriccomp_edit' . $no . '"><a href="#" class="dropdown-item" onclick="pilihFabriccompostedit(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function d_fabricconst(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabricconst::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="d_id_fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="d_pilihFabricconstruct(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="d_fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="d_pilihFabricconstruct(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function d_fabriccomp(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabriccomp::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->where('fabricconstruct_id', $request->get('d_id_fabricconst'))
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="d_id_fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="d_pilihFabriccompost(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="d_fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="d_pilihFabriccompost(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function ed_fabricconst(Request $request)
    {
        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabricconst::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="ed_id_fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="ed_pilihFabricconstruct(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="ed_fabricconst' . $no . '"><a href="#" class="dropdown-item" onclick="ed_pilihFabricconstruct(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }

    function ed_fabriccomp(Request $request)
    {

        if ($request->get('query')) {
            $query = strtoupper($request->get('query'));
            $data = Fabriccomp::where(DB::raw('upper(name)'), 'LIKE', "%{$query}%")
                ->where('fabricconstruct_id', $request->get('ed_id_fabricconst'))
                ->get();
            if (count($data) > 0) {

                $no = 0;
                $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
                foreach ($data as $row) {
                    $no++;
                    $output .= '
        			<li hidden id="ed_id_fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="ed_pilihFabriccompost(' . $no . ');">' . strtoupper($row->id) . '</a></li>
        			<li id="ed_fabriccomp' . $no . '"><a href="#" class="dropdown-item" onclick="ed_pilihFabriccompost(' . $no . ');">' . strtoupper($row->name) . '</a></li>
        			';
                }
                $output .= '</ul>';
            } else {
                $output = '';
            }
            echo $output;
        }
    }
}
