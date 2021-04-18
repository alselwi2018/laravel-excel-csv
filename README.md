#install Laravel project from composer
# add composer require maatwebsite/excel
#  add the ServiceProvider in config/app.php

'providers' => [
    /*
     * Package Service Providers...
     */
    Maatwebsite\Excel\ExcelServiceProvider::class,
]
# add the Facade in config/app.php
'aliases' => [
    ...
    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
]

# add php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag=config
Then create a model with controller and migrations
Then setup the view frontend with the router and add the coding process the controller resources.
# add a command for the export and import from Excel using php artisan make:import products and php artisan make:export product

 # laravel-excel-csv
