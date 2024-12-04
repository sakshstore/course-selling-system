<template>
    <div>
        <!-- Top Bar -->
        <div class="topbar d-flex justify-content-between align-items-center fixed-top p-2  mb-5  ">
            <div class="d-flex align-items-center">
                <img src="https://startbootstrap.com/assets/img/sb-logo.svg" alt="Logo" width="30" height="30"
                    class="me-2">
                <span class="h5">Sakshamapp</span>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar d-none d-lg-block position-fixed top-0 start-0 vh-100 py-3  pb-5 "
            style="width: 250px; margin-top: 56px;">
            <Sidebar />
        </div>

        <!-- Offcanvas Sidebar for Mobile -->
        <div class="offcanvas offcanvas-start  " tabindex="-1" id="offcanvasSidebar"
            aria-labelledby="offcanvasSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Sakshamapp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <Sidebar />
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mt-5 mb-5  pb-5  pt-10 mt-lg-0 sakshwrapper">
            <router-view></router-view>
        </div>

        <!-- Footer -->
        <footer class="footer text-center py-3 mt-5">
            <div class="container">
                <span>© 2024 Sakshamapp. All rights reserved.</span>
            </div>
        </footer>
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import Sidebar from './Sidebar.vue';

export default {
    name: 'Layout',
    components: {
        Navbar,
        Sidebar
    },



    methods: {
        toggleMenu(menuId) {
            const menu = document.getElementById(menuId);
            if (menu) {
                menu.classList.toggle('show');
            }
        }
    }
};
</script>
