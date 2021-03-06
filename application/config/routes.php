<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['logout'] = 'login/logout';
$route['laporan-buku'] = 'laporan_buku/index';
$route['cetak-laporan-buku'] = 'laporan_buku/cetak_laporan_buku';
$route['laporan-anggota'] = 'laporan_anggota/index';
$route['cetak-laporan-anggota'] = 'laporan_anggota/cetak_laporan_anggota';
$route['laporan-peminjaman'] = 'laporan_peminjaman/index';
$route['cetak-laporan-peminjaman/(:any)/(:any)'] = 'laporan_peminjaman/cetak_laporan_peminjaman/$1/$2';
$route['laporan-pengembalian'] = 'laporan_pengembalian/index';
$route['cetak-laporan-pengembalian/(:any)/(:any)'] = 'laporan_pengembalian/cetak_laporan_pengembalian/$1/$2';
$route['laporan-denda'] = 'laporan_denda/index';
$route['cetak-laporan-denda/(:any)/(:any)'] = 'laporan_denda/cetak_laporan_denda/$1/$2';
$route['peminjaman-anggota'] = 'peminjaman_anggota';
$route['peminjaman-anggota-create'] = 'peminjaman_anggota/create';
$route['pengembalian-anggota'] = 'pengembalian_anggota';
$route['approve-anggota'] = 'approve_anggota';
$route['approve-pinjam'] = 'approve_pinjam';
$route['approve-kembali'] = 'approve_kembali';
$route['cara-pinjam'] = 'about/cara';
$route['visi'] = 'about/visi';
$route['tata'] = 'about/tata';






