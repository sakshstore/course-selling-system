import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import App from "./App.vue";

import BootstrapVue3 from "bootstrap-vue-3";

import "bootstrap-vue-3/dist/bootstrap-vue-3.css";

import publicRoutes from "./routes/publicRoutes";
import authRoutes from "./routes/authRoutes";
import guideRoutes from "./routes/guideRoutes";
//import adminRoutes from "./routes/adminRoutes";

import Utils from "./Utils"; // Import the plugin

import { createVuetify } from "vuetify";
import "vuetify/styles";
import { aliases, mdi } from "vuetify/iconsets/mdi";

const vuetify = createVuetify({
    icons: {
        defaultSet: "mdi",
        aliases,
        sets: {
            mdi,
        },
    },
});

const routes = [...publicRoutes, ...authRoutes, ...guideRoutes];

// const routes = [ ...guideRoutes ];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const isAuthenticated = !!localStorage.getItem("auth");
    const userRoles = JSON.parse(localStorage.getItem("roles")) || [];

    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!isAuthenticated) {
            next("/");
        } else {
            handleRoleBasedRedirection(to, next, userRoles);
        }
    } else {
        next();
    }
});

function handleRoleBasedRedirection22(to, next, userRoles) {
    if (
        to.matched.some((record) => record.meta.requiresAdmin) &&
        !userRoles.includes("admin")
    ) {
        redirectToDashboard(to, next, "/admin/dashboard");
    } else if (
        to.matched.some((record) => record.meta.requiresGuide) &&
        !userRoles.includes("guide")
    ) {
        redirectToDashboard(to, next, "/guide/dashboard");
    } else if (
        to.matched.some((record) => record.meta.requiresGuest) &&
        !userRoles.includes("auth")
    ) {
        next();
    }
}

function handleRoleBasedRedirection(to, next, userRoles) {
    let role = "";

    if (to.matched.some((record) => record.meta.requiresAdmin)) {
        role = "admin";
    } else if (to.matched.some((record) => record.meta.requiresGuide)) {
        role = "guide";
    } else if (to.matched.some((record) => record.meta.requiresGuest)) {
        role = "auth";
    }

    if (
        (role === "admin" && userRoles.includes("admin")) ||
        (role === "guide" && userRoles.includes("guide")) ||
        (role === "auth" && userRoles.includes("auth"))
    ) {
        next(); // Allow navigation
    } else {
        next("/logout"); // Redirect to home or a default path
    }
}

function sss2redirectToDashboard(to, next, dashboardPath) {
    if (to.path !== dashboardPath) {
        next(dashboardPath);
    } else {
        next(false); // Prevent infinite loop
    }
}

const app = createApp(App);
app.use(router);
app.use(BootstrapVue3);

app.use(vuetify);
app.use(Utils);

app.mount("#app");
