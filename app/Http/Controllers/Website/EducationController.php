<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Halaman Utama / Home Education Portal.
     */
    public function index()
    {
        return view('website.education.home-page-1');
    }

    /**
     * Halaman Program Studi & Akademik.
     */
    public function programs()
    {
        return view('website.education.page-programs-1');
    }

    /**
     * Halaman Calon Mahasiswa (Future Students).
     */
    public function futureStudents()
    {
        return view('website.education.page-future-students-1');
    }

    /**
     * Halaman Mahasiswa Aktif (Current Students).
     */
    public function currentStudents()
    {
        return view('website.education.page-current-students-1');
    }

    /**
     * Halaman Dosen & Staf (Faculty & Staff).
     */
    public function facultyAndStaff()
    {
        return view('website.education.page-faculty-and-staff-1');
    }

    /**
     * Halaman Acara & Berita (Events).
     */
    public function events()
    {
        return view('website.education.page-events-1');
    }

    /**
     * Halaman Alumni & Jejaring.
     */
    public function alumni()
    {
        return view('website.education.page-alumni-1');
    }

    /**
     * Halaman Kehidupan Kampus (Campus Life).
     */
    public function campusLife()
    {
        return view('website.education.page-campus-life-1');
    }

    /**
     * Halaman Riset & Inovasi (Research).
     */
    public function research()
    {
        return view('website.education.page-research-1');
    }

    /**
     * Halaman Pendaftaran & Registrasi (Apply).
     */
    public function apply()
    {
        return view('website.education.page-apply-1');
    }

    /**
     * Halaman Kontak & Lokasi Kampus (Contacts).
     */
    public function contacts()
    {
        return view('website.education.page-contacts-1');
    }

    /**
     * Halaman Pusat Bantuan & Aksesibilitas (Help).
     */
    public function help()
    {
        return view('website.education.page-help-1');
    }

    /**
     * Halaman Detail Blog / Artikel.
     */
    public function blogDetail()
    {
        return view('website.education.page-blog-single-item-1');
    }
}
