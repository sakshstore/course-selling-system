import Layout from "@/components/guide/Layout.vue";
import LeadBoard from "@/components/guide/LeadBoard.vue";
import Dashboard from "@/components/guide/Dashboard.vue";
//import ContactList from "@/components/guide/ContactList.vue";
//import ContactForm from "@/components/guide/ContactForm.vue";
import LeadList from "@/components/guide/LeadList.vue";
import LeadForm from "@/components/guide/LeadForm.vue";
import Profile from "@/components/guide/Profile.vue";
import CreateTicket from "@/components/guide/CreateTicket.vue";
import AdminTicketList from "@/components/guide/AdminTicketList.vue";
import AdminTicketDetails from "@/components/guide/AdminTicketDetails.vue";
import Chat from "@/components/guide/Chat.vue";


import CreateCampaign from "@/components/guide/CreateCampaign.vue";
import ListCampaigns from "@/components/guide/ListCampaigns.vue";
import ViewCampaign from "@/components/guide/ViewCampaign.vue";
 
    
 
import CourseList from "@/components/guide/CourseList.vue";
import CourseForm from "@/components/guide/CourseForm.vue";
import StudyMaterials from "@/components/guide/StudyMaterials.vue";


import Playlist from "@/components/guide/Playlist.vue";
import CourseDetails from "@/components/guide/CourseDetails.vue";
import UploadVideoComponent from "@/components/guide/UploadVideoComponent.vue";
import VideoUpload from "@/components/guide/VideoUpload.vue";
import PlayVideos from "@/components/guide/PlayVideos.vue";


import VideoList from "@/components/guide/VideoList.vue";
import EditVideo from "@/components/guide/EditVideo.vue";
import StudentsList from "@/components/guide/StudentsList.vue";
import StudentsImport from "@/components/guide/StudentsImport.vue";


import StudentsExport from "@/components/guide/StudentsExport.vue";
import StudentDetails from "@/components/guide/StudentDetails.vue";
import BadgesComponent from "@/components/guide/BadgesComponent.vue";


import SearchStudent from "@/components/guide/SearchStudent.vue";
import EventsScore from "@/components/guide/EventsScore.vue";
//import ReferralsCenter from "@/components/guide/ReferralsCenter.vue";
import LoginHistory from "@/components/guide/LoginHistory.vue";


import SettingsComponent from "@/components/guide/SettingsComponent.vue";
 import ContactImport from "@/components/guide/ContactImport.vue";
 import ContactExport from "@/components/guide/ContactExport.vue";


import SmtpSettings from "@/components/guide/SmtpSettings.vue";

import ComingSoon from "@/components/guide/ComingSoon.vue";

const guideRoutes = [
    {
        path: "/guide",
        component: Layout,
        meta: { requiresAuth: true, requiresGuide: true },
        children: [
            { path: "leads-board", name: "LeadBoard", component: LeadBoard },
            { path: "dashboard", name: "Dashboard", component: Dashboard },
      /*      { path: "contacts", name: "ContactList", component: ContactList },
            {
                path: "contacts/:id/edit",
                name: "EditContact",
                component: ContactForm,
            },
            {
                path: "contacts/create",
                name: "CreateContact",
                component: ContactForm,
            },
            */
            { path: "leads", name: "LeadList", component: LeadList },
            { path: "leads/:id/edit", name: "EditLead", component: LeadForm },
            { path: "leads/create", name: "CreateLead", component: LeadForm },

            { path: "profile", name: "Profile", component: ComingSoon },

            {
                path: "tickets/create",
                name: "CreateTicket",
                component: CreateTicket,
            },
            {
                path: "tickets",
                name: "AdminTicketList",
                component: AdminTicketList,
            },
            {
                path: "ticket/:id",
                name: "adminTicketDetails",
                component: AdminTicketDetails,
            },
            { path: "chat", name: "GuideChat", component: Chat },
            {
                path: "campaigns/create",
                name: "CreateCampaign",
                component: CreateCampaign,
            },
            {
                path: "campaigns",
                name: "ListCampaigns",
                component: ListCampaigns,
            },
            {
                path: "campaign/:id",
                name: "ViewCampaign",
                component: ViewCampaign,
                props: true,
            },
            
        
         
            { path: "courses", name: "CourseList", component: CourseList },
            {
                path: "courses/create",
                name: "CreateCourse",
                component: CourseForm,
            },
            {
                path: "courses/:id/edit",
                name: "EditCourse",
                component: CourseForm,
            },
            {
                path: "courses/:courseId/study-materials",
                name: "StudyMaterials",
                component: StudyMaterials,
            },
            {
                path: "courses/:courseId/playlists",
                name: "Playlists",
                component: Playlist,
            },
            {
                path: "courses/:id",
                name: "CourseDetails",
                component: CourseDetails,
            },
            {
                path: "upload-video2",
                name: "UploadVideoComponent",
                component: UploadVideoComponent,
            },
            {
                path: "upload-video",
                name: "VideoUpload",
                component: VideoUpload,
            },
            { path: "videos", name: "PlayVideos", component: PlayVideos },
            { path: "video-list", name: "VideoList", component: VideoList },
            {
                path: "videos/edit/:id",
                name: "EditVideo",
                component: EditVideo,
            },
            { path: "students", name: "StudentsList", component: StudentsList },
            {
                path: "import",
                name: "StudentsImport",
                component: StudentsImport,
            },
            {
                path: "export",
                name: "StudentsExport",
                component: StudentsExport,
            },
            {
                path: "students/:id",
                name: "StudentDetails",
                component: StudentDetails,
            },
            {
                path: "badges",
                name: "BadgesComponent",
                component: BadgesComponent,
            },
            { path: "search", name: "SearchStudent", component: SearchStudent },
            { path: "badges", name: "EventsScore", component: EventsScore },
          
          /*  {
                path: "referrals-center1",
                name: "ReferralsCenter1",
                component: ReferralsCenter,
            },
            */
            {
                path: "login-history",
                name: "guideLoginHistory",
                component: LoginHistory,
            },
            {
                path: "leaderboard",
                name: "LeaderboardComponent",
                component: LeadBoard,
            },
            {
                path: "settings",
                name: "SettingsComponent",
                component: SettingsComponent,
            },
          {
                path: "contact-import",
                name: "ContactImport",
                component: ContactImport,
            },
            {
                path: "contact-export",
                name: "ContactExport",
                component: ContactExport,
            }, 
            {
                path: "smtp-settings",
                name: "SmtpSettings",
                component: SmtpSettings,
            },
        ],
    },
];

export default guideRoutes;
