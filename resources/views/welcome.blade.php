<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect/dist/vue-multiselect.min.css">

    
    <style>
       /* .nav-item {
            list-style: none;
        }

        .nav-link {

            color: white !important;
        }

        .nav-link:hover {

            color: white !important;
        }

        body{

            background-color: #161f32 !important;
            color: #fff !important;
          
        }
    .topbar,   .sidebar{
            
        background-color: #111827 !important;
        }*/


        
 
/* Navbar Styles */
.topbar {
    height: 56px;
    border-bottom: 1px solid #ccc;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background:  #1b2021;
}

.topbar .btn-outline-light {
    border-color: #fff;
    color: #fff;
}

.topbar .btn-outline-light:hover {
    background-color: #fff;
    color: #000;
}

/* Sidebar Styles */
.sidebar {
    margin-top: 56px;
    border-right: 1px solid #ccc;


    background:  #1b2021;
   
}

.sidebar .nav-link {
    color: #adb5bd;
    padding: 0.75rem 1rem;
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

/* Footer Styles */
.footer {
    height: 56px;
    background:  #1b2021;
    color: #fff;
}

/* Offcanvas Styles */
.offcanvas-body {
    padding: 1rem;
}

.offcanvas-body .nav-link {
    color: #adb5bd;
    padding: 0.5rem 1rem;
}

.offcanvas-body .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

/* Media Queries */
@media (max-width: 992px) {
    .sidebar {
        display: none;
    }

    .offcanvas {
        display: block;
    }

    .sakshwrapper {
        margin-left: 0;
        max-width: 100%;
    }
}

@media (min-width: 992px) {
    .sakshwrapper {
        margin-left: 250px;
        max-width: calc(100% - 250px);
    }
}



.sakshwrapper {
    padding-top: 100px;


}

body{
    
    background:   #1b2021;; 
}
</style>


    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>

<body>

    <div class="wrapper">

        <div id="app"></div>

    </div>

</body>

</html>