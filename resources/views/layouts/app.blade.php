<!doctype html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Perpus Mini</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
        <style>
                body{font-family:Arial,Helvetica,sans-serif;margin:0}
                .content-wrapper{padding:24px}
        </style>
</head>
<body class="hold-transition sidebar-mini">
        <div class="wrapper">
                <!-- Main Sidebar Container -->
                <aside class="main-sidebar sidebar-dark-primary elevation-4">
                    <!-- Brand Logo -->
                    <a href="/" class="brand-link">
                        <span class="brand-image img-circle elevation-3" style="display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;background:rgba(255,255,255,0.1);">
                                <i class="fas fa-book" style="font-size:20px;color:#fff"></i>
                        </span>
                        <span class="brand-text font-weight-light">Perpus Mini</span>
                    </a>

                    <!-- Sidebar -->
                    <div class="sidebar">
                        <!-- Sidebar user panel -->
                        @auth
                        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                            <div class="image">
                                <img src="https://www.gravatar.com/avatar/?d=mp&s=160" class="img-circle elevation-2" alt="User Image">
                            </div>
                            <div class="info">
                                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                            </div>
                        </div>
                        @endauth

                        <!-- Sidebar Menu -->
                        <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                                <li class="nav-item">
                                    <a href="/" class="nav-link {{ request()->is('/') || request()->is('books*') ? 'active' : '' }}">
                                        <i class="nav-icon fas fa-book"></i>
                                        <p>Daftar Buku</p>
                                    </a>
                                </li>
                                @auth
                                        @if(auth()->user()->role === 'admin')
                                                <li class="nav-item">
                                                    <a href="/admin/books" class="nav-link {{ request()->is('admin/books*') ? 'active' : '' }}">
                                                        <i class="nav-icon fas fa-th"></i>
                                                        <p>Kelola Buku</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/admin/borrowings" class="nav-link {{ (request()->is('admin/borrowings') || (request()->is('admin/borrowings/*') && !request()->is('admin/borrowings/history'))) ? 'active' : '' }}">
                                                        <i class="nav-icon fas fa-hand-holding"></i>
                                                        <p>Peminjaman (Masuk)</p>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="/admin/borrowings/history" class="nav-link {{ request()->is('admin/borrowings/history') ? 'active' : '' }}">
                                                        <i class="nav-icon fas fa-history"></i>
                                                        <p>Riwayat Peminjaman</p>
                                                    </a>
                                                </li>
                                        @else
                                                <li class="nav-item">
                                                    <a href="/borrowings/history" class="nav-link {{ request()->is('borrowings/history') ? 'active' : '' }}">
                                                        <i class="nav-icon fas fa-history"></i>
                                                        <p>Riwayat</p>
                                                    </a>
                                                </li>
                                        @endif
                                        <li class="nav-item mt-3">
                                            <form method="POST" action="/logout">
                                                @csrf
                                                <button class="btn btn-danger btn-block">Logout</button>
                                            </form>
                                        </li>
                                @else
                                        <li class="nav-item">
                                            <a href="/login" class="nav-link">
                                                <i class="nav-icon fas fa-sign-in-alt"></i>
                                                <p>Login</p>
                                            </a>
                                        </li>
                                @endauth
                            </ul>
                        </nav>
                        <!-- /.sidebar-menu -->
                    </div>
                    <!-- /.sidebar -->
                </aside>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                        <div class="content-header">
                                <div class="container-fluid">
                                        <div class="row mb-2">
                                                <div class="col-sm-6">
                                                        <h1 class="m-0">@yield('title')</h1>
                                                </div>
                                        </div>
                                </div>
                        </div>

                        <section class="content">
                                <div class="container-fluid">
                                        @yield('content')
                                </div>
                        </section>
                </div>

        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
</body>
</html>
