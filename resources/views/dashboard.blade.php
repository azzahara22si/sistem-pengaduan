<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="bg-gray-100 min-h-screen">

        <!-- HERO -->
        <div class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between">
            
            <!-- TEXT -->
            <div class="max-w-lg">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">
                    Sistem Pengaduan Mahasiswa Berbasis Web
                </h1>

                <p class="text-gray-600 mb-6">
                    Sampaikan keluhan, kritik, dan saran dengan mudah dan transparan.
                </p>

                <a href="{{ route('pengaduan.index') }}" 
                   class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                    Lihat Pengaduan →
                </a>
            </div>

            <!-- IMAGE -->
            <div class="mt-8 md:mt-0">
                <img src="https://cdn-icons-png.flaticon.com/512/4712/4712109.png" 
                     class="w-72" alt="Pengaduan">
            </div>

        </div>

        <!-- ABOUT -->
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">
                    About
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    Sistem Pengaduan Mahasiswa Berbasis Web merupakan platform digital 
                    yang dirancang untuk memfasilitasi mahasiswa dalam menyampaikan berbagai 
                    keluhan, saran, maupun kritik terhadap layanan akademik dan non-akademik 
                    secara cepat, transparan, dan terdokumentasi.
                </p>
            </div>
        </div>

        <!-- TUJUAN -->
        <div class="max-w-5xl mx-auto px-6 py-8">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-xl font-semibold text-blue-700 mb-4">
                    Tujuan & Manfaat
                </h2>

                <p class="text-gray-600 leading-relaxed">
                    Sistem ini membantu mahasiswa menyampaikan keluhan secara langsung 
                    ke unit terkait, meningkatkan transparansi, serta mempercepat 
                    proses penanganan pengaduan. Dengan pendekatan CRM-IDIC, sistem ini 
                    memberikan layanan yang responsif, efisien, dan berorientasi pada kebutuhan mahasiswa.
                </p>
            </div>
        </div>

        <!-- STATS (BIAR KELIHATAN PRO) -->
        <div class="max-w-5xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-blue-600 text-white p-6 rounded-xl shadow text-center">
                <h3 class="text-2xl font-bold">
                    {{ \App\Models\Pengaduan::count() }}
                </h3>
                <p>Total Pengaduan</p>
            </div>

            <div class="bg-yellow-500 text-white p-6 rounded-xl shadow text-center">
                <h3 class="text-2xl font-bold">
                    {{ \App\Models\Pengaduan::where('status','proses')->count() }}
                </h3>
                <p>Diproses</p>
            </div>

            <div class="bg-green-600 text-white p-6 rounded-xl shadow text-center">
                <h3 class="text-2xl font-bold">
                    {{ \App\Models\Pengaduan::where('status','selesai')->count() }}
                </h3>
                <p>Selesai</p>
            </div>

        </div>

    </div>
</x-app-layout>