@extends('layouts.public')

@section('title', 'Pendaftaran PPDB Online — SMA Islam Al-Madinah BSD')
@section('meta_description', 'Pendaftaran Peserta Didik Baru (PPDB) Online SMA Islam Al-Madinah BSD Tahun Ajaran 2027/2028. Informasi kuota rombel, persyaratan berkas, dan registrasi santri baru.')

@section('content')
@php
    $schoolName = $profile->name ?? 'SMA Islam Al-Madinah BSD';
    $academicYear = $ppdbSetting->academic_year ?? '2027/2028';
    $whatsapp = $profile->whatsapp ?? '0812-9988-7766';
    $whatsappClean = preg_replace('/[^0-9]/', '', $whatsapp);
    if (str_starts_with($whatsappClean, '0')) {
        $whatsappClean = '62' . substr($whatsappClean, 1);
    }
@endphp

<!-- Header Banner -->
<section class="relative bg-gradient-to-br from-[#3E2B52] via-[#543A70] to-[#704E94] text-white py-14 lg:py-20 overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
    <div class="relative max-w-[1280px] mx-auto px-4 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/10 border border-white/15 text-xs font-semibold text-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-[#2A923F] animate-pulse"></span>
                    <span>Tahun Ajaran {{ $academicYear }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight">
                    Pendaftaran PPDB Online
                </h1>
                <p class="text-sm sm:text-base text-white/85 max-w-xl leading-relaxed">
                    Silakan lengkapi formulir pendaftaran santri baru SMA Islam Al-Madinah BSD dengan data yang valid dan sesuai dokumen resmi.
                </p>
            </div>

            <!-- Quick Action: Check Status -->
            <div class="shrink-0 flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('ppdb.check-status') }}" 
                   class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-6 py-3 rounded-full bg-white text-[#684681] hover:bg-[#FAF8FC] font-extrabold text-xs uppercase tracking-wider transition-all shadow-md">
                    <svg class="w-4 h-4 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cek Status Pendaftaran</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Content & Form Container -->
<section class="py-12 lg:py-16 bg-[#FAF9FB]">
    <div class="max-w-[1000px] mx-auto px-4 lg:px-8 space-y-8">
        
        <!-- Info Kuota & Jadwal Banner -->
        <div class="bg-white rounded-2xl border border-[#E7E3EA] p-4 sm:p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start sm:items-center gap-3.5 sm:gap-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-[#F4F0F7] flex items-center justify-center text-[#9377AD] shrink-0 mt-0.5 sm:mt-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#9377AD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#202124]">Kuota Siswa: {{ $ppdbSetting->total_quota ?? 120 }} Siswa</h3>
                    <p class="text-xs text-[#66676B]">Maksimal 24 siswa per rombel (5 rombel) demi efektivitas tahfidz & pengajaran intensif.</p>
                </div>
            </div>
            <div class="text-left sm:text-right bg-[#FAF8FC] sm:bg-transparent p-3 sm:p-0 rounded-xl">
                <span class="text-xs font-semibold text-[#66676B]">Sisa Kuota Tersedia:</span>
                <div class="text-xl font-black text-[#2A923F]">
                    {{ $ppdbSetting->remaining_quota ?? 85 }} Kursi
                </div>
            </div>
        </div>

        @if (isset($errors) && $errors->any())
            <div class="p-5 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700 space-y-2">
                <div class="font-bold flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Terdapat beberapa isian yang perlu diperiksa kembali:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 pl-4 text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulir Pendaftaran -->
        <form action="{{ route('ppdb.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl sm:rounded-3xl border border-[#E7E3EA] p-4 sm:p-8 lg:p-10 shadow-sm space-y-8">
            @csrf

            <!-- SECTION A: DATA CALON SISWA -->
            <div class="space-y-5">
                <div class="border-b border-[#E7E3EA] pb-3 flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-[#9377AD] text-white flex items-center justify-center font-bold text-xs shadow-xs">1</span>
                    <h2 class="text-base font-bold text-[#202124]">Data Calon Siswa</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-xs font-bold text-[#202124] flex items-center justify-between">
                            <span>Nama Lengkap Siswa <span class="text-red-500">*</span></span>
                            <span class="text-[11px] text-[#66676B] font-normal">Sesuai Akta Kelahiran</span>
                        </label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required 
                               placeholder="Contoh: Muhammad Fatih Rayhan"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <!-- NIK & NISN -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" 
                               placeholder="16 digit NIK calon siswa"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">NISN (Nomor Induk Siswa Nasional)</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" 
                               placeholder="10 digit NISN dari SMP/MTs"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <!-- Tempat & Tgl Lahir -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="birth_place" value="{{ old('birth_place') }}" required 
                               placeholder="Contoh: Tangerang Selatan"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required 
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <!-- Jenis Kelamin & Agama -->
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="gender" required 
                                class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] bg-[#FAF8FC] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Asal Sekolah (SMP/MTs)</label>
                        <input type="text" name="origin_school" value="{{ old('origin_school') }}" 
                               placeholder="Contoh: SMP Islam Al-Azhar BSD / SMPN 01 Serpong"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <!-- Alamat Lengkap -->
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Alamat Tempat Tinggal <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" required 
                                  placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, kota..."
                                  class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- SECTION B: DATA ORANG TUA / WALI -->
            <div class="space-y-5 pt-4">
                <div class="border-b border-[#E7E3EA] pb-3 flex items-center gap-3">
                    <span class="w-7 h-7 rounded-full bg-[#9377AD] text-white flex items-center justify-center font-bold text-xs shadow-xs">2</span>
                    <h2 class="text-base font-bold text-[#202124]">Data Orang Tua / Wali</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Nama Orang Tua / Wali <span class="text-red-500">*</span></label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}" required 
                               placeholder="Contoh: H. Agus Pratama, S.T."
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124] flex items-center justify-between">
                            <span>No. WhatsApp / HP Orang Tua <span class="text-red-500">*</span></span>
                            <span class="text-[11px] text-[#2A923F] font-semibold">Untuk Notifikasi PPDB</span>
                        </label>
                        <input type="tel" name="parent_phone" value="{{ old('parent_phone') }}" required 
                               placeholder="Contoh: 081299887766"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Pekerjaan Orang Tua</label>
                        <input type="text" name="parent_job" value="{{ old('parent_job') }}" 
                               placeholder="Contoh: Wiraswasta / Pegawai BUMN / Karyawan Swasta"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-[#202124]">Email Orang Tua (Opsional)</label>
                        <input type="email" name="student_email" value="{{ old('student_email') }}" 
                               placeholder="email@domain.com"
                               class="w-full px-4 py-2.5 rounded-xl border border-[#E7E3EA] text-sm text-[#202124] focus:outline-none focus:border-[#9377AD] focus:ring-2 focus:ring-[#9377AD]/20 transition-all bg-[#FAF8FC]">
                    </div>
                </div>
            </div>

            <!-- SECTION C: UNGGAH DOKUMEN BERKAS -->
            <div class="space-y-5 pt-4">
                <div class="border-b border-[#E7E3EA] pb-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-7 h-7 rounded-full bg-[#9377AD] text-white flex items-center justify-center font-bold text-xs shadow-xs">3</span>
                        <h2 class="text-base font-bold text-[#202124]">Unggah Berkas Pendukung</h2>
                    </div>
                    <span class="text-[11px] text-[#66676B]">Maksimal 2MB (JPG, PNG, PDF)</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Pas Foto -->
                    <div class="p-4 rounded-xl border border-dashed border-[#E7E3EA] bg-[#FAF8FC] space-y-1.5 hover:border-[#9377AD] transition-colors">
                        <label class="text-xs font-bold text-[#202124] block">Pas Foto Santri (Terbaru)</label>
                        <input type="file" name="student_photo_file" accept=".jpg,.jpeg,.png" 
                               class="w-full text-xs text-[#66676B] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#F4F0F7] file:text-[#684681] hover:file:bg-[#E3D9EC]">
                        <p class="text-[10px] text-[#66676B]">Format foto rapi berseragam.</p>
                    </div>

                    <!-- Kartu Keluarga -->
                    <div class="p-4 rounded-xl border border-dashed border-[#E7E3EA] bg-[#FAF8FC] space-y-1.5 hover:border-[#9377AD] transition-colors">
                        <label class="text-xs font-bold text-[#202124] block">Kartu Keluarga (KK)</label>
                        <input type="file" name="family_card_file" accept=".jpg,.jpeg,.png,.pdf" 
                               class="w-full text-xs text-[#66676B] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#F4F0F7] file:text-[#684681] hover:file:bg-[#E3D9EC]">
                        <p class="text-[10px] text-[#66676B]">Scan atau foto jelas KK asli.</p>
                    </div>

                    <!-- Akta Kelahiran -->
                    <div class="p-4 rounded-xl border border-dashed border-[#E7E3EA] bg-[#FAF8FC] space-y-1.5 hover:border-[#9377AD] transition-colors">
                        <label class="text-xs font-bold text-[#202124] block">Akta Kelahiran</label>
                        <input type="file" name="birth_certificate_file" accept=".jpg,.jpeg,.png,.pdf" 
                               class="w-full text-xs text-[#66676B] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#F4F0F7] file:text-[#684681] hover:file:bg-[#E3D9EC]">
                        <p class="text-[10px] text-[#66676B]">Scan atau foto jelas Akta Kelahiran.</p>
                    </div>

                    <!-- Piagam Prestasi -->
                    <div class="p-4 rounded-xl border border-dashed border-[#E7E3EA] bg-[#FAF8FC] space-y-1.5 hover:border-[#9377AD] transition-colors">
                        <label class="text-xs font-bold text-[#202124] block">Sertifikat / Piagam (Opsional)</label>
                        <input type="file" name="achievement_certificate_file" accept=".jpg,.jpeg,.png,.pdf" 
                               class="w-full text-xs text-[#66676B] file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#F4F0F7] file:text-[#684681] hover:file:bg-[#E3D9EC]">
                        <p class="text-[10px] text-[#66676B]">Piagam Tahfidz, MTQ, OSN, atau lomba lainnya.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-[#E7E3EA] flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-xs text-[#66676B]">
                    <svg class="w-4 h-4 text-[#2A923F] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <span>Dengan menekan tombol kirim, data yang Anda masukkan adalah benar dan dapat dipertanggungjawabkan.</span>
                </div>

                <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 rounded-full bg-[#2A923F] hover:bg-[#217333] text-white font-black text-sm uppercase tracking-wide transition-all shadow-md shrink-0">
                    KIRIM PENDAFTARAN SEKARANG
                </button>
            </div>
        </form>

    </div>
</section>
@endsection
