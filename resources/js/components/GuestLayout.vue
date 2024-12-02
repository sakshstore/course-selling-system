<template>
    <div>
        <!-- Header -->
        <header>
            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Sakshamapp</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <router-link class="nav-link active" aria-current="page"
                                    :to="{ name: 'GuestDashboard' }">Dashboard</router-link>
                            </li>


                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ name: 'GuestCourseList' }">Courses</router-link>
                            </li>



                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ name: 'GuestBuyCourseList' }">Courses List</router-link>
                            </li>

 
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ name: 'MyScore' }">My Score</router-link>
                            </li>


                            <li class="nav-item">
                                <router-link class="nav-link"
                                    :to="{ name: 'UserNotifications' }">Notifications</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link class="nav-link" :to="{ name: 'ListTickets' }">Support</router-link>
                            </li>


                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    aria-expanded="false">
                                    <i class="fas fa-user" aria-label="User Menu"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">


                                    <li>
                                        <router-link class="dropdown-item"
                                            :to="{ name: 'StudentProfile' }">Profile</router-link>
                                    </li>
                                    <li>
                                        <router-link class="dropdown-item" :to="{ name: 'authLoginHistory' }">Login
                                            History</router-link>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/logout">Log Out</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <!-- Main Content -->
        <div class="container-fluid mt-5 ">
            <router-view></router-view>
        </div>

        <!-- Footer -->
        <footer class="footer text-center py-3">
            <div class="container">
                <span>© 2024 Sakshamapp. All rights reserved.</span>
            </div>
        </footer>
    </div>
</template>

<style>
/* Add any additional styling here */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}
</style>