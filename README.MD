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

TEMPLATE_FOLDER_ID=id folder
```

Example
```
ONLYOFFICE_URL=domain.onlyoffice.com

TEMPLATE_FOLDER_ID=97
```

Jalankan artisan migrate untuk membuat tabel onlyoffice_tokens di database.\
Pastikan tabel users sudah termigrate di database.
```
php artisan migrate
```

Tambahkan Environment Groupoffice dan Onlyoffice ke `config/services.php`
```php
'onlyoffice' => [
    'onlyoffice_url' => env('ONLYOFFICE_URL'),
    'template_folder_id' => env('TEMPLATE_FOLDER_ID')
]
```

## Enable Laravolt OnlyOffice
buka file `platform.php`  di `config/laravolt/platform.php`,
jika belum ada file tersebut, publish vendor `laravolt/config` dengan cara
```
php artisan vendor:publsih
```
copy perintah diatas kemudian paste pada terminal project aplikasi laravolt.
pilih nomor yang keteranganya Tag: laravolt-config

```
...
[43] Tag: laravolt-config
...
```

kemudian tambahkan `'onlyoffice' => true` pada array features.

example :
```php
'features' => [
        ...
        'onlyoffice' => true,
        ...
],
```

## Usage
```html
<!-- Embeded Onlyoffice -->
<x-onlyoffice id="2"></x-onlyoffice>

<!-- Embeded Onlyoffice readonly mode -->
<x-onlyoffice id="2" readonly></x-onlyoffice>
```

#### Keterangan
id = id file dari dokumen\
readonly = digunakan jika menginginkan embedding dengan mode view


