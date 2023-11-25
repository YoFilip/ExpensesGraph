<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="./scrollbar.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    
    <!--Charts.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@1.0.0/dist/chartjs-plugin-zoom.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>


</head>

<body>

    <section class="sidebar">
        <div class="nav-header">
            <p class="logo">TU <span>NAZWA</span> </p>
            <i class="bx bx-menu btn-menu"></i>
        </div>
        <ul class="nav-links">
            <li>
                <i class="bx bx-search search-btn"></i>
                <input type="text" id="searchInput" placeholder="Wyszukaj..." />
                <span class="tooltip">Search...</span>
            </li>


            <li class="dropdown">
                <a href="index.php">
                    <i class='bx bx-home-alt-2'></i>
                    <span class="title">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>

            <div class="theme-wrapper">
                <i class="bx bxs-moon theme-icon"></i>
                <p>Dark Mode</p>
                <div class="theme-btn">
                    <span class="theme-ball"></span>
                </div>
            </div>
    </section>

    <div id="main">
        <div class="item">
        <canvas id="myChart" ></canvas>
        </div>
        <div class="item">
            <h1>Element 2</h1>
        </div>
        <div class="item">
            <h1>Element 3</h1>
        </div>
        <div class="item">
            <h1>Element 4</h1>
        </div>
    </div>

</body>
<script src="./js/menu.js"></script>
<script src="./js/charts.js"></script>
</html>