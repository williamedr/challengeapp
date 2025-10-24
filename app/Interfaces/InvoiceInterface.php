<?php

namespace App\Interfaces;

use App\Models\Invoice;


interface InvoiceInterface
{

	public function all(array $filters);

	public function get(int $id);

	public function create(Invoice $invoice);

	public function update(Invoice $invoice);

	public function delete(Invoice $invoice);

}
