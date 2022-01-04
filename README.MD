## Laravolt Onlyoffice

## Installation

Install Laravolt Onlyoffice
```
composer require laravolt/onlyoffice
```

Add and Update .env file
```
GROUPOFFICE_URL=domain groupoffice
ONLYOFFICE_URL=domain onlyoffice
```

Example
```
GROUPOFFICE_URL=domain.groupoffice.com
ONLYOFFICE_URL=domain.onlyoffice.com
```

Masukan isLogin di except EncryptCookies.
```
$except = ['isLogin']
```

Tambahkan Environment Groupoffice dan Onlyoffice ke `config/services.php`
```
'onlyoffice' => [
    'groupoffice_url' => env('GROUPOFFICE_URL'),
    'onlyoffice_url' => env('ONLYOFFICE_URL')
]
```

## Usage
```
<!-- Embeded Onlyoffice -->
<x-onlyoffice id="2"></x-onlyoffice>
// id di dapatkan dari id file.

<!-- Embeded Onlyoffice readonly mode>
<x-onlyoffice id="2" readonly></x-onlyoffice>
```


