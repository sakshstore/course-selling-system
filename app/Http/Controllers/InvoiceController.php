<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Contact;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        return Invoice::with(['products', 'contact'])->get();
    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::with(['products', 'contact'])->findOrFail($id);
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }

    public function store(Request $request)
    {


        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'invoice_number' => 'required|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'customer_note' => 'nullable|string',
            'terms' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.description' => 'nullable|string',
            'status' => 'required|string|in:draft,sent,viewed,paid,partially_paid,overdue,cancelled'
        ]);


        $contact = Contact::findOrFail($request->contact_id);
        if ($contact->status === 'lead') {
            $contact->status = 'customer';
            $contact->save();
        }



        $invoiceData = $request->only([
            'invoice_number',
            'order_number',
            'invoice_date',
            'due_date',
            'customer_note',
            'terms',
            'status'
        ]);
        $invoiceData['contact_id'] = $contact->id;
        $invoiceData['user_id'] = auth()->id(); // Add the logged-in user ID





        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('invoices');
            $invoiceData['file_path'] = $path;
        }


        $invoice = Invoice::create($invoiceData);

        foreach ($request->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'description' => $product['description'],
                'price' => $product['price'] // Include the price field
            ]);
        }

        return response()->json($invoice->load(['products', 'contact']), 201);
    }

    public function show($id)
    {
        $invoice = Invoice::with(['products', 'contact'])->findOrFail($id);
        $companyDetails = [
            'logo' => 'path/to/logo.png',
            'name' => 'Sakshamapp International Private Limited',
            'address' => 'L 601, Keshav Puram<br/>Kalyan Pur<br/>Kanpur Uttar Pradesh 208017<br/>India',

        ];

        return response()->json([
            'invoice' => $invoice,
            'companyDetails' => $companyDetails
        ]);
    }

    public function updateCustomerNoteAndTerms(Request $request, $id)
    {
        $request->validate([
            'customer_note' => 'nullable|string',
            'terms' => 'nullable|string'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->only(['customer_note', 'terms']));

        return response()->json(['message' => 'Customer note and terms updated successfully!']);
    }

    public function updateInvoiceDetails(Request $request, $id)
    {
        $request->validate([
            'contact_id' => 'required|exists:contacts,id',
            'invoice_number' => 'required|string|max:255',
            'order_number' => 'nullable|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'status' => 'required|string|in:draft,sent,viewed,paid,partially_paid,overdue,cancelled'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->only([
            'contact_id',
            'invoice_number',
            'order_number',
            'invoice_date',
            'due_date',
            'status'
        ]));

        return response()->json(['message' => 'Invoice details updated successfully!']);
    }

    public function updateInvoiceDatesAndTerms(Request $request, $id)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'terms' => 'nullable|string',
            'due_date' => 'required|date'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->only([
            'invoice_date',
            'terms',
            'due_date'
        ]));

        return response()->json(['message' => 'Invoice dates and terms updated successfully!']);
    }

    public function updateProducts(Request $request, $id)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.description' => 'nullable|string',
            'products.*.price' => 'required|numeric|min:0'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->products()->detach();

        foreach ($request->products as $productData) {
            $product = Product::findOrFail($productData['id']);
            $invoice->products()->attach($product->id, [
                'quantity' => $productData['quantity'],
                'description' => $productData['description'],
                'price' => $productData['price']
            ]);
        }

        return response()->json(['message' => 'Products updated successfully!']);
    }

    public function updateFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $invoice = Invoice::findOrFail($id);

        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if ($invoice->file_path) {
                Storage::delete($invoice->file_path);
            }

            // Store the new file
            $path = $request->file('file')->store('invoices');
            $invoice->file_path = $path;
            $invoice->save();
        }

        return response()->json(['message' => 'File updated successfully!']);
    }

    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceData = $request->only([
            'contact_id',
            'invoice_number',
            'order_number',
            'invoice_date',
            'due_date',
            'customer_note',
            'terms'
        ]);

        if ($request->hasFile('file')) {
            if ($invoice->file_path) {
                Storage::delete($invoice->file_path);
            }
            $path = $request->file('file')->store('invoices');
            $invoiceData['file_path'] = $path;
        }

        $invoice->update($invoiceData);

        $invoice->products()->detach();
        foreach ($request->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => $product['quantity'],
                'description' => $product['description']
            ]);
        }

        return response()->json($invoice->load(['products', 'contact']), 200);
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        if ($invoice->file_path) {
            Storage::delete($invoice->file_path);
        }
        $invoice->delete();

        return response()->json(null, 204);
    }



}