<template>
    <div>
        <!-- Header -->
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-lg">
                <div class="container">
                    <router-link class="navbar-brand d-flex align-items-center" aria-current="page"
                        :to="{ name: 'GuestDashboard' }">
                        <img :src="settings.companyLogo" alt="Company Logo" height="30" class="me-2">
                        <span class="fw-bold text-gradient">{{ settings.companyName }}</span>
                    </router-link>
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
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user" aria-label="User Menu"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <router-link class="dropdown-item"
                                            :to="{ name: 'StudentProfile' }">Edit Profile</router-link>
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
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">

                    <router-view></router-view>

                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="  text-center py-4  shadow-lg mt-5">

            <span>  {{ settings.footerText	 }} </span>
            <div>
                <a :href="settings.facebook" target="_blank" class="text-light footer-link">Facebook</a> |
                <a :href="settings.twitter" target="_blank" class="text-light footer-link">Twitter</a> |
                <a :href="settings.instagram" target="_blank" class="text-light footer-link">Instagram</a> |
                <a :href="settings.youtube" target="_blank" class="text-light footer-link">YouTube</a> |
                <a :href="settings.snapchat" target="_blank" class="text-light footer-link">Snapchat</a>
            </div>


        </footer>
    </div>
</template>

<script>
import apiService from '@/apiGuestService.js';
import { useToast } from 'vue-toastification';
import { onMounted } from 'vue';

export default {
    data() {
        return {
            settings: {
                companyName: '',
                companyLogo: '',
                facebook: '',
                twitter: '',
                instagram: '',
                youtube: '',
                snapchat: ''
            }
        };
    },
    created() {
        this.fetchSettings();
    },
    setup() {
        const toast = useToast();

        const showNotification = () => {
            toast.info('Welcome! Happy Learning!');
        };

        // Show notification on component load
        onMounted(() => {
            showNotification();
        });

        return {
            showNotification,
        };
    },
    methods: {
        async fetchSettings() {
            try {
                const response = await apiService.getSettings();
                this.settings = response.data;
            } catch (error) {
                console.error('Error fetching settings:', error);
            }
        }
    }
};
</script>

<style>
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
}

.text-gradient {
    background: linear-gradient(45deg, #ff6b6b, #f06595, #cc5de8, #845ef7, #5c7cfa, #339af0, #22b8cf, #20c997, #51cf66, #94d82d, #fcc419, #ff922b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}

.nav-link:hover {


    transition: color 0.3s;
}

.footer-link:hover {


    transition: color 0.3s;
}
</style>