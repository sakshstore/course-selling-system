import GuestLogin from "@/components/public/GuestLogin.vue";
import GuideLogin from "@/components/public/GuideLogin.vue";
import AdminLogin from "@/components/public/AdminLogin.vue";

const publicRoutes = [
    { path: "/", name: "GuestLogin", component: GuestLogin },
    { path: "/guide", name: "GuideLogin", component: GuideLogin },
    { path: "/admin", name: "AdminLogin", component: AdminLogin },
];

export default publicRoutes;
