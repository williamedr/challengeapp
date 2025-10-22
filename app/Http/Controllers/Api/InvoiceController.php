<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Invoice\UpdateInvoiceRequest;
use App\Repositories\InvoiceRepository;
use App\Models\Invoice;

class InvoiceController extends BaseController
{
	private $invoiceRepository;


	public function __construct(InvoiceRepository $invoiceRepository)
	{
		$this->invoiceRepository = $invoiceRepository;
	}


	/**
	 * Display a listing of the resource.
	 */
	public function index()
	{
		$filters = [];

		$result = $this->invoiceRepository->all($filters);

		return $this->sendResponse($result);
	}


	/**
	 * Store a newly created resource in storage.
	 */
	public function store(StoreInvoiceRequest $request)
	{
		$record = new Invoice($request->validated());

		$result = $this->invoiceRepository->save($record);

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

		$result = $this->invoiceRepository->save($invoice);

		return $this->sendResponse($result);
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Invoice $invoice)
	{
		$result = $this->invoiceRepository->delete($invoice);

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


}
