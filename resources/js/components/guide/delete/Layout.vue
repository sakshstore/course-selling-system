<template>
    <div>
        <!-- Top Bar -->
        <div
            class="topbar bg-dark d-flex layout justify-content-between align-items-center fixed-top p-2 mb-5 bg-gradient shadow-sm">
            <div class="d-flex align-items-center">
                <img src="https://startbootstrap.com/assets/img/sb-logo.svg" alt="Logo" width="30" height="30"
                    class="me-2">
                <span class="h5 text-light">Sakshamapp</span>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar d-none d-lg-block position-fixed top-0 start-0 vh-100  bg-dark text-light"
            style="width: 250px; margin-top: 56px;">
            <Sidebar />
        </div>

        <!-- Offcanvas Sidebar for Mobile -->
        <div class="offcanvas offcanvas-start bg-dark text-light" tabindex="-1" id="offcanvasSidebar"
            aria-labelledby="offcanvasSidebarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Sakshamapp</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <Sidebar />
            </div>
        </div>

        <!-- Main Content -->
        <div class="container mt-5 mb-5 pb-5 pt-10 mt-lg-0 sakshwrapper">


            <router-view></router-view>


        </div>


        <footer class="  text-center py-4  shadow-lg mt-5">

            <span class="text-light">© 2024 Sakshamapp. All rights reserved.    <router-link  :to="{ name: 'guideLoginHistory' }">
   Login History
    </router-link></span>

        </footer>



    </div>
</template>

<script>
import Sidebar from './Sidebar.vue';

export default {
    name: 'Layout',
    components: {
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

<style>
.sakshwrapper {
    padding-top: 70px;
    /* Adjust based on the height of your top bar */
}
</style>