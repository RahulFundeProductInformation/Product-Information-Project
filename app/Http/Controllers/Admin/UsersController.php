<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\DB;
use Auth;

class UsersController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->leftJoin('genders', 'genders.id', '=', 'products.gender_id')
            ->leftJoin('productsize', 'productsize.prod_id', '=', 'products.item_number')
            ->select('products.*', 'genders.gender','productsize.*')
            ->where('products.created_by',Auth::user()->id)
            ->get();
        return view('admin.users.index', compact('products'));
    }

    public function create()
    {
        return view('admin.users.importXml');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'xmlfile'        => 'required',
        ]);
        $xmlString = file_get_contents($_FILES["xmlfile"]["tmp_name"]);
        $xmlObject = simplexml_load_string($xmlString);
                   
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true); 
        foreach ($phpArray as $key => $value) {
            foreach ($value['catalog_item'] as $catkey => $catValue) {
                $gender = $catValue['@attributes']['gender'];
                $existGeneder = DB::table('genders')->select('id')->where('gender', $gender)->get();
                $gender_id = isset($existGeneder[0]->id) ? $existGeneder[0]->id :"";
                if (empty($existGeneder[0]->id))
                {
                   $gender_id = DB::table('genders')->insertGetId([
                        'gender' => $gender,
                        'created_at' => date('Y-m-d H:i:s'),
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }
                foreach($catValue['item_number'] as $itmkey => $itmvalue) {
                    $prod_name = $itmvalue['@attributes']['name'];
                    $price = $itmvalue['price'];
                    $existProd = DB::table('products')->select('id')->where('item_number', $prod_name)->get();
                        $prod_id = isset($existProd[0]->id) ? $existProd[0]->id :"";
                        if (empty($existProd[0]->id))
                        {
                           $prod_id = DB::table('products')->insertGetId([
                                'item_number' => $prod_name,
                                'gender_id' => $gender_id,
                                'price' => $price,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id,
                                'status' => 1
                            ]);
                        }

                    foreach($itmvalue['size'] as $sizekey => $sizevalue) {
                            $sizeDescription = $sizevalue['@attributes']['description'];
                            foreach ($sizevalue['color'] as $key => $colorvalue) {
                                if(DB::table('productsize')->select('id')
                                ->where('prod_id', $prod_name)
                                ->where('name', $sizeDescription)
                                ->where('color', $colorvalue)->doesntExist())
                                {
                                   $prod_id = DB::table('productsize')->insertGetId([
                                        'prod_id' => $prod_name,
                                        'name' => $sizeDescription,
                                        'color' => $colorvalue,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'created_by' => Auth::user()->id,
                                        'status' => 1
                                    ]);
                                }
                            }
                    }
                }
            }
        }

            $alert_toast = 
            [
                'title' => 'Operation Successful : ',
                'text'  => 'Products Successfully Added.',
                'type'  => 'success',
            ];
            
        Session::flash('alert_toast', $alert_toast);
        return redirect()->route('admin.users.index');
    }

    public function edit($id)
    {
        $prodInfo = DB::table('products')->select('item_number','price')->where('item_number', $id)->get();
        $item_number = isset($prodInfo[0]->item_number) ? $prodInfo[0]->item_number :"";
        // print_r($prodInfo);
        if($item_number!=""){
            return view('admin.users.edit', compact('prodInfo'));
        }else{
            $alert_toast = 
            [
                'title' => 'Operation failed : ',
                'text'  => 'Products not found.',
                'type'  => 'failed',
            ];
        Session::flash('alert_toast', $alert_toast);
        return view('admin.users.edit');
        }

    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'price'           => "required|regex:/^\d+(\.\d{1,2})?$/",
        ]);

        $affected = DB::table('products')
              ->where('item_number', $id)
              ->update(['price' => $request->price]);

        if($affected)
        {
            $alert_toast = 
            [
                'title' => 'Operation Successful : ',
                'text'  => 'Product Successfully Updated.',
                'type'  => 'success',
            ];
        }
        else
        {
            $alert_toast =  
            [
                'title' => 'Operation Failed : ',
                'text'  => 'A Problem Update The Product.',
                'type'  => 'danger',
            ];
        }

        Session::flash('alert_toast', $alert_toast);
        return redirect()->route('admin.users.index');
    }

    public function delete(Request $request)
    {
        $isDeleted = DB::table('products')->where('item_number', '=', $request->id)->delete();
        if($isDeleted)
        {
            DB::table('productsize')->where('prod_id', '=', $request->id)->delete();
            $alert_toast = 
            [
                'title' =>  'Operation Successful : ',
                'text'  =>  'Product Successfully Deleted.',
                'type'  =>  'success',
            ];
        }
        else
        {
            $alert_toast = 
            [
                'title' => 'Operation Failed : ',
                'text'  => 'A Problem Deleting The Product.',
                'type'  => 'danger',
            ];
        }

        Session::flash('alert_toast', $alert_toast);
        return redirect()->route('admin.users.index');
    }

 
}
