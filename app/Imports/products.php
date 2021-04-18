<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use App\Models\product;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class products implements ToCollection
{
    use Importable,SkipsFailures;
    private $rows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    // public function model(array $row)
    // {
    //     return new product([
    //         'sku' => $row[0],
    //         'description' => $row[1],
    //         'normal_price' => $row[2],
    //         'special_price' => $row[3]
    //     ]);
    // }
    public function withValidation()
    {
    }
    /**
     * collection
     */
    public function collection(Collection $collection)
    {

    Validator::make($collection->toArray(),
    [
    //'*.0' => 'required|unique',
    '*.1' => 'required|string|min:5',
    '*.2' => 'required|numeric|min:1',
    '*.3' => 'numeric|min:1'
    ]
    )->validate();

       foreach ($collection as $datarow) {
        if($datarow[3] > $datarow[2]){
           return back()->withErrors('Special price should be less than normal price');
        }else{

            ++$this->rows;
           $model = product::create([
               // 'sku' => strip_tags($datarow[0]),
                'description' => strip_tags($datarow[1]),
                'normal_price' => $datarow[2],
                'special_price' => $datarow[3]
            ]);
           }
    }
    return $model;
    }

/**
     * headings
     */
    public function withHeadingRow(){

    }



    public function getRowCount(): int
    {
        return $this->rows;
    }
    public function onFailure(Failure ...$failures)
{
    // Handle the failures how you'd like.
}
}
