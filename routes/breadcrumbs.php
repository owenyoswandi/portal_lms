<?php
use Rawilk\Breadcrumbs\Facades\Breadcrumbs;
use Rawilk\Breadcrumbs\Support\Generator;

// Home
Breadcrumbs::for('home', fn (Generator $trail) => $trail->push('Home', route('home')));

// Admin
Breadcrumbs::for(
    'admin-pengguna',
    fn (Generator $trail) => $trail->parent('home')->push('Kelola Pengguna', route('admin-pengguna'))
);


// Home > Profile
Breadcrumbs::for(
    'profile',
    fn (Generator $trail) => $trail->parent('home')->push('Profile', route('user-profile'))
);

// Home > Agenda Harian
Breadcrumbs::for(
    'agenda-harian',
    fn (Generator $trail) => $trail->parent('home')->push('Agenda Harian', route('agenda-harian'))
);
Breadcrumbs::for(
    'kondisi-harian',
    fn (Generator $trail) => $trail->parent('home')->push('Kondisi Harian', route('kondisi-harian'))
);
Breadcrumbs::for(
    'rencana-kondisi-kesehatan',
    fn (Generator $trail) => $trail->parent('home')->push('Rencana Kondisi Kesehatan', route('rencana-kondisi-kesehatan'))
);
Breadcrumbs::for(
    'rencana-kunjungan',
    fn (Generator $trail) => $trail->parent('home')->push('Rencana Kunjungan', route('rencana-kunjungan'))
);
Breadcrumbs::for(
    'konsumsi-obat',
    fn (Generator $trail) => $trail->parent('home')->push('Konsumsi Obat', route('konsumsi-obat'))
);
// // Home > Blog > [Category]
// Breadcrumbs::for(
//     'category',
//     fn (Generator $trail, $category) => $trail->parent('blog')->push($category->title, route('category', $category->id))
// );

// // Home > Blog > [Category] > [Post]
// Breadcrumbs::for(
//     'post',
//     fn (Generator $trail, $post) => $trail->parent('category', $post->category)->push($post->title, route('post', $post->id))
// );