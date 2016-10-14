<?php

return $settings = [


    'newHireReportsPrefix' => 'New User Action Notification-', 'separationReportsPrefix' => 'Separation Notification-',
    'payrollNewHireReportsPrefix' => 'Payroll Notification-',
    'payrollSeparationReportsPrefix' => 'Payroll Separation Notification-',

    // location for the reports

    'newHireReportsPath' => storage_path() . '/reports/New_Hires/', 'newHireURL' => '/report/newhire/',
    'separationReportsPath' => storage_path() . '/reports/Separations/', 'separationURL' => '/report/separation/',
    'payrollNewHireReportsPath' => storage_path() . '/reports/Payroll/New_Hires/',
    'payrollNewHireURL' => '/report/payrollNewHire/',
    'payrollSeparationReportsPath' => storage_path() . '/reports/Payroll/Separations/',
    'payrollSeparationURL' => '/report/payrollSeparation/',
    'change_org_ReportsPath' => storage_path() . '/reports/Org_Change/', 'change_org_URL' => '/report/change_org_rep/',
    'org_change_ReportsPrefix' => 'User Organization Change Notification-',

    // filepath for the schedule batch file
    'schedule_batch' => storage_path() . '/scheduled_batch.json',

    /*
     * Email settings
     */
    'si_infra' => 'servicedesk.illy@eng.it', 'servicedesk' => 'itservicena@illy.com',
    'eMailHRAdd' => 'Maren.Gizicki@illy.com', 'eMailITManager' => 'roy.forster@illy.com',
    'eMailITApplication' => 'Massimiliano.Delise@illy.com', 'illySanFrancisco' => 'donna.garcia@illy.com',
    'eMailIT' => 'Michael.Voisine@illy.com', 'eMailManagement' => 'Suzanne.Schwab@illy.com',
    'eMailManagement1' => 'tanita.billups@illy.com',
    'eMailFinanceCreditCard' => 'Marjorie.Guthrie@illy.com',
    'eMailFinanceDrivers' => 'Erik.Tellone@illy.com',

    'subjectPrefix' => 'User Action Notification for ', 'subjectBatchPrefix' => 'HR Tool Action taken for ',


    'departments' => ['Sales', 'Customer Care', 'Finance', 'Information Technology', 'Marketing', 'Human Resources',
        'Quality and Tech', 'Public Relations', 'Operations', 'Other',],


    'companies' => ['illy caffè North America, Inc', 'Espressamente illy', 'illy caffè San Francisco LLC',
        'illy Espresso Canada',],


    'illy caffè North America, Inc' => ['streetAddress' => '800 Westchester Avenue, Suite S440',
        'postalCode' => '10573', 'l' => 'Rye Brook', 'c' => 'US', 'st' => 'NY'],
    'Espressamente illy' => ['streetAddress' => '800 Westchester Avenue, Suite S438', 'postalCode' => '10573',
        'l' => 'Rye Brook', 'c' => 'US', 'st' => 'NY'],
    'illy caffè San Francisco LLC' => ['streetAddress' => '535 Mission Street, Suite 1584', 'postalCode' => '94105',
        'l' => 'San Francisco', 'c' => 'US', 'st' => 'CA'],
    'illy Espresso Canada' => ['streetAddress' => '197 Main Street', 'postalCode' => 'E3A 1E1', 'l' => 'Fredericton',
        'c' => 'CA', 'st' => 'NB'],
    'illy caffè North America, Inc - nyc' => ['streetAddress' => '275 Madison Avenue, 18th Floor',
        'postalCode' => '10016', 'l' => 'New York', 'c' => 'US', 'st' => 'NY'],


    'hireStatus' => ['New Hire', 'Re-Hire', 'Seasonal', 'Temporary', 'Separation'],
    'associate_class' => ['Full-time', 'Part-Time',],


    'salaryType' => ['Annual Salary', 'Hourly', 'Half Month', 'Other',],
    'payrollType' => ['ADP Payroll', 'Non - ADP Payroll',],

    'locations' => ['Rye Brook', 'New York City', 'Canada', 'Scottsdale', 'Remote Users',],


    /*
     * Notifications section
     * */
    'itDepartment' => 'IT Department Checklist: Michael Voisine and Service Desk',
    'applicationTeam' => 'JDE Setup - IT Team', 'officeManager' => 'HQ Office Manager-Suzie Schwab',
    'newDriver' => 'New Driver for Company Vehicle Form-Erik Tellone (new hire notification only) (if applicable)',
    'finance' => 'Finance - Marjorie Guthrie', 'payroll' => 'Benefits/Payroll Manager - Maritza Zelvin',


    /*
	|--------------------------------------------------------------------------
	| Application Debug Mode
	|--------------------------------------------------------------------------
	|
	| When your application is in debug mode, detailed error messages with
	| stack traces will be shown on every error that occurs within your
	| application. If disabled, a simple generic error page is shown.
	|
	*/

    'debug' => env('APP_DEBUG'),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => 'http://localhost',

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'America/New_York',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'iy3pooBPABFeR5nJ45gBsLrMHIOIOCDv'),

    'cipher' => MCRYPT_RIJNDAEL_128,

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => 'daily',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        'Illuminate\Foundation\Providers\ArtisanServiceProvider', 'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Bus\BusServiceProvider', 'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Foundation\Providers\ConsoleSupportServiceProvider', 'Illuminate\Routing\ControllerServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider', 'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider', 'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Foundation\Providers\FoundationServiceProvider', 'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Mail\MailServiceProvider', 'Illuminate\Pagination\PaginationServiceProvider',
        'Illuminate\Pipeline\PipelineServiceProvider', 'Illuminate\Queue\QueueServiceProvider',
        'Illuminate\Redis\RedisServiceProvider', 'Illuminate\Auth\Passwords\PasswordResetServiceProvider',
        'Illuminate\Session\SessionServiceProvider', 'Illuminate\Translation\TranslationServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider', 'Illuminate\View\ViewServiceProvider',
        'Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',

        /*
         * Application Service Providers...
         */
        'App\Providers\AppServiceProvider', 'App\Providers\BusServiceProvider', 'App\Providers\ConfigServiceProvider',
        'App\Providers\EventServiceProvider', 'App\Providers\RouteServiceProvider',

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => 'Illuminate\Support\Facades\App', 'Artisan' => 'Illuminate\Support\Facades\Artisan',
        'Auth' => 'Illuminate\Support\Facades\Auth', 'Blade' => 'Illuminate\Support\Facades\Blade',
        'Bus' => 'Illuminate\Support\Facades\Bus', 'Cache' => 'Illuminate\Support\Facades\Cache',
        'Config' => 'Illuminate\Support\Facades\Config', 'Cookie' => 'Illuminate\Support\Facades\Cookie',
        'Crypt' => 'Illuminate\Support\Facades\Crypt', 'DB' => 'Illuminate\Support\Facades\DB',
        'Eloquent' => 'Illuminate\Database\Eloquent\Model', 'Event' => 'Illuminate\Support\Facades\Event',
        'File' => 'Illuminate\Support\Facades\File', 'Hash' => 'Illuminate\Support\Facades\Hash',
        'Input' => 'Illuminate\Support\Facades\Input', 'Inspiring' => 'Illuminate\Foundation\Inspiring',
        'Lang' => 'Illuminate\Support\Facades\Lang', 'Log' => 'Illuminate\Support\Facades\Log',
        'Mail' => 'Illuminate\Support\Facades\Mail', 'Password' => 'Illuminate\Support\Facades\Password',
        'Queue' => 'Illuminate\Support\Facades\Queue', 'Redirect' => 'Illuminate\Support\Facades\Redirect',
        'Redis' => 'Illuminate\Support\Facades\Redis', 'Request' => 'Illuminate\Support\Facades\Request',
        'Response' => 'Illuminate\Support\Facades\Response', 'Route' => 'Illuminate\Support\Facades\Route',
        'Schema' => 'Illuminate\Support\Facades\Schema', 'Session' => 'Illuminate\Support\Facades\Session',
        'Storage' => 'Illuminate\Support\Facades\Storage', 'URL' => 'Illuminate\Support\Facades\URL',
        'Validator' => 'Illuminate\Support\Facades\Validator', 'View' => 'Illuminate\Support\Facades\View',

    ],

];
