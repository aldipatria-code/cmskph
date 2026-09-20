<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Faq;
use App\Models\GalleryCategory;
use App\Models\Post;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\User;
use App\Models\YoutubeVideo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = collect([
            'manage users',
            'publish posts',
            'write posts',
        ])->mapWithKeys(fn (string $permission) => [
            $permission => Permission::firstOrCreate(['name' => $permission]),
        ]);

        $roles = [
            'admin' => Role::firstOrCreate(['name' => 'admin']),
            'redaktur' => Role::firstOrCreate(['name' => 'redaktur']),
            'penulis' => Role::firstOrCreate(['name' => 'penulis']),
        ];

        $roles['admin']->syncPermissions($permissions->values());
        $roles['redaktur']->syncPermissions([
            $permissions['publish posts'],
            $permissions['write posts'],
        ]);
        $roles['penulis']->syncPermissions([
            $permissions['write posts'],
        ]);

        $users = [
            'admin' => $this->upsertUser(
                [
                    'name' => 'Admin',
                    'username' => 'admin_utama',
                    'email' => 'admin@wartawarga.com',
                ],
                true,
                $roles['admin'],
            ),
            'redaktur' => $this->upsertUser(
                [
                    'name' => 'Redaktur',
                    'username' => 'redaktur_kece',
                    'email' => 'redaktur@wartawarga.com',
                ],
                true,
                $roles['redaktur'],
            ),
            'penulis' => $this->upsertUser(
                [
                    'name' => 'Penulis',
                    'username' => 'budi_cerita',
                    'email' => 'penulis@wartawarga.com',
                ],
                true,
                $roles['penulis'],
            ),
            'penulis2' => $this->upsertUser(
                [
                    'name' => 'Penulis',
                    'username' => 'siti_info',
                    'email' => 'siti@wartawarga.com',
                ],
                true,
                $roles['penulis'],
            ),
            'calon_penulis' => $this->upsertUser(
                [
                    'name' => 'Penulis belum terverifikasi',
                    'username' => 'ani_nulis',
                    'email' => 'ani@wartawarga.com',
                ],
                false,
                $roles['penulis'],
            ),
        ];

        $categories = collect([
            ['name' => 'Peristiwa', 'slug' => 'peristiwa', 'description' => 'Kabar peristiwa terkini di sekitar warga.'],
            ['name' => 'Lingkungan', 'slug' => 'lingkungan', 'description' => 'Berita dan gerakan menjaga lingkungan.'],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi', 'description' => 'Cerita ekonomi, UMKM, dan usaha warga.'],
            ['name' => 'Gaya Hidup', 'slug' => 'gaya-hidup', 'description' => 'Inspirasi gaya hidup dan komunitas.'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'description' => 'Teknologi yang dekat dengan kehidupan sehari-hari.'],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category,
            ),
        ]);

        $tags = collect([
            ['name' => 'Berita Lokal', 'slug' => 'berita-lokal'],
            ['name' => 'Komunitas', 'slug' => 'komunitas'],
            ['name' => 'UMKM', 'slug' => 'umkm'],
            ['name' => 'Pelayanan Publik', 'slug' => 'pelayanan-publik'],
            ['name' => 'Inovasi', 'slug' => 'inovasi'],
            ['name' => 'Kegiatan Warga', 'slug' => 'kegiatan-warga'],
            ['name' => 'Tips', 'slug' => 'tips'],
            ['name' => 'Inspirasi', 'slug' => 'inspirasi'],
        ])->mapWithKeys(fn (array $tag) => [
            $tag['slug'] => Tag::updateOrCreate(['slug' => $tag['slug']], $tag),
        ]);

        $posts = [
            [
                'slug' => 'warga-gelar-kerja-bakti-bersihkan-sungai',
                'title' => 'Warga Gelar Kerja Bakti Bersihkan Sungai',
                'category' => 'lingkungan',
                'author' => 'penulis',
                'status' => Post::STATUS_PUBLISHED,
                'editor_notes' => null,
                'tags' => ['berita-lokal', 'komunitas', 'kegiatan-warga'],
                'views_count' => 128,
                'published_at' => now()->subDays(3),
                'cover_image' => 'posts-covers/01M2TM5179H4Z6Y6459QJSAWFT.webp',
            ],
            [
                'slug' => 'umkm-kampung-naik-kelas-dengan-pemasaran-digital',
                'title' => 'UMKM Kampung Naik Kelas dengan Pemasaran Digital',
                'category' => 'ekonomi',
                'author' => 'penulis2',
                'status' => Post::STATUS_PUBLISHED,
                'editor_notes' => null,
                'tags' => ['umkm', 'inovasi', 'tips'],
                'views_count' => 94,
                'published_at' => now()->subDays(5),
                'cover_image' => 'posts-covers/01M2TNS8Q52PGTPVKKJX6ZHG16.webp',
            ],
            [
                'slug' => 'layanan-administrasi-kelurahan-kini-lebih-cepat',
                'title' => 'Layanan Administrasi Kelurahan Kini Lebih Cepat',
                'category' => 'peristiwa',
                'author' => 'penulis',
                'status' => Post::STATUS_PUBLISHED,
                'editor_notes' => null,
                'tags' => ['pelayanan-publik', 'berita-lokal'],
                'views_count' => 76,
                'published_at' => now()->subDays(7),
                'cover_image' => 'posts-covers/01M2TNT4NG07ZXJQCXV0J1KRTX.webp',
            ],
            [
                'slug' => 'festival-kuliner-warga-hadirkan-menu-unggulan',
                'title' => 'Festival Kuliner Warga Hadirkan Menu Unggulan',
                'category' => 'gaya-hidup',
                'author' => 'penulis2',
                'status' => Post::STATUS_PENDING,
                'editor_notes' => null,
                'tags' => ['komunitas', 'kegiatan-warga', 'umkm'],
                'views_count' => 21,
                'published_at' => null,
                'cover_image' => 'posts-covers/01M2TNV80KTRNF6N6A92JW5XX3.webp',
            ],
            [
                'slug' => 'aplikasi-pengaduan-warga-mulai-diuji-coba',
                'title' => 'Aplikasi Pengaduan Warga Mulai Diuji Coba',
                'category' => 'teknologi',
                'author' => 'penulis',
                'status' => Post::STATUS_PENDING,
                'editor_notes' => null,
                'tags' => ['inovasi', 'pelayanan-publik'],
                'views_count' => 8,
                'published_at' => null,
                'cover_image' => 'posts-covers/01M2TNW5GCC5HMBW1KKJ2QXS7T.webp',
            ],
            [
                'slug' => 'tips-memulai-kebun-sayur-di-halaman-rumah',
                'title' => 'Tips Memulai Kebun Sayur di Halaman Rumah',
                'category' => 'lingkungan',
                'author' => 'penulis2',
                'status' => Post::STATUS_DRAFT,
                'editor_notes' => null,
                'tags' => ['tips', 'inspirasi'],
                'views_count' => 0,
                'published_at' => null,
                'cover_image' => 'posts-covers/01M2TPAKCPMVC0BPDZMHWSSBV2.jpg',
            ],
            [
                'slug' => 'usulan-pasar-malam-ditolak-demi-ketertiban',
                'title' => 'Usulan Pasar Malam Ditolak demi Ketertiban',
                'category' => 'peristiwa',
                'author' => 'penulis',
                'status' => Post::STATUS_REJECTED,
                'editor_notes' => 'Mohon lengkapi data lokasi dan konfirmasi dari pihak terkait.',
                'tags' => ['berita-lokal', 'komunitas'],
                'views_count' => 4,
                'published_at' => null,
                'cover_image' => 'posts-covers/01M2TQFTDM16GGDTD84XYQWHSA.jpg',
            ],
            [
                'slug' => 'bank-sampah-warga-ubah-limbah-jadi-tabungan',
                'title' => 'Bank Sampah Warga Ubah Limbah Jadi Tabungan',
                'category' => 'lingkungan',
                'author' => 'penulis2',
                'status' => Post::STATUS_PUBLISHED,
                'editor_notes' => null,
                'tags' => ['komunitas', 'inspirasi', 'kegiatan-warga'],
                'views_count' => 143,
                'published_at' => now()->subDays(10),
                'cover_image' => 'posts-covers/01M2TQGT7WB6HQ8WZ2MRS8PEFH.jpg',
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::updateOrCreate(
                ['slug' => $postData['slug']],
                [
                    'user_id' => $users[$postData['author']]->id,
                    'category_id' => $categories[$postData['category']]->id,
                    'editor_id' => in_array($postData['status'], [Post::STATUS_PUBLISHED, Post::STATUS_REJECTED], true)
                        ? $users['redaktur']->id
                        : null,
                    'title' => $postData['title'],
                    'content' => $this->contentFor($postData['title']),
                    'status' => $postData['status'],
                    'editor_notes' => $postData['editor_notes'],
                    'meta_title' => $postData['title'].' | WartaWarga',
                    'meta_description' => 'Baca berita terbaru '.$postData['title'].' di WartaWarga.',
                    'meta_keywords' => implode(', ', $postData['tags']),
                    'views_count' => $postData['views_count'],
                    'published_at' => $postData['published_at'],
                ],
            );

            if (! $post->cover_image && filled($postData['cover_image'] ?? null)) {
                $post->update(['cover_image' => $postData['cover_image']]);
            }

            $post->tags()->sync($tags->only($postData['tags'])->pluck('id'));
        }

        $publishedPosts = Post::where('status', Post::STATUS_PUBLISHED)->get();
        $commentBodies = [
            'Informasinya sangat bermanfaat, terima kasih sudah berbagi.',
            'Semoga kegiatan seperti ini bisa terus dilaksanakan.',
            'Kabar baik untuk warga. Ditunggu pembaruan berikutnya.',
            'Saya baru mengetahui informasi ini dari WartaWarga.',
        ];

        foreach ($publishedPosts as $index => $post) {
            Comment::updateOrCreate(
                [
                    'post_id' => $post->id,
                    'user_id' => $users['penulis']->id,
                    'body' => $commentBodies[$index % count($commentBodies)],
                ],
                ['is_visible' => true],
            );
        }

        $this->seedGalleries();
        $this->seedGalleryCategories();
        $this->seedBranding();
        $this->seedFaqs();
        $this->seedYoutubeVideos();

        $this->command?->info('Data dummy berhasil dibuat. Password seluruh akun: password');
    }

    private function seedGalleries(): void
    {
        $galleries = [
            [
                'slug' => 'wdddddd',
                'title' => 'WDDDDDD',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TTQ62Y3SCYDCVHVB82MQ3D.jpg',
                'event_date' => '2026-09-30',
            ],
            [
                'slug' => 'sosial-enginering',
                'title' => 'Sosial Enginering',
                'category' => 'Sosial',
                'image_path' => 'gallery/01M2TTKXAXRYCWRTKZVHHYVBG0.jpeg',
                'event_date' => '2026-09-24',
            ],
            [
                'slug' => 'festival-kuliner-warga-hadirkan-menu-unggulan',
                'title' => 'Festival Kuliner Warga Hadirkan Menu Unggulan',
                'category' => 'Kampanye',
                'image_path' => 'gallery/01M2TTNAVQNJV4TYEYM3YZSM65.jpg',
                'event_date' => '2026-09-23',
            ],
            [
                'slug' => 'workshop',
                'title' => 'Workshop',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TTFVFP7M6Y5NF0BPADDE5V.jpeg',
                'event_date' => null,
            ],
            [
                'slug' => 'dokumentasi-kegiatan-01',
                'title' => 'Dokumentasi Kegiatan 01',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TTJACDCEB333GCAK5YHEE3.jpeg',
                'event_date' => null,
            ],
            [
                'slug' => 'dokumentasi-kegiatan-02',
                'title' => 'Dokumentasi Kegiatan 02',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TV1SF2TJZJDGK759215327.jpg',
                'event_date' => null,
            ],
            [
                'slug' => 'dokumentasi-kegiatan-03',
                'title' => 'Dokumentasi Kegiatan 03',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TV29PM7SARMKDCBXY6TC71.png',
                'event_date' => null,
            ],
            [
                'slug' => 'dokumentasi-kegiatan-04',
                'title' => 'Dokumentasi Kegiatan 04',
                'category' => 'Komunitas',
                'image_path' => 'gallery/01M2TV3S035WH5P6V5ZK4XPW15.jpeg',
                'event_date' => null,
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::updateOrCreate(
                ['slug' => $gallery['slug']],
                $gallery + [
                    'description' => 'Dokumentasi kegiatan Komunitas Peduli Hepatitis.',
                    'is_published' => true,
                ],
            );
        }

    }

    private function seedGalleryCategories(): void
    {
        foreach ([
            'Pendidikan',
            'Sosial',
            'Dakwah',
            'Ekonomi',
            'Kesehatan',
            'Kurban',
            'Ramadhan',
        ] as $order => $name) {
            GalleryCategory::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'sort_order' => $order + 1,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedBranding(): void
    {
        $settings = SiteSetting::query()->orderBy('id')->first();

        if (! $settings) {
            $settings = SiteSetting::current();
        }

        $settings->update([
            'logo_path' => $settings->logo_path ?: 'branding/01M2TMRYAS4KTQ1W4AHNYPT2ZB.jpg',
            'login_logo_path' => $settings->login_logo_path ?: 'branding/01M2TMRYB2NXCSP2BZKHXXBTKH.jpg',
        ]);
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu Komunitas Peduli Hepatitis?',
                'answer' => 'Komunitas Peduli Hepatitis adalah ruang edukasi, dukungan, dan berbagi pengalaman untuk meningkatkan kesadaran tentang hepatitis.',
                'sort_order' => 1,
            ],
            [
                'question' => 'Apa perbedaan Hepatitis A, B, dan C?',
                'answer' => 'Hepatitis A, B, dan C disebabkan oleh virus yang berbeda dan memiliki cara penularan serta penanganan yang berbeda. Konsultasikan kondisi kesehatan Anda kepada tenaga kesehatan.',
                'sort_order' => 2,
            ],
            [
                'question' => 'Bagaimana cara bergabung dengan komunitas?',
                'answer' => 'Klik menu Gabung Komunitas, lengkapi formulir pendaftaran, lalu tim kami akan meninjau data dan menghubungi Anda.',
                'sort_order' => 3,
            ],
            [
                'question' => 'Apakah data pendaftaran anggota aman?',
                'answer' => 'Data pendaftaran digunakan untuk komunikasi dan kegiatan komunitas, serta dikelola sesuai kebutuhan layanan Komunitas Peduli Hepatitis.',
                'sort_order' => 4,
            ],
            [
                'question' => 'Di mana saya bisa mendapatkan informasi kegiatan?',
                'answer' => 'Informasi terbaru tersedia di halaman Beranda dan dokumentasi kegiatan dapat dilihat melalui menu Galeri.',
                'sort_order' => 5,
            ],
            [
                'question' => 'Apakah komunitas memberikan diagnosis atau pengobatan?',
                'answer' => 'Tidak. Informasi di website bersifat edukatif dan tidak menggantikan pemeriksaan, diagnosis, atau pengobatan dari tenaga kesehatan.',
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq + ['is_published' => true],
            );
        }
    }

    private function seedYoutubeVideos(): void
    {
        $videos = [
            [
                'title' => 'Edukasi dan dukungan kesehatan untuk komunitas',
                'description' => 'Video edukasi untuk membuka diskusi tentang pentingnya informasi kesehatan yang mudah dipahami dan dapat dipercaya.',
                'category' => 'Kesehatan',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'sort_order' => 1,
            ],
            [
                'title' => 'Berbagi informasi bersama komunitas',
                'description' => 'Dokumentasi video tentang pentingnya berbagi pengetahuan dan membangun dukungan di lingkungan komunitas.',
                'category' => 'Komunitas',
                'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'sort_order' => 2,
            ],
        ];

        foreach ($videos as $video) {
            YoutubeVideo::updateOrCreate(
                ['youtube_url' => $video['youtube_url']],
                $video + ['is_published' => true],
            );
        }
    }

    private function upsertUser(array $attributes, bool $isVerified, Role $role): User
    {
        $user = User::updateOrCreate(
            ['email' => $attributes['email']],
            $attributes + [
                'password' => Hash::make('password'),
                'is_verified' => $isVerified,
                'is_active' => true,
                'email_verified_at' => $isVerified ? now() : null,
            ],
        );

        $user->syncRoles([$role]);

        return $user;
    }

    private function contentFor(string $title): string
    {
        return '<p>'.$title.' menjadi perhatian warga dan dibahas dalam kegiatan komunitas setempat.</p>'
            .'<p>Informasi ini dirangkum berdasarkan keterangan warga dan pengamatan di lapangan. '
            .'Warga berharap kolaborasi antara masyarakat dan pihak terkait dapat terus terjaga.</p>'
            .'<p>Ikuti WartaWarga untuk mendapatkan kabar terbaru dari lingkungan sekitar.</p>';
    }
}
