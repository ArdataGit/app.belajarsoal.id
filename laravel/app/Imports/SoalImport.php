<?php



namespace App\Imports;



use App\Models\MasterSoal;

use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\User;

use Maatwebsite\Excel\Concerns\WithStartRow;

use Maatwebsite\Excel\Validators\Failure;

use Maatwebsite\Excel\Concerns\Importable;

use Maatwebsite\Excel\Concerns\SkipsOnError;

use Auth;

use Carbon\Carbon;



class SoalImport implements ToModel ,WithStartRow, SkipsOnError

{

    /**

    * @param array $row

    *

    * @return \Illuminate\Database\Eloquent\Model|null

    */

    use Importable;



    private $data; 



    public function __construct(array $data = [])

    {

        $this->data = $data; 

    }



    public function model(array $row)
    {
        $fk_kategori_soal = $this->data['fk_kategori_soal'];
        // dd($row[4]);
        

            return new MasterSoal([

                'fk_kategori_soal'     => $fk_kategori_soal,

                'soal'     => $row[0],

                // 'tingkat'     => $row[1],

                'a'     => $row[1] ? $row[1] : '',

                'point_a'    => $row[2] ? $row[2] : 0, 

                'b'    => $row[3] ? $row[3] : '', 

                'point_b'    => $row[4] ? $row[4] : 0, 

                'c'    => $row[5] ? $row[5] : '', 

                'point_c'    => $row[6] ? $row[6] : 0, 

                'd'    => $row[7] ? $row[7] : '', 

                'point_d'    => $row[8] ? $row[8] : 0, 

                'e'    => $row[9] ? $row[9] : '', 

                'point_e'    => $row[10] ? $row[10] : 0, 

                'f'    => $row[11] ? $row[11] : '', 

                'point_f'    => $row[12] ? $row[12] : 0, 

                'g'    => $row[13] ? $row[13] : '', 

                'point_g'    => $row[14] ? $row[14] : 0, 

                'h'    => $row[15] ? $row[15] : '', 

                'point_h'    => $row[16] ? $row[16] : 0, 

                'jawaban'    => $row[17] ? strtolower($row[17]) : 'a', 

                'pembahasan'    => $row[18] ? $row[18] : '', 

                'created_by'    => Auth::id(), 

                'created_at'    => Carbon::now()->toDateTimeString(),

                'updated_by'    => Auth::id(), 

                'updated_at'    => Carbon::now()->toDateTimeString(),  

            ]);

        // }

    }

    public function startRow(): int

    {

        return 2;

    }



    public function onError(\Throwable $error)

    {
        //file_put_contents(__DIR__.'/test.txt', $error->getMessage());

        // Handle the exception how you'd like.

    }

}

