<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Material Dashboard Laravel - Free Frontend Preset for Laravel') }}
    </title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
        name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('material') }}/demo/demo.css" rel="stylesheet" />

    {{-- Datatable --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.semanticui.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
      span.select2-selection--multiple[aria-expanded=true] {
    border-color: blue !important;   
}
        .dataTables_filter {
            text-align: left !important;
            float: right !important;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
            line-height: -10px !important;
        }

        .select2-selection__arrow {
            height: 34px !important;
        }

        .select2-selection__rendered {
            line-height: 10px !important;
        }

        /* Box Peminjaman */
        .box-peminjaman {
            width: 200px;
            height: 200px;
            position: absolute;
            bottom: 5%;
            right: 50px;
            cursor: pointer;
            text-align: center;
            font-size: 40px;
            justify-content: center;
            line-height: 100px;
        }

        .navigator {
            width: 100px;
            height: 100px;
            position: absolute;
            right: 0;
            bottom: 0;
            background: #fcc603;
            border-radius: 100px;
            cursor: pointer;
            box-shadow: 0 0 10px green;
        }

        .navigator:hover {
            box-shadow: 0 0 15px #000;
        }

        .peminjaman {
            width: 60px;
            height: 60px;
            position: absolute;
            top: 50px;
            left: 30px;
            background: #fcc603;
            border-radius: 100px;
            cursor: pointer;
            text-align: center;
            font-size: 20px;
            justify-content: center;
            line-height: 60px;
            box-shadow: 0 0 10px green;
        }

        .pengembalian {
            width: 60px;
            height: 60px;
            position: absolute;
            top: 10px;
            left: 110px;
            background: #fcc603;
            border-radius: 100px;
            cursor: pointer;
            text-align: center;
            font-size: 20px;
            justify-content: center;
            line-height: 60px;
            box-shadow: 0 0 10px green;
        }

        .peminjaman:hover,
        .pengembalian:hover {
            box-shadow: 0 0 15px #000;
        }

    </style>
    @yield('style')
</head>

<body class="{{ $class ?? '' }}">
    @include('layouts.page_templates_user.auth', ['breadcrumbs' => $breadcrumbs ?? false, 'title' =>  $title ?? false, 'subTitle' => $subTitle ?? false, 'activeMainPage' => $activeMainPage ?? false, 'activePage' => $activePage ?? false])

    {{-- Modal Peminjaman --}}
    <div class="modal fade" id="peminjaman" tabindex="-1" role="dialog" aria-labelledby="peminjamanLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat Peminjaman Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="add-student-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-success d-none text-white" id="user-found">
                            </div>
                        </div>
                        <div class="col-8">
                            <input type="hidden" id="route-check" value="{{ route('check-user') }}">
                            <input type="text" id="user_number_check" class="form-control"
                                placeholder="Nomor atau nama siswa, guru" aria-label="Recipient's username"
                                aria-describedby="button-addon2">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-outline-secondary" type="button" id="btn-check-user">Check
                                Data</button>
                        </div>
                    </div>
                    <form id="form-pinjam-buku">@csrf
                        <div class="row mt-3">
                            <input type="hidden" id="route-pinjam" value="{{ route('new-order') }}">
                            <div class="col-12">
                                <label for="">Pilih Buku</label>
                                <input type="text" name="book_id" class="form-control">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="label-control">Tanggal Pengembalian</label>
                                <input type="text" name="end_date" autocomplete="off" class="form-control"
                                    id="datepicker" placeholder="21/06/2018" />
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-block" id="btn-pinjam"
                                    disabled>Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





























    {{-- Bootstrap --}}
    <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
    <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>

    {{-- Datatable --}}
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"> </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/dataTables.semanticui.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    {{-- Select 2 --}}
    <script src="{{ asset('js/peminjaman.js') }}"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true
            });
        });

        setTimeout(() => {
            $('#flash-message').hide();
        }, 2000)


        // Navigator
        let nav = false;
        $('.navigator').click(function () {
            if (nav == false) {
                $('.peminjaman, .pengembalian').removeClass('d-none').css({
                    'opacity': 0
                });
                setTimeout(() => {
                    $('.peminjaman, .pengembalian').css({
                        'opacity': 1,
                        'transition': '1s'
                    });
                }, 100)
                nav = true
            } else {
                $('.peminjaman, .pengembalian').addClass('d-none').css({
                    'opacity': 1
                });
                setTimeout(() => {
                    $('.peminjaman, .pengembalian').css({
                        'opacity': 0,
                        'transition': '1s'
                    });
                }, 100)
                nav = false
            }
        })


        // Get Component by Ajax
        function getComponent(component, route) {
            $(component).html('Sedang memuat ...')
            $.ajax({
                url: route,
                success: function (response) {
                    $(component).html(response)
                }
            })
        }



        function confirm_me(message, link) {
            swal({
                    title: "Apakah Kamu Yakin??",
                    text: message,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                        document.location.href = link;
                    }
                });
            setTimeout(function () {
                $('#flash').css({
                    'display': 'none'
                })
            }, 2000)
        }

        function infoSuccess(message) {
            swal("Good job!", message, "success");
        }

    </script>
    @yield('script')
</body>

</html>
