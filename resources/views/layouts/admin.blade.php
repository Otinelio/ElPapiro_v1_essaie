<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title') | El-Papiro</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <!-- Favicons -->
    <link href="{{ asset('admin/assets/img/othnelio.jpg') }}" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>

    {{-- header --}}
    @include('layouts.inc.admin.header')


    {{-- aside --}}
    @include('layouts.inc.admin.aside')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>@yield('title')</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Tableau de bord</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        {{-- section --}}
        @yield('section')

    </main><!-- End #main -->


    <!-- Vendor JS Files -->
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productImages = document.querySelectorAll('.product-image');
            const imageModal = document.createElement('div');
            imageModal.className = 'image-modal';
            imageModal.innerHTML = `
              <span class="image-modal-close">&times;</span>
              <div class="image-modal-content">
                  <img class="image-modal-img" src="" alt="Image agrandie">
              </div>
          `;
            document.body.appendChild(imageModal);

            const modalImg = imageModal.querySelector('.image-modal-img');
            const modalClose = imageModal.querySelector('.image-modal-close');

            productImages.forEach(img => {
                img.addEventListener('click', function () {
                    const fullImageSrc = this.getAttribute('data-full-image');
                    modalImg.src = fullImageSrc;
                    imageModal.style.display = 'flex';
                });
            });

            modalClose.addEventListener('click', function () {
                imageModal.style.display = 'none';
            });

            imageModal.addEventListener('click', function (e) {
                if (e.target === imageModal) {
                    imageModal.style.display = 'none';
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>