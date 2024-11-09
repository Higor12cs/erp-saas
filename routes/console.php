<?php

use App\Tenancy\CustomTenantModel;
use Illuminate\Support\Facades\Artisan;

Artisan::command('tenant:create', function () {
    $name = $this->ask('What is the name of the tenant?');
    $domain = $this->ask('What is the domain of the tenant?');
    $database = $this->ask('What is the database of the tenant?');

    CustomTenantModel::create([
        'name' => $name,
        'domain' => $domain,
        'database' => 'tenant_'.$database,
    ]);

    $this->info('Tenant created successfully!');
})->purpose('Create a new tenant');

Artisan::command('tenant:migrate', function () {
    Artisan::call('tenants:artisan "migrate --database=tenant"');

    $this->info('Tenants migrated successfully!');
})->purpose('Migrate all tenants');
