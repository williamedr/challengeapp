<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Interfaces\InvoiceInterface;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends BaseController
{
	private $invoice;


	public function __construct(InvoiceInterface $invoice)
	{
		$this->invoice = $invoice;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$filters = $request->all();

		$result = $this->invoice->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreInvoiceRequest $request)
	{
		$record = new Invoice($request->validated());

		$result = $this->invoice->create($record);

		return $this->sendResponse($result);
	}


	/**
	 * Display the specified resource.
	 */
	public function show(Invoice $invoice)
	{
		return $this->sendResponse($invoice);
	}



	/**
	 * Update the specified resource in storage.
	 */
	public function update(UpdateInvoiceRequest $request, Invoice $invoice)
	{
		$invoice->fill($request->validated());

		$result = $this->invoice->update($invoice);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Invoice $invoice)
	{
		$result = $this->invoice->delete($invoice);

		return $this->sendResponse($result);
	}


	/**
	 * Return the model create form.
	 */
	public function create()
	{
		return '';
	}


	/**
	 * Return the model edit form.
	 */
	public function edit()
	{
		return '';
	}



	/**
	 * Display a listing of the resource.
	 */
	public function notifications()
	{
		$result = Auth::user()->notifications;

		return $this->sendResponse($result);
	}


}
