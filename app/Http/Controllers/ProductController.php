<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\products;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * import
     *
     * @return void
     */
    public function import(Request $request)
    {
        try
        {
           $files = (new products)->import($request->file, null, \Maatwebsite\Excel\Excel::CSV);
            dd($files);
            if($request->file('csv')){
        $file = $request->file('csv')->store('public/import');
            }else{

                return back()->withErrors('No File Selected');
            }
        $import = new products;

        //$import->import($file);

        Excel::import($import, $request->file('csv'));

         return back()->withStatus('CSV file imported the rows are '.$import->getRowCount());
        }catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $failures = $e->failures();
     foreach ($failures as $failure) {
         $failure->row(); // row that went wrong
         $failure->attribute(); // either heading key (if using heading row concern) or column index
         $failure->errors(); // Actual error messages from Laravel validator
         $failure->values(); // The values of the row that has failed.

            foreach($failure->errors() as $fe){
            return back()->withErrors($failure->row().' '.$failure->attribute().' '.$fe.' errors are '.count($failure->row()));
            }
     }
        }catch(\Exception $err){
            foreach($err as $er){
            return back()->withErrors($er);
            }
        }
    }
    /**
     * export
     *
     * @return void
     */
    public function export(){

        return Excel::download(new ProductExport, 'product.xlsx');
    }
    /**
     * user_can_import_product testing
     *
     * @return void
     */
    public function user_can_import_product()
    {
        Excel::fake();

        $this->actingAs($this->givenUser())
             ->get('/products/import/xlsx');

        Excel::assertImported('filename.xlsx', 'diskName');

        Excel::assertImported('filename.xlsx', 'diskName', function(products $import) {
            return true;
        });

        // When passing the callback as 2nd param, the disk will be the default disk.
        Excel::assertImported('filename.xlsx', function(products $import) {
            return true;
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::all();
        return view('import')->with(compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }
}
