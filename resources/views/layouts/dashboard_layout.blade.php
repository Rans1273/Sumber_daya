<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        :root{
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 0px;
            --transition-speed: 350ms;
            --navbar-height: 56px;
        }

        .layout {
            padding-left: var(--sidebar-width);
            transition: padding-left var(--transition-speed) cubic-bezier(.2,.8,.2,1); 
        }

        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            bottom: 0;
            width: var(--sidebar-width);
            background: #0b0b0b;
            transition: width var(--transition-speed) cubic-bezier(.2,.8,.2,1);
            border-right: 1px solid rgba(255,255,255,0.08);
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1020;
        }

        .sidebar .sidebar-inner {
            padding: 1.25rem;
            height: 100%;
            box-sizing: border-box;
            color: #fff;
            transition: opacity 200ms;
        }

        body.collapsed-sidebar {
            --sidebar-width: var(--sidebar-collapsed-width);
        }

        body.collapsed-sidebar .layout {
            padding-left: var(--sidebar-collapsed-width); 
        }

        body.collapsed-sidebar .sidebar .sidebar-inner {
            opacity: 0;
            pointer-events: none;
        }

        .main {
            transition: all var(--transition-speed) cubic-bezier(.2,.8,.2,1);
            min-width: 0;
            background: transparent;
            min-height: 90vh;
        }

        .main-inner {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 18px;
            transition: margin var(--transition-speed);
        }

        .hamburger {
            width: 42px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: none;
            padding: 0;
            margin-right: 8px;
        }

        .hamburger .bar {
            display: block;
            width: 22px;
            height: 2px;
            background: #ffffff;
            position: relative;
            transition: transform 0.25s ease, opacity 0.25s ease;
        }

        .hamburger .bar::before,
        .hamburger .bar::after {
            content: "";
            position: absolute;
            left: 0;
            width: 22px;
            height: 2px;
            background: #ffffff;
            transition: transform 0.25s ease, top 0.25s ease, bottom 0.25s ease;
        }

        .hamburger .bar::before { 
            top: -7px; 
        }

        .hamburger .bar::after  { 
            bottom: -7px; 
        }

        .hamburger.open .bar {
            background: transparent;
        }

        .hamburger.open .bar::before{
            transform: translateY(7px) rotate(45deg);
        }

        .hamburger.open .bar::after{
            transform: translateY(-7px) rotate(-45deg);
        }

        @media (max-width: 767.98px) {
            .layout {
                padding-left: 0;
            }

            .sidebar {
                top: 56px;
                z-index: 1045;
                transform: translateX(-100%);
                width: 260px; 
                transition: transform var(--transition-speed) cubic-bezier(.2,.8,.2,1);
            }

            body.show-mobile-sidebar .sidebar {
                transform: translateX(0);
            }

            body.collapsed-sidebar .sidebar {
                transform: translateX(-100%);
            }

            .main {
                
            }

            .mobile-overlay {
                display: none;
            }

            body.show-mobile-sidebar .mobile-overlay {
                display: block;
                position: fixed;
                inset: 56px 0 0 0;
                background: rgba(0,0,0,0.45);
                z-index: 1040;
                transition: opacity var(--transition-speed);
            }
        }

        .sidebar::-webkit-scrollbar{ 
            width:8px; 
        }

        .sidebar::-webkit-scrollbar-thumb{ 
            background: rgba(255,255,255,0.06); 
            border-radius:6px; 
        }
    </style>
</head>

<body class="bg-dark text-white" style="font-family: Arial, sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1030;">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <button id="btnToggle" class="hamburger" aria-label="Toggle sidebar" title="Toggle sidebar">
                    <span class="bar"></span>
                </button>
                <a class="navbar-brand fw-bold ms-1" href="#">DATA BULUNGAN</a>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ps-2">
                    <li class="nav-item"><a class="nav-link" href="#">JELAJAHI</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">CERITA</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">TENTANG</a></li>
                </ul>
                <a href="#" class="btn btn-danger">LOGOUT</a>
            </div>
        </div>
    </nav>

    <div style="padding-top: 56px;"> 
        <aside class="sidebar" role="navigation" aria-label="Sidebar menu">
            <div class="sidebar-inner">
                <ul class="nav flex-column">

                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#DPMPTSP" aria-expanded="false">
                            DPMPTSP Provinsi Kalimantan Utara di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="DPMPTSP">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#ESDM" aria-expanded="false">
                            ESDM Provinsi Kalimantan Utara di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="ESDM">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#KEHUTANAN" aria-expanded="false">
                            Dinas Kehutanan Provinsi Kalimantan Utara di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="KEHUTANAN">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#PUPR" aria-expanded="false">
                            DPUPR Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="PUPR">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#DPMPTSPKab" aria-expanded="false">
                            DPMPTSP Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="DPMPTSPKab">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#PERTANIAN" aria-expanded="false">
                            Dinas Pertanian Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="PERTANIAN">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#PERIKANAN" aria-expanded="false">
                            Dinas Perikanan Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="PERIKANAN">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#DISKOPERINDAG" aria-expanded="false">
                            DISKOPERINDAG Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="DISKOPERINDAG">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button
                            class="btn btn-toggle align-items-center rounded collapsed text-white w-100 text-start"
                            data-bs-toggle="collapse" data-bs-target="#PANGAN" aria-expanded="false">
                            Dinas Ketahanan Pangan Kabupaten Bulungan di Tanjung Selor
                        </button>
                        <div class="collapse ps-3" id="PANGAN">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="#" class="nav-link text-white">data</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="mobile-overlay" id="mobileOverlay" style="display:none;"></div>

        <div class="layout">
            <main class="main" role="main">
                <div class="main-inner">
                    @yield('content', 'Konten utama di sini...')
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-dark text-center py-3 border-top border-secondary mt-auto">
        <p class="mb-0">&copy; 2025 SDA Bulungan</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function(){
            const body = document.body;
            const btn = document.getElementById('btnToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mq = window.matchMedia('(max-width: 767.98px)');

            function isMobile(){ return mq.matches; }

            function toggleSidebar(){
                if(isMobile()){
                    body.classList.toggle('show-mobile-sidebar');
                    const showing = body.classList.contains('show-mobile-sidebar');
                    mobileOverlay.style.display = showing ? 'block' : 'none';
                    btn.classList.toggle('open', showing);
                } else {
                    body.classList.toggle('collapsed-sidebar');
                    const collapsed = body.classList.contains('collapsed-sidebar');
                    // Hamburger state should be 'open' when sidebar is NOT visible (collapsed)
                    btn.classList.toggle('open', !collapsed); 
                }
            }

            mobileOverlay.addEventListener('click', () => {
                body.classList.remove('show-mobile-sidebar');
                mobileOverlay.style.display = 'none';
                btn.classList.remove('open');
            });
            
            btn.addEventListener('click', toggleSidebar);

            mq.addListener((e) => {
                if(!e.matches){
                    body.classList.remove('show-mobile-sidebar');
                    mobileOverlay.style.display = 'none';
                    btn.classList.toggle('open', !body.classList.contains('collapsed-sidebar'));
                } else { 
                    body.classList.remove('collapsed-sidebar');
                    btn.classList.remove('open');
                }
            });

            function setInitialState(){
                if (isMobile()) {
                    btn.classList.remove('open');
                } else {
                    btn.classList.add('open');
                }
            }
            
            setInitialState();
        })();
    </script>
</body>
</html>