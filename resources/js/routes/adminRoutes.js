import AdminLayout from "@/components/admin/AdminLayout.vue";
import Dashboard from "@/components/admin/Dashboard.vue";
import UserManagement from "@/components/admin/UserManagement.vue";
import UserDetail from "@/components/admin/UserDetail.vue";

const adminRoutes = [
    {
        path: "/admin",
        component: AdminLayout,
        meta: { requiresAuth: true, requiresAdmin: true },
        children: [
            { path: "dashboard", name: "AdminDashboard", component: Dashboard },
            {
                path: "users",
                name: "UserManagement",
                component: UserManagement,
            },
            { path: "users/:id", name: "UserDetail", component: UserDetail },
        ],
    },
];

export default adminRoutes;
