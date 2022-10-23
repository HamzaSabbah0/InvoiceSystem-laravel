<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
// use PDF;
// use sBarryvdh\DomPDF\PDF;



class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $invoices = Invoice::orderBy('id', 'desc')->paginate(10);

        return view('frontend.index', compact('invoices'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('frontend.create');
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

        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_mobile'] = $request->customer_mobile;
        $data['company_name'] = $request->company_name;
        $data['invoice_number'] = $request->invoice_number;
        $data['invoice_date'] = $request->invoice_date;
        $data['sub_total'] = $request->sub_total;
        $data['discount_type'] = $request->discount_type;
        $data['discount_value'] = $request->discount_value;
        $data['vat_value'] = $request->vat_value;
        $data['shipping'] = $request->shipping;
        $data['total_due'] = $request->total_due;

        $invoice = Invoice::create($data);

        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);

        if ($details) {
            return redirect()->route('invoices.index')->with([
                'message' => __('Frontend/frontend.created_successfully'),
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => __('Frontend/frontend.created_failed'),
                'alert-type' => 'danger'
            ]);
        }

        // $invoice = new Invoice();
        // $invoice->customer_name = $request->get('customer_name');
        // $invoice->customer_email = $request->get('customer_email');
        // $invoice->customer_mobile = $request->get('customer_mobile');
        // $invoice->company_name = $request->get('company_name');
        // $invoice->invoice_number = $request->get('invoice_number');
        // $invoice->invoice_date = $request->get('invoice_date');
        // $invoice->sub_total = $request->get('sub_total');
        // $invoice->discount_type = $request->get('discount_type');
        // $invoice->discount_value = $request->get('discount_value');
        // $invoice->vat_value = $request->get('vat_value');
        // $invoice->shipping = $request->get('shipping');
        // $invoice->total_due = $request->get('total_due');

        // $details_list =[];

        // for ($i=0; $i < count($request->product_name); $i++) {
        //     $details_list[$i]['porduct_name'] = $request->product_name[$i];
        //     $details_list[$i]['unit'] = $request->unit[$i];
        //     $details_list[$i]['quantity'] = $request->quantity[$i];
        //     $details_list[$i]['unit_price'] = $request->unit_price[$i];
        //     $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        // }
        // // dd($request->all());

        // $isSaved = $invoice->save();
        // if($isSaved){
        //     session()->flash('message','Invoice Created Successfully');
        //     return redirect()->back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        return view('frontend.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $invoice = Invoice::findOrFail($id);
        return view('frontend.edit', compact('invoice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
         $invoice = Invoice::whereId($id)->first();

        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_mobile'] = $request->customer_mobile;
        $data['company_name'] = $request->company_name;
        $data['invoice_number'] = $request->invoice_number;
        $data['invoice_date'] = $request->invoice_date;
        $data['sub_total'] = $request->sub_total;
        $data['discount_type'] = $request->discount_type;
        $data['discount_value'] = $request->discount_value;
        $data['vat_value'] = $request->vat_value;
        $data['shipping'] = $request->shipping;
        $data['total_due'] = $request->total_due;

        $invoice->update($data);

        $invoice->details()->delete();


        $details_list = [];
        for ($i = 0; $i < count($request->product_name); $i++) {
            $details_list[$i]['product_name'] = $request->product_name[$i];
            $details_list[$i]['unit'] = $request->unit[$i];
            $details_list[$i]['quantity'] = $request->quantity[$i];
            $details_list[$i]['unit_price'] = $request->unit_price[$i];
            $details_list[$i]['row_sub_total'] = $request->row_sub_total[$i];
        }

        $details = $invoice->details()->createMany($details_list);

        if ($details) {
            return redirect()->back()->with([
                'message' => __('Frontend/frontend.updated_successfully'),
                'alert-type' => 'success'
            ]);
        } else {
            return redirect()->back()->with([
                'message' => __('Frontend/frontend.updated_failed'),
                'alert-type' => 'danger'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
        $isDeleted = $invoice->delete();
        if($isDeleted){
            return response()->json(['title'=>__('Frontend/frontend.s_message_delete_title'),
            'text'=>__('Frontend/frontend.s_message_delete_text'),'icon'=>'success'
            ],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>__('Frontend/frontend.f_message_delete_title'),
            'text'=>__('Frontend/frontend.f_message_delete_text'),'icon'=>'error'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('frontend.print', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::whereId($id)->first();

        $data['invoice_id']         = $invoice->id;
        $data['invoice_date']       = $invoice->invoice_date;
        $data['customer']           = [
            __('Frontend/frontend.customer_name')       => $invoice->customer_name,
            __('Frontend/frontend.customer_mobile')     => $invoice->customer_mobile,
            __('Frontend/frontend.customer_email')      => $invoice->customer_email
        ];
        $items = [];
        $invoice_details            =  $invoice->details()->get();
        foreach ($invoice_details as $item) {
            $items[] = [
                'product_name'      => $item->product_name,
                'unit'              => $item->unitText(),
                'quantity'          => $item->quantity,
                'unit_price'        => $item->unit_price,
                'row_sub_total'     => $item->row_sub_total,
            ];
        }
        $data['items'] = $items;

        $data['invoice_number']     = $invoice->invoice_number;
        $data['created_at']         = $invoice->created_at->format('Y-m-d');
        $data['sub_total']          = $invoice->sub_total;
        $data['discount']           = $invoice->discountResult();
        $data['vat_value']          = $invoice->vat_value;
        $data['shipping']           = $invoice->shipping;
        $data['total_due']          = $invoice->total_due;


        $pdf = PDF::loadView('frontend.pdf', $data);

        if (Route::currentRouteName() == 'invoice.pdf') {
            return $pdf->stream($invoice->invoice_number.'.pdf');
        } else {
            $pdf->save(public_path('assets/invoices/').$invoice->invoice_number.'.pdf');
            return $invoice->invoice_number.'.pdf';
        }

    }
}
