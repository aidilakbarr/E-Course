@extends('layouts.userLayout')

@section('title', 'Home')

@section('content')

    <!-- ================ start banner Area ================= -->
    <section class="home-banner-area">
        <div class="container">
            <div class="row justify-content-center fullscreen align-items-center">
                <div class="col-lg-5 col-md-8 home-banner-left">
                    <h1 class="text-white">
                        Belajar Lebih Mudah,
                        Kapan Saja, Di Mana Saja
                    </h1>
                    <p class="mx-auto text-white mt-20 mb-40">
                        Platform e-learning interaktif yang membantumu berkembang dengan materi terbaru, mentor
                        berpengalaman, dan akses tanpa batas.
                    </p>
                </div>
                <div class="offset-lg-2 col-lg-5 col-md-12 home-banner-right">
                    <img class="img-fluid" src="img/header-img.png" alt="" />
                </div>
            </div>
        </div>
    </section>
    <!-- ================ End banner Area ================= -->

    <!-- ================ Start Feature Area ================= -->
    <section class="feature-area">
        <div class="container-fluid">
            <div class="feature-inner row">
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex">
                        <i class="ti-book"></i>
                        <div class="ml-20">
                            <h4>Kelas Terbaru</h4>
                            <p>
                                Akses berbagai kelas terbaru dengan materi yang selalu diperbarui dan sesuai kebutuhan
                                industri.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex">
                        <i class="ti-cup"></i>
                        <div class="ml-20">
                            <h4>Kursus Unggulan</h4>
                            <p>
                                Pilih dari deretan kursus paling populer dan favorit, diajarkan oleh instruktur
                                berpengalaman.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="feature-item d-flex border-right-0">
                        <i class="ti-desktop"></i>
                        <div class="ml-20">
                            <h4>E-Book Lengkap</h4>
                            <p>
                                Dapatkan akses ke e-book pendukung pembelajaran yang lengkap, praktis, dan mudah dipahami.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ End Feature Area ================= -->

    <!-- ================ Start Popular Course Area ================= -->
    <section class="popular-course-area section-gap">
        <div class="container-fluid">
            <div class="row justify-content-center section-title">
                <div class="col-lg-12">
                    <h2>
                        Kursus Populer <br />
                        Tersedia Saat Ini
                    </h2>
                    <p>
                        Pilih dari berbagai kursus unggulan kami yang dirancang untuk membantu Anda belajar secara efektif
                        dan fleksibel.
                    </p>
                </div>
            </div>
            <div class="owl-carousel popuar-course-carusel">
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p1.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>

                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>
                <div class="single-popular-course">
                    <div class="thumb">
                        <img class="f-img img-fluid mx-auto" src="img/popular-course/p2.jpg" alt="" />
                    </div>
                    <div class="details">
                        <div class="d-flex justify-content-between mb-20">
                            <p class="name">Bahasa Pemrograman</p>
                            <p class="value">Rp2.250.000</p>
                        </div>
                        <a href="#">
                            <h4>Pelajari Kursus Angular JS untuk Tingkat Lanjut</h4>
                        </a>
                        <div class="bottom d-flex mt-15">
                            <ul class="list">
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                            </ul>
                            <p class="ml-20">25 Ulasan</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <!-- ================ End Popular Course Area ================= -->

    <!-- ================ Start Video Area ================= -->
    <section class="video-area section-gap-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="section-title text-white">
                        <h2 class="text-white">
                            Saksikan Pelatih Kami <br />
                            dalam Aksi Langsung
                        </h2>
                        <p>
                            Dapatkan pengalaman belajar yang lebih nyata dengan menyaksikan langsung bagaimana instruktur
                            kami mengajar dan menjelaskan materi melalui video interaktif.
                        </p>
                    </div>
                </div>
                <div class="offset-lg-1 col-md-6 video-left">
                    <div class="owl-carousel video-carousel">
                        <div class="single-video">
                            <div class="video-part">
                                <img class="img-fluid" src="img/video-img.jpg" alt="" />
                                <div class="overlay"></div>
                                <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                    <img class="play-icon" src="img/play-btn.png" alt="" />
                                </a>
                            </div>
                            <h4 class="text-white mb-20 mt-30">
                                Pelajari Kursus Angular JS dari Ahlinya
                            </h4>
                            <p class="text-white mb-20">
                                Tonton bagaimana instruktur kami menjelaskan konsep Angular JS secara praktis dan mudah
                                dipahami, langsung dari layar Anda.
                            </p>
                        </div>

                        <div class="single-video">
                            <div class="video-part">
                                <img class="img-fluid" src="img/video-img.jpg" alt="" />
                                <div class="overlay"></div>
                                <a class="popup-youtube play-btn" href="https://www.youtube.com/watch?v=VufDd-QL1c0">
                                    <img class="play-icon" src="img/play-btn.png" alt="" />
                                </a>
                            </div>
                            <h4 class="text-white mb-20 mt-30">
                                Pelajari Kursus Angular JS dari Ahlinya
                            </h4>
                            <p class="text-white mb-20">
                                Tonton bagaimana instruktur kami menjelaskan konsep Angular JS secara praktis dan mudah
                                dipahami, langsung dari layar Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ End Video Area ================= -->

    <!-- ================ Start Feature Area ================= -->
    <section class="other-feature-area">
        <div class="container">
            <div class="feature-inner row">
                <div class="col-lg-12">
                    <div class="section-title text-left">
                        <h2>
                            Fitur yang <br />
                            Bisa Diakses oleh Semua Orang
                        </h2>
                        <p>
                            Platform kami dirancang untuk mendukung pembelajaran siapa pun, kapan pun, dan di mana pun
                            secara fleksibel dan efisien.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-key"></i>
                        <h4>Akses Seumur Hidup</h4>
                        <div>
                            <p>
                                Nikmati akses ke semua materi pembelajaran selamanya, tanpa batas waktu atau biaya tambahan.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-files"></i>
                        <h4>File Sumber Disertakan</h4>
                        <div>
                            <p>
                                Unduh file pendukung seperti kode program, modul, dan materi tambahan untuk praktik
                                langsung.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-medall-alt"></i>
                        <h4>Keanggotaan Mahasiswa</h4>
                        <div>
                            <p>
                                Dapatkan keuntungan eksklusif bagi pelajar dan mahasiswa, termasuk diskon kursus dan akses
                                komunitas belajar.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="other-feature-item">
                        <i class="ti-briefcase"></i>
                        <h4>35.000+ Kursus</h4>
                        <div>
                            <p>
                                Pilih dari ribuan kursus dalam berbagai bidang, mulai dari teknologi, bisnis, desain, hingga
                                pengembangan diri.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt--160">
                    <div class="other-feature-item">
                        <i class="ti-crown"></i>
                        <h4>Mentor Ahli</h4>
                        <div>
                            <p>
                                Belajar langsung dari para mentor profesional dan praktisi industri berpengalaman di
                                bidangnya.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mt--260">
                    <div class="other-feature-item">
                        <i class="ti-headphone-alt"></i>
                        <h4>Dukungan Langsung</h4>
                        <div>
                            <p>
                                Tim kami siap membantu Anda melalui live chat atau email kapan saja saat Anda membutuhkan
                                bantuan belajar.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ End Feature Area ================= -->

    <!-- ================ Start Testimonials Area ================= -->
    <section class="testimonials-area section-gap">
        <div class="container">
            <div class="testi-slider owl-carousel" data-slider-id="1">

                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="item">
                            <div class="testi-item">
                                <img src="img/quote.png" alt="" />
                                <div class="mt-40 text">
                                    <p>
                                        Belajar di platform ini sangat membantu saya memahami konsep pemrograman dengan
                                        lebih mudah. Materinya lengkap dan mentornya sangat responsif.
                                    </p>
                                </div>
                                <h4>Fanny Spencer</h4>
                                <p>Software Engineer, Amazon</p>
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-lg-6">
                        <img src="img/testimonial/t1.jpg" alt="Testimoni Fanny Spencer" />
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="item">
                            <div class="testi-item">
                                <img src="img/quote.png" alt="" />
                                <div class="mt-40 text">
                                    <p>
                                        Platform e-learning ini membuat saya bisa belajar kapan saja. Saya menyukai
                                        fleksibilitasnya dan adanya akses ke e-book dan video interaktif.
                                    </p>
                                </div>
                                <h4>Rina Wijaya</h4>
                                <p>Mahasiswa, Universitas Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-lg-6">
                        <img src="img/testimonial/t1.jpg" alt="Testimoni Rina Wijaya" />
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================ End Testimonials Area ================= -->

    <!-- ================ Start Registration Area ================= -->
    <section class="registration-area">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-5">
                    <div class="section-title text-left text-white">
                        <h2 class="text-white">
                            Saksikan Pengajar Kami <br />
                            dalam Aksi Langsung
                        </h2>
                        <p>
                            Dapatkan gambaran langsung bagaimana para instruktur profesional membimbing proses belajar
                            secara interaktif dan menyenangkan.
                        </p>
                    </div>
                </div>
                <div class="offset-lg-3 col-lg-4 col-md-6">
                    <div class="course-form-section">
                        <h3 class="text-white">Kursus Gratis</h3>
                        <p class="text-white">Saatnya mulai belajar hari ini</p>
                        <form class="course-form-area contact-page-form course-form text-right" id="myForm"
                            action="mail.html" method="post">
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nama" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Nama'" />
                            </div>
                            <div class="form-group col-md-12">
                                <input type="text" class="form-control" id="subject" name="subject"
                                    placeholder="Nomor Telepon" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Nomor Telepon'" />
                            </div>
                            <div class="form-group col-md-12">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Alamat Email" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Alamat Email'" />
                            </div>
                            <div class="col-lg-12 text-center">
                                <button class="btn text-uppercase">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================ End Registration Area ================= -->


@endsection
