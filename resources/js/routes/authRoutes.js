import GuestLayout from "@/components/guest/GuestLayout.vue";
import GuestDashboard from "@/components/guest/GuestDashboard.vue";
import Profile from "@/components/guest/Profile.vue";
import GuestCourseList from "@/components/guest/GuestCourseList.vue";
import GuestBuyCourseList from "@/components/guest/GuestBuyCourseList.vue";
//import Chat from "@/components/guest/Chat.vue";
import GuestCourseDetails from "@/components/guest/GuestCourseDetails.vue";
import GuestBuyCourseDetails from "@/components/guest/GuestBuyCourseDetails.vue";
import GuestPlayList from "@/components/guest/GuestPlayList.vue";
import UserActivity from "@/components/guest/UserActivity.vue";
import UserNotifications from "@/components/guest/UserNotifications.vue";
import VideoGallery from "@/components/guest/VideoGallery.vue";
import ReferralsCenter from "@/components/guest/ReferralsCenter.vue";
import LoginHistory from "@/components/guest/LoginHistory.vue";
import MyScore from "@/components/guest/MyScore.vue";
import CourseVideoGallery from "@/components/guest/CourseVideoGallery.vue";
import ListTickets from "@/components/guest/ListTickets.vue";
import TicketDetails from "@/components/guest/TicketDetails.vue";

const authRoutes = [
    {
        path: "/auth",
        component: GuestLayout,
        meta: { requiresAuth: true, requiresGuest: true },
        children: [
            {
                path: "dashboard",
                name: "GuestDashboard",
                component: GuestDashboard,
            },
            { path: "profile", name: "StudentProfile", component: Profile },
            {
                path: "my/courses",
                name: "GuestCourseList",
                component: GuestCourseList,
            },
            {
                path: "courses",
                name: "GuestBuyCourseList",
                component: GuestBuyCourseList,
            },
//{ path: "chat", name: "Chat", component: Chat },
            {
                path: "my/courses/:id",
                name: "GuestCourseDetails",
                component: GuestCourseDetails,
            },
            {
                path: "courses/:id",
                name: "GuestBuyCourseDetails",
                component: GuestBuyCourseDetails,
            },
            {
                path: "courses/:id/playlist/:playlistId",
                name: "GuestPlayList",
                component: GuestPlayList,
            },
            {
                path: "user-activities",
                name: "UserActivity",
                component: UserActivity,
            },
            {
                path: "user-notifications",
                name: "UserNotifications",
                component: UserNotifications,
            },
            {
                path: "video-gallery",
                name: "VideoGallery",
                component: VideoGallery,
            },
            {
                path: "referrals-center",
                name: "ReferralsCenter",
                component: ReferralsCenter,
            },
            {
                path: "login-history",
                name: "authLoginHistory",
                component: LoginHistory,
            },
            { path: "my-score", name: "MyScore", component: MyScore },
            {
                path: "courses/:course_id/video-gallery",
                name: "CourseVideoGallery",
                component: CourseVideoGallery,
            },
            { path: "tickets", name: "ListTickets", component: ListTickets },
            {
                path: "ticket/:id",
                name: "authTicketDetails",
                component: TicketDetails,
            },
        ],
    },
];

export default authRoutes;
