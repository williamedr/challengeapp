<?php
namespace App\Repositories;

use App\Interfaces\InvoiceInterface;
use App\Models\Invoice;

class InvoiceRepository implements InvoiceInterface
{
	public $invoice;

	public function __construct(Invoice $invoice)
	{
		$this->invoice = $invoice;
	}


	public function all($filters = [])
	{
		$query = $this->invoice;

		if (empty($filters)) {
			$query = $this->invoice;
		} else {
			$query = $this->invoice->where($filters);
		}

		if (isset($filters['id'])) {
			$result = $query->first();

			if (empty($result)) {
				$result = [];
			}

		} else {
			$result = $query->get();
		}

		return $result;
	}

	public function get(int $id)
	{
		return $this->invoice->findOrFail($id);
	}

	public function create(Invoice $invoice)
	{
		$invoice->save();

		return $invoice;
	}

	public function update(Invoice $invoice)
	{
		$invoice->save();

		return $invoice;
	}

	public function delete(Invoice $invoice)
	{
		$invoice->delete();

		return $invoice;
	}

}
