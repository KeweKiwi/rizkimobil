<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured cars that are not sold
        $featuredCars = Car::where('featured', true)
            ->select([
                'id',
                'title',
                'make',
                'model',
                'variant',
                'year',
                'mileage_km',
                'transmission',
                'fuel_type',
                'body_type',
                'price',
                'featured',
                'sold',
                'created_at',
            ])
            ->where('sold', false)
            ->with(['primaryImage', 'fallbackImage'])
            ->take(4)
            ->get();

        $carMakes = [
            'Toyota',
            'Honda',
            'Ford',
            'Chevrolet',
            'BMW',
            'Mercedes-Benz',
            'Audi',
            'Nissan',
            'Hyundai',
            'Volkswagen',
            'Mazda',
            'Subaru',
            'Lexus',
            'Kia',
            'Jeep',
            'Ram',
            'GMC',
            'Tesla',
            'Porsche',
            'Volvo',
        ];

        // Statistics
        $stats = [
            'carsSold' => 5000,
            'satisfiedCustomers' => 4500,
            'yearsInBusiness' => 15,
            'carsInStock' => Car::where('sold', false)->count()
        ];

        $testimonials = [
            [
                'name' => 'Farhan Ashari',
                'headline' => 'Unit rapi, proses cepat, dan transparan sejak awal.',
                'quote' => 'Avanza yang saya ambil kondisinya sesuai foto, interior bersih, dan semua detail dijelaskan dengan jujur. Pengalaman beli terasa tenang karena timnya responsif.',
                'rating' => 5,
                'purchase' => 'Toyota Avanza 2022',
            ],
            [
                'name' => 'Bayu Novandrie',
                'headline' => 'Mobil mulus tanpa drama, langsung nyaman dipakai harian.',
                'quote' => 'Saya cek unit sebelum deal dan hasilnya sesuai ekspektasi. Mesin halus, body terawat, dan handling admin sampai penyerahan mobil terasa profesional.',
                'rating' => 5,
                'purchase' => 'Honda Brio RS 2021',
            ],
            [
                'name' => 'Nadia Permata',
                'headline' => 'Pelayanan hangat, pilihan unitnya juga terasa curated.',
                'quote' => 'Yang paling saya suka, mereka tidak memaksa. Dijelaskan plus-minus unit secara terbuka, jadi keputusan beli terasa mantap dan tidak terburu-buru.',
                'rating' => 4,
                'purchase' => 'Mitsubishi Xpander 2020',
            ],
        ];

        $aboutRizki = [
            'kicker' => 'Tentang Rizki Mobil',
            'title' => 'Jual beli mobil bekas yang terasa lebih tenang, jujur, dan terkurasi.',
            'subtitle' => 'Rizki Mobil Indonesia hadir untuk membuat proses memilih mobil terasa lebih ringan tanpa mengorbankan kualitas.',
            'paragraphs' => [
                'Kami memilih unit dengan standar yang jelas, menyajikan informasi secara terbuka, dan mendampingi pelanggan sampai benar-benar yakin dengan pilihannya.',
                'Bagi kami, pengalaman membeli mobil yang baik bukan soal cepat saja, tetapi soal rasa percaya sejak awal sampai mobil diterima.',
            ],
            'highlights' => [
                ['value' => 'Kurasi Ketat', 'label' => 'Unit dipilih dengan standar yang jelas'],
                ['value' => 'Transparan', 'label' => 'Informasi dijelaskan sejak awal'],
                ['value' => 'Personal', 'label' => 'Pendampingan terasa hangat dan fokus'],
            ],
            'image' => 'images/cars/aset/logo-rmi-hitam.png',
            'vehicle_image' => 'images/cars/bmw13.jpg',
            'handover_image' => 'images/cars/bmw1.jpg',
        ];

        $faqs = [
            [
                'question' => 'Apakah semua mobil di Rizki Mobil sudah melalui inspeksi menyeluruh?',
                'answer' => 'Setiap unit kami kurasi dan cek dengan standar yang jelas agar kondisi utama, riwayat pemakaian, dan detail pentingnya bisa dijelaskan secara terbuka sejak awal.',
            ],
            [
                'question' => 'Apakah Rizki Mobil menerima tukar tambah kendaraan?',
                'answer' => 'Ya, kami melayani tukar tambah untuk berbagai merek dan tahun. Tim kami akan bantu proses appraisal agar nilainya terasa fair dan transparan.',
            ],
            [
                'question' => 'Apakah saya bisa melihat atau mencoba unit sebelum membeli?',
                'answer' => 'Bisa. Anda dapat menjadwalkan visit, inspeksi langsung, atau diskusi lebih dulu dengan tim kami agar keputusan beli terasa lebih yakin dan nyaman.',
            ],
        ];

        // Get user favorites if authenticated
        $favorites = [];
        if (Auth::check()) {
            $favorites = Auth::user()->favorites()->pluck('car_id')->toArray();
        }


        return view('index', compact('featuredCars', 'carMakes', 'stats', 'testimonials', 'aboutRizki', 'faqs', 'favorites'));
    }
}
