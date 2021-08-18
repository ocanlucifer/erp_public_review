<?php

namespace App\Imports;

use Illuminate\Http\Request;
use App\Quotation;
use App\QuotationDetail;
use App\QuotationImage;
use Auth;
use File;
use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;

use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use \PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class QuotationImport implements WithMappedCells, WithMultipleSheets, SkipsUnknownSheets, ToModel, WithCalculatedFormulas
{
    use WithConditionalSheets;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

//     public function Sheets(): array
//     {

//         $sheet = [];
//         $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('/temp_excel/temp_.xlsm'));
// //x = 2;
//         for ($i = 2; $i <= $spreadsheet->getSheetCount() -1; $i++) {
            
//             // $sh = $spreadsheet->getSheet($i);
//             // $sh->getCell('I3')->setValue($i);
//             // $writer = new Xlsx($spreadsheet);
//             // $writer->save('temp_.xlsm');

//             $sheet[$i] = new QuotationImport();
//         }

        
//         return $sheet;
//     }
    private $fileExcel = null;
    private $currentSheet = null;

    public function __construct(int $IndexSheet,$file) 
    {
        $this->currentSheet     = $IndexSheet;
        $this->fileExcel        = $file;
    }

    public function conditionalSheets(): array
    {
        $sheet                      = [];
        $sheet[$this->currentSheet] = $this;
        return $sheet;
    }

    public function onUnknownSheet($sheetName)
    {
        // E.g. you can log that a sheet was not found.
        info("Sheet {$sheetName} was skipped");
    }

    public function mapping(): array
    {
        //$this->currentSheet++;
        $quot  = [
                'cust'          => 'B4',
                'brand'         => 'B5',
                'season'        => 'B6',
                'style'         => 'B7',
                'description'   => 'B8',
                'bu'            => 'B9',

                'forecast_qty'  => 'E4',
                'size_range'    => 'E5',
                'delivery'      => 'E6',
                'destination'   => 'E7',
                'tgl_quot'      => 'E8',
                'exchange_rate' => 'E9',

                'smv'           => 'G9',
                'rate'          => 'I9',

                'total_cost'    => 'K215',
                'handling'      => 'J217',
                'margin'        => 'J221',
                'offer_price'   => 'K225',
                'sales_fee'     => 'J227',
                'confirm_price' => 'K231',
                'numSheet'      => 'I3',
                'total_fabric_value'      => 'K31',
                'totalcost_handling_margin'      => 'K223',
                'sales_fee_value'      => 'K227',
            ];
        //detail fabric
        $quot += ['f_loc_allowance'             => 'H13',
                            'f_loc_freight'     => 'J13',
                            'f_imp_allowance'   => 'H22',
                            'f_imp_freight'     => 'J22',
                ];

        $rf_loc = 14;
        for ($f_loc=1; $f_loc <= 7; $f_loc++) { 
            if ('G'.$rf_loc <> '') {
                $quot += ['f_loc_position'.$f_loc               => 'A'.$rf_loc,
                                    'f_loc_jenis_detail'.$f_loc => 'B'.$rf_loc,
                                    'f_loc_description'.$f_loc  => 'C'.$rf_loc,
                                    'f_loc_description_'.$f_loc => 'D'.$rf_loc,
                                    'f_loc_supplier'.$f_loc     => 'E'.$rf_loc,
                                    'f_loc_width'.$f_loc        => 'F'.$rf_loc,
                                    'f_loc_cons'.$f_loc         => 'G'.$rf_loc,
                                    'f_loc_price'.$f_loc        => 'I'.$rf_loc,
                        ];
            }
            $rf_loc = $rf_loc+1;
        }

        $rf_imp = 23;
        for ($f_imp=1; $f_imp <= 7; $f_imp++) { 
            if ('G'.$rf_imp <> '') {
                $quot += ['f_imp_position'.$f_imp               => 'A'.$rf_imp,
                                    'f_imp_jenis_detail'.$f_imp => 'B'.$rf_imp,
                                    'f_imp_description'.$f_imp  => 'C'.$rf_imp,
                                    'f_imp_description_'.$f_imp => 'D'.$rf_imp,
                                    'f_imp_supplier'.$f_imp     => 'E'.$rf_imp,
                                    'f_imp_width'.$f_imp        => 'F'.$rf_imp,
                                    'f_imp_cons'.$f_imp         => 'G'.$rf_imp,
                                    'f_imp_price'.$f_imp        => 'I'.$rf_imp,
                        ];
            }
            $rf_imp = $rf_imp+1;
        }
        //end detail fabric

        //detail special trims
        $quot += ['st_loc_allowance' => 'H34',
                            'st_loc_freight' => 'J34',
                            'st_imp_allowance' => 'H48',
                            'st_imp_freight' => 'J48',
                ];

        $rst_loc = 35;
        for ($st_loc=1; $st_loc <= 12; $st_loc++) { 
            if ('G'.$rst_loc <> '') {
                $quot += ['st_loc_position'.$st_loc                 => 'A'.$rst_loc,
                                    'st_loc_jenis_detail'.$st_loc   => 'B'.$rst_loc,
                                    'st_loc_description'.$st_loc    => 'C'.$rst_loc,
                                    'st_loc_description_'.$st_loc   => 'D'.$rst_loc,
                                    'st_loc_supplier'.$st_loc       => 'E'.$rst_loc,
                                    'st_loc_width'.$st_loc          => 'F'.$rst_loc,
                                    'st_loc_cons'.$st_loc           => 'G'.$rst_loc,
                                    'st_loc_price'.$st_loc          => 'I'.$rst_loc,
                        ];
            }
            $rst_loc = $rst_loc+1;
        }

        $rst_imp = 49;
        for ($st_imp=1; $st_imp <= 11; $st_imp++) { 
            if ('G'.$rst_imp <> '') {
                $quot += ['st_imp_position'.$st_imp                 => 'A'.$rst_imp,
                                    'st_imp_jenis_detail'.$st_imp   => 'B'.$rst_imp,
                                    'st_imp_description'.$st_imp    => 'C'.$rst_imp,
                                    'st_imp_description_'.$st_imp   => 'D'.$rst_imp,
                                    'st_imp_supplier'.$st_imp       => 'E'.$rst_imp,
                                    'st_imp_width'.$st_imp          => 'F'.$rst_imp,
                                    'st_imp_cons'.$st_imp           => 'G'.$rst_imp,
                                    'st_imp_price'.$st_imp          => 'I'.$rst_imp,
                        ];
            }
            $rst_imp = $rst_imp+1;
        }
        //end detail special trims

        //detail trims
        $quot += ['t_loc_allowance' => 'H64',
                            't_loc_freight' => 'J64',
                            't_imp_allowance' => 'H88',
                            't_imp_freight' => 'J88',
                ];

        $rt_loc = 65;
        for ($t_loc=1; $t_loc <= 22; $t_loc++) { 
            if ('G'.$rt_loc <> '') {
                $quot += ['t_loc_position'.$t_loc               => 'A'.$rt_loc,
                                    't_loc_jenis_detail'.$t_loc => 'B'.$rt_loc,
                                    't_loc_description'.$t_loc  => 'C'.$rt_loc,
                                    't_loc_description_'.$t_loc => 'D'.$rt_loc,
                                    't_loc_supplier'.$t_loc     => 'E'.$rt_loc,
                                    't_loc_width'.$t_loc        => 'F'.$rt_loc,
                                    't_loc_cons'.$t_loc         => 'G'.$rt_loc,
                                    't_loc_price'.$t_loc        => 'I'.$rt_loc,
                        ];
            }
            $rt_loc = $rt_loc+1;
        }

        $rt_imp = 89;
        for ($t_imp=1; $t_imp <= 22; $t_imp++) { 
            if ('G'.$rt_imp <> '') {
                $quot += ['t_imp_position'.$t_imp               => 'A'.$rt_imp,
                                    't_imp_jenis_detail'.$t_imp => 'B'.$rt_imp,
                                    't_imp_description'.$t_imp  => 'C'.$rt_imp,
                                    't_imp_description_'.$t_imp => 'D'.$rt_imp,
                                    't_imp_supplier'.$t_imp     => 'E'.$rt_imp,
                                    't_imp_width'.$t_imp        => 'F'.$rt_imp,
                                    't_imp_cons'.$t_imp         => 'G'.$rt_imp,
                                    't_imp_price'.$t_imp        => 'I'.$rt_imp,
                        ];
            }
            $rt_imp = $rt_imp+1;
        }
        //end detail trims

        //detail embellishment
        $quot += ['e_allowance' => 'H113','e_freight' => 'J113',];

        $re = 115;
        for ($e=1; $e <= 31; $e++) { 
            if ('G'.$re <> '') {
                $quot += ['e_position'.$e               => 'A'.$re,
                                    'e_jenis_detail'.$e => 'B'.$re,
                                    'e_description'.$e  => 'C'.$re,
                                    'e_description_'.$e => 'D'.$re,
                                    'e_supplier'.$e     => 'E'.$re,
                                    'e_width'.$e        => 'F'.$re,
                                    'e_cons'.$e         => 'G'.$re,
                                    'e_price'.$e        => 'I'.$re,
                        ];
            }
            $re = $re+1;
        }
        //end detail embellishment

        //detail washing
        $quot += ['w_allowance' => 'H147','w_freight' => 'J147',];

        $r_w = 149;
        for ($w=1; $w <= 31; $w++) { 
            if ('G'.$r_w <> '') {
                $quot += ['w_position'.$w               => 'A'.$r_w,
                                    'w_jenis_detail'.$w => 'B'.$r_w,
                                    'w_description'.$w  => 'C'.$r_w,
                                    'w_description_'.$w => 'D'.$r_w,
                                    'w_supplier'.$w     => 'E'.$r_w,
                                    'w_width'.$w        => 'F'.$r_w,
                                    'w_cons'.$w         => 'G'.$r_w,
                                    'w_price'.$w        => 'I'.$r_w,
                        ];
            }
            $r_w = $r_w+1;
        }
        //end detail washing

        //detail miscellaneous
        $quot += ['m_allowance' => 'H198','m_freight' => 'J198',];

        $r_m = 200;
        for ($m=1; $m <= 11; $m++) { 
            if ('G'.$r_m <> '') {
                $quot += ['m_position'.$m               => 'A'.$r_m,
                                    'm_jenis_detail'.$m => 'B'.$r_m,
                                    'm_description'.$m  => 'C'.$r_m,
                                    'm_description_'.$m => 'D'.$r_m,
                                    'm_supplier'.$m     => 'E'.$r_m,
                                    'm_width'.$m        => 'F'.$r_m,
                                    'm_cons'.$m         => 'G'.$r_m,
                                    'm_price'.$m        => 'I'.$r_m,
                        ];
            }
            $r_m = $r_m+1;
        }
        //end detail miscellaneous

        return $quot;
    }

    

    public function model(array $row)
    {
        $userid             = Auth::user()->id;
        if ($row['tgl_quot']=='') {
            $tgl = date(NOW());
        } else {
            $tgl                = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_quot']);
        }
        
        // $tgl                = $row['tgl_quot'];
        $handling           = $row['handling'] * 100;
        $margin             = $row['margin'] * 100;
        $sales_fee          = $row['sales_fee'] * 100;

        // Get the last order id
        $lastCode = Quotation::orderBy('code', 'desc')->first();

        // Get last 3 digits of last order code
        if (!$lastCode) {
         $lastNumber = 'Q' . date('Y') .'-'. str_pad(0, 5, 0, STR_PAD_LEFT);
        } else {
         $lastNumber = $lastCode['code'];
        }
        $lastIncreament = substr($lastNumber, -5);

        // Make a new order code with appending last increment + 1
        $newCode = 'Q' . date('Y') .'-'. str_pad($lastIncreament + 1, 5, 0, STR_PAD_LEFT);

        $header                = new Quotation;
        $header->code          = $newCode;
        $header->cust          = $row['cust'];
        $header->brand         = $row['brand'];
        $header->season        = $row['brand'];
        $header->style         = $row['style'];
        $header->description   = $row['description'];
        $header->bu            = $row['bu'];

        $header->forecast_qty  = $row['forecast_qty'];
        $header->size_range    = $row['size_range'];
        $header->delivery      = $row['delivery'];
        $header->destination   = $row['destination'];
        $header->tgl_quot      = $tgl;
        $header->exchange_rate = $row['exchange_rate'];

        $header->smv           = $row['smv'];
        $header->rate          = $row['rate'];
        $header->total_cost    = $row['total_cost'];

        $header->basis_order   = '';
        $header->status        = 'pending';

        $header->handling      = $handling;
        $header->margin        = $margin;
        $header->sales_fee_value   = $row['sales_fee_value'];
        $header->totalcost_handling_margin   = $row['totalcost_handling_margin'];
        $header->total_fabric_value   = $row['total_fabric_value'];
        $header->offer_price   = $row['offer_price'];
        $header->sales_fee     = $sales_fee;
        $header->confirm_price = $row['confirm_price'];
        $header->create_by     = $userid;
        $header->save();

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path($this->fileExcel));
        $s = $this->currentSheet;
        $x=0;
        foreach ($spreadsheet->getSheet($s)->getDrawingCollection() as $drawing) {
            if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\Drawing) {
                $x++;
                $nama_user  = strtoupper(Auth::user()->name);
                $file_name = time().'_'.$nama_user.'_Sheet('.$s.')_Picture('.$x.').'.$drawing->getExtension();
                $tahun      = date('Y');
                $bulan      = date('m');

                $folder_upload  = strtoupper('storage/QUOTATION_SKETCH/'.$tahun.'/'.$bulan);
                $myFileName = $file_name;
                if(!File::exists($folder_upload)) {
                    File::makeDirectory($folder_upload, $mode = 0777, true, true);
                    file_put_contents($folder_upload.'/'.$myFileName,file_get_contents($drawing->getPath()));
                } else {
                    file_put_contents($folder_upload.'/'.$myFileName,file_get_contents($drawing->getPath()));
                }

            $gambar                 = new QuotationImage;
            $gambar->id_quot_header = $newCode;
            $gambar->file           = $folder_upload.'/'.$myFileName;
            $gambar->save();
            } 
        }

        //detail fabric
        $f_loc_allowance    = $row['f_loc_allowance'] * 100;
        $f_loc_freight      = $row['f_loc_freight'] * 100;
        $f_imp_allowance    = $row['f_imp_allowance'] * 100;
        $f_imp_freight      = $row['f_imp_freight'] * 100;

        for ($f_loc=1; $f_loc <= 7; $f_loc++) { 
            if ($row['f_loc_cons'.$f_loc] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'FABRIC';
                $detail->position           = $row['f_loc_position'.$f_loc];
                $detail->jenis_detail       = $row['f_loc_jenis_detail'.$f_loc];
                $detail->description        = $row['f_loc_description'.$f_loc].' '.$row['f_loc_description_'.$f_loc];
                $detail->supplier           = $row['f_loc_supplier'.$f_loc];
                $detail->width              = $row['f_loc_width'.$f_loc];
                $detail->cons               = $row['f_loc_cons'.$f_loc];
                $detail->allowance          = $f_loc_allowance;
                $detail->price              = $row['f_loc_price'.$f_loc];
                $detail->freight            = $f_loc_freight;
                $detail->save();
            }
        }

        for ($f_imp=1; $f_imp <= 7; $f_imp++) { 
            if ($row['f_imp_cons'.$f_imp] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'FABRIC';
                $detail->position           = $row['f_imp_position'.$f_imp];
                $detail->jenis_detail       = $row['f_imp_jenis_detail'.$f_imp];
                $detail->description        = $row['f_imp_description'.$f_imp].' '.$row['f_imp_description_'.$f_imp];
                $detail->supplier           = $row['f_imp_supplier'.$f_imp];
                $detail->width              = $row['f_imp_width'.$f_imp];
                $detail->cons               = $row['f_imp_cons'.$f_imp];
                $detail->allowance          = $f_imp_allowance;
                $detail->price              = $row['f_imp_price'.$f_imp];
                $detail->freight            = $f_imp_freight;
                $detail->save();
            }
        }
        //end detail fabric

        //detail special trims
        $st_loc_allowance    = $row['st_loc_allowance'] * 100;
        $st_loc_freight      = $row['st_loc_freight'] * 100;
        $st_imp_allowance    = $row['st_imp_allowance'] * 100;
        $st_imp_freight      = $row['st_imp_freight'] * 100;

        for ($st_loc=1; $st_loc <= 12; $st_loc++) { 
            if ($row['st_loc_cons'.$st_loc] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'SPECIAL TRIMS';
                $detail->position           = $row['st_loc_position'.$st_loc];
                $detail->jenis_detail       = $row['st_loc_jenis_detail'.$st_loc];
                $detail->description        = $row['st_loc_description'.$st_loc].' '.$row['st_loc_description_'.$st_loc];
                $detail->supplier           = $row['st_loc_supplier'.$st_loc].' '.$row['st_loc_width'.$st_loc];
                $detail->cons               = $row['st_loc_cons'.$st_loc];
                $detail->allowance          = $st_loc_allowance;
                $detail->price              = $row['st_loc_price'.$st_loc];
                $detail->freight            = $st_loc_freight;
                $detail->save();
            }
        }

        for ($st_imp=1; $st_imp <= 11; $st_imp++) { 
            if ($row['st_imp_cons'.$st_imp] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'SPECIAL TRIMS';
                $detail->position           = $row['st_imp_position'.$st_imp];
                $detail->jenis_detail       = $row['st_imp_jenis_detail'.$st_imp];
                $detail->description        = $row['st_imp_description'.$st_imp].' '.$row['st_imp_description_'.$st_imp];
                $detail->supplier           = $row['st_imp_supplier'.$st_imp].' '.$row['st_imp_width'.$st_imp];
                $detail->cons               = $row['st_imp_cons'.$st_imp];
                $detail->allowance          = $st_imp_allowance;
                $detail->price              = $row['st_imp_price'.$st_imp];
                $detail->freight            = $st_imp_freight;
                $detail->save();
            }
        }
        //end detail special trims

        //detail trims
        $t_loc_allowance    = $row['t_loc_allowance'] * 100;
        $t_loc_freight      = $row['t_loc_freight'] * 100;
        $t_imp_allowance    = $row['t_imp_allowance'] * 100;
        $t_imp_freight      = $row['t_imp_freight'] * 100;

        for ($t_loc=1; $t_loc <= 22; $t_loc++) { 
            if ($row['t_loc_cons'.$t_loc] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'TRIMS';
                $detail->position           = $row['t_loc_position'.$t_loc];
                $detail->jenis_detail       = $row['t_loc_jenis_detail'.$t_loc];
                $detail->description        = $row['t_loc_description'.$t_loc].' '.$row['t_loc_description_'.$t_loc];
                $detail->supplier           = $row['t_loc_supplier'.$t_loc].' '.$row['t_loc_width'.$t_loc];
                $detail->cons               = $row['t_loc_cons'.$t_loc];
                $detail->allowance          = $t_loc_allowance;
                $detail->price              = $row['t_loc_price'.$t_loc];
                $detail->freight            = $t_loc_freight;
                $detail->save();
            }
        }

        for ($t_imp=1; $t_imp <= 22; $t_imp++) { 
            if ($row['t_imp_cons'.$t_imp] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'TRIMS';
                $detail->position           = $row['t_imp_position'.$t_imp];
                $detail->jenis_detail       = $row['t_imp_jenis_detail'.$t_imp];
                $detail->description        = $row['t_imp_description'.$t_imp].' '.$row['t_imp_description_'.$t_imp];
                $detail->supplier           = $row['t_imp_supplier'.$t_imp].' '.$row['t_imp_width'.$st_imp];
                $detail->cons               = $row['t_imp_cons'.$t_imp];
                $detail->allowance          = $t_imp_allowance;
                $detail->price              = $row['t_imp_price'.$t_imp];
                $detail->freight            = $t_imp_freight;
                $detail->save();
            }
        }
        //end detail trims

        //detail embellishment
        $e_allowance    = $row['e_allowance'] * 100;
        $e_freight      = $row['e_freight'] * 100;

        for ($e=1; $e <= 31; $e++) { 
            if ($row['e_cons'.$e] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'EMBELLISHMENT';
                $detail->position           = $row['e_position'.$e];
                $detail->jenis_detail       = $row['e_jenis_detail'.$e];
                $detail->description        = $row['e_description'.$e].' '.$row['e_description_'.$e];
                $detail->supplier           = $row['e_supplier'.$e].' '.$row['e_width'.$e];
                $detail->cons               = $row['e_cons'.$e];
                $detail->allowance          = $e_allowance;
                $detail->price              = $row['e_price'.$e];
                $detail->freight            = $e_freight;
                $detail->save();
            }
        }
        //end detail embellishment

        //detail washing
        $w_allowance    = $row['w_allowance'] * 100;
        $w_freight      = $row['w_freight'] * 100;

        for ($w=1; $w <= 31; $w++) { 
            if ($row['w_cons'.$w] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'WASHING';
                $detail->position           = $row['w_position'.$w];
                $detail->jenis_detail       = $row['w_jenis_detail'.$w];
                $detail->description        = $row['w_description'.$w].' '.$row['w_description_'.$w];
                $detail->supplier           = $row['w_supplier'.$w].' '.$row['w_width'.$w];
                $detail->cons               = $row['w_cons'.$w];
                $detail->allowance          = $w_allowance;
                $detail->price              = $row['w_price'.$w];
                $detail->freight            = $w_freight;
                $detail->save();
            }
        }
        //end detail washing

        //detail miscellaneous
        $m_allowance    = $row['m_allowance'] * 100;
        $m_freight      = $row['m_freight'] * 100;

        for ($m=1; $m <= 11; $m++) { 
            if ($row['m_cons'.$m] <> '') {
                $detail                     = new QuotationDetail;
                $detail->id_quot_header     = $newCode;
                $detail->jenis              = 'MISCELLANEOUS';
                $detail->position           = $row['m_position'.$m];
                $detail->jenis_detail       = $row['m_jenis_detail'.$m];
                $detail->description        = $row['m_description'.$m].' '.$row['m_description_'.$m];
                $detail->supplier           = $row['m_supplier'.$m].' '.$row['m_width'.$m];
                $detail->cons               = $row['m_cons'.$m];
                $detail->allowance          = $m_allowance;
                $detail->price              = $row['m_price'.$m];
                $detail->freight            = $m_freight;
                $detail->save();
            }
        }
        
        //end detail miscellaneous
        return $header;
    }
}

