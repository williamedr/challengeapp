<?php
namespace App\Providers;

use App\Interfaces\ClientInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\InvoiceInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\OrderItemInterface;
use App\Interfaces\ProductInterface;
use App\Repositories\ClientRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
	public function register()
	{

		$this->app->bind(ProductInterface::class, ProductRepository::class);

		$this->app->bind(OrderInterface::class, OrderRepository::class);

		$this->app->bind(OrderItemInterface::class, OrderItemRepository::class);

		$this->app->bind(InvoiceInterface::class, InvoiceRepository::class);

		$this->app->bind(ClientInterface::class, ClientRepository::class);

	}

	public function boot() {}
}
