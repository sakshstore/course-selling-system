
<template>
    <nav class="nav flex-column">
    <ul class="nav flex-column">
    <!-- Dashboard -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'Dashboard' }">
    <i class="bi bi-house-door me-2"></i>Dashboard
    </router-link>
    </li>
    
    <!-- Courses -->
    <li class="nav-item">
    <a class="nav-link" data-bs-toggle="collapse" href="#coursesMenu" role="button" aria-expanded="false" aria-controls="coursesMenu">
    <i class="bi bi-book-fill me-2"></i>Courses
    </a>
    <div class="collapse" id="coursesMenu">
    <ul class="nav flex-column ms-3">
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'CourseList' }">List All Courses</router-link>
    </li>
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'VideoList' }">Video List</router-link>
    </li>
    </ul>
    </div>
    </li>
    
    <!-- Students -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'StudentsList' }">
    <i class="bi bi-people me-2"></i>Students
    </router-link>
    </li>
    
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'LeaderboardComponent' }">
    <i class="bi bi-person-badge-fill me-2"></i>Leads
    </router-link>
    </li>
    
    <!-- Campaigns -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'ListCampaigns' }">
    <i class="bi bi-megaphone-fill me-2"></i>Campaigns
    </router-link>
    </li>
    
    <!-- Support Tickets -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'AdminTicketList' }">
    <i class="bi bi-ticket-perforated-fill me-2"></i>Support Tickets
    </router-link>
    </li>
    
    <!-- Discussions -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'GuideChat' }">
    <i class="bi bi-chat-dots-fill me-2"></i>Discussions
    </router-link>
    </li>
    
    
    <!-- Profile -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'Profile' }">
    <i class="bi bi-person-circle me-2"></i>Profile
    </router-link>
    </li>
    
   
    
    <!-- Settings -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'SettingsComponent' }">
    <i class="bi bi-gear-fill me-2"></i>Settings
    </router-link>
    </li>
    
    <!-- Badges -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'BadgesComponent' }">
    <i class="bi bi-award-fill me-2"></i>Badges
    </router-link>
    </li>
    
    <!-- Events Score -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'EventsScore' }">
    <i class="bi bi-calendar-event-fill me-2"></i>Events Score
    </router-link>
    </li>
    
    <!-- Login History -->
    <li class="nav-item">
    <router-link class="nav-link" :to="{ name: 'guideLoginHistory' }">
    <i class="bi bi-clock-history me-2"></i>Login History
    </router-link>
    </li>
    
    <!-- Log Out -->
    <li class="nav-item">
    <a class="nav-link" href="/logout">
    <i class="bi bi-box-arrow-right me-2"></i>Log Out
    </a>
    </li>
    </ul>
    </nav>
    </template>
    
    <script>
    export default {
    name: 'Sidebar',
    };
    </script>
    
    <style scoped>
    /* Add any additional styling here */
    </style>