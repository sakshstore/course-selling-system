 
import GuestLayout from '@/components/GuestLayout.vue';
import Layout from '@/components/Layout.vue';
import AdminLayout from '@/components/AdminLayout.vue';

import LeadBoard from '@/components/LeadBoard.vue';
import GuideLogin from '@/components/GuideLogin.vue';
import OtpLogin from '@/components/OtpLogin.vue';
import Register from '@/components/Register.vue';
import Dashboard from '@/components/Dashboard.vue';
import ContactList from '@/components/ContactList.vue';
import ContactForm from '@/components/ContactForm.vue';
import LeadList from '@/components/LeadList.vue';
import LeadForm from '@/components/LeadForm.vue';
import Profile from '@/components/Profile.vue';
import UserManagement from '@/components/UserManagement.vue';
import UserDetail from '@/components/UserDetail.vue';
 
import AdminLogin from '@/components/AdminLogin.vue';
import CreateCampaign from '@/components/CreateCampaign.vue';
import CreateTicket from '@/components/CreateTicket.vue';
import ListTickets from '@/components/ListTickets.vue';
import Chat from '@/components/Chat.vue';
import ListCampaigns from '@/components/ListCampaigns.vue';
import ViewCampaign from '@/components/ViewCampaign.vue';
import ListTasks from '@/components/ListTasks.vue';
import ListDocuments from '@/components/ListDocuments.vue';
import ListInvoices from '@/components/ListInvoices.vue';
import CreateInvoice from '@/components/CreateInvoice.vue';
import EditInvoice from '@/components/EditInvoice.vue';
import ViewInvoice from '@/components/ViewInvoice.vue';
import ProductList from '@/components/ProductList.vue';
import ProductForm from '@/components/ProductForm.vue';
import CourseList from '@/components/CourseList.vue';
import CourseForm from '@/components/CourseForm.vue';
import StudyMaterials from '@/components/StudyMaterials.vue';
import Playlist from '@/components/Playlist.vue';
import CourseDetails from '@/components/CourseDetails.vue';
import UploadVideoComponent from '@/components/UploadVideoComponent.vue';
import PlayVideos from '@/components/PlayVideos.vue';
import GuestOtpVerify from '@/components/GuestOtpVerify.vue';
import GuestLogin from '@/components/GuestLogin.vue';
import GuestDashboard from '@/components/GuestDashboard.vue';
import GuestCourseList from '@/components/GuestCourseList.vue';
import GuestCourseDetails from '@/components/GuestCourseDetails.vue';
import GuestPlayList from '@/components/GuestPlayList.vue';
import VideoGallery from '@/components/VideoGallery.vue';
import CourseVideoGallery from '@/components/CourseVideoGallery.vue';
import UserActivity from '@/components/UserActivity.vue';
import UserNotifications from '@/components/UserNotifications.vue';
import VideoUpload from '@/components/VideoUpload.vue';
import VideoList from '@/components/VideoList.vue';
import EditVideo from '@/components/EditVideo.vue';
import StudentsList from '@/components/StudentsList.vue';
import BadgesComponent from '@/components/BadgesComponent.vue';
import TicketDetails from '@/components/TicketDetails.vue';


import StudentDetails from '@/components/StudentDetails.vue';


import ReferralsCenter from '@/components/ReferralsCenter.vue';
import SettingsComponent from '@/components/SettingsComponent.vue';

import EventsScore from '@/components/EventsScore.vue';

import MyScore from '@/components/MyScore.vue';

import LoginHistory from '@/components/LoginHistory.vue';
import AdminTicketDetails from '@/components/AdminTicketDetails.vue';

 
import AdminTicketList from '@/components/AdminTicketList.vue';
 
 
import StudentsImport from '@/components/StudentsImport.vue';
  
import StudentsExport from '@/components/StudentsExport.vue';
import SearchStudent from '@/components/SearchStudent.vue';
 



import GuestBuyCourseDetails from '@/components/GuestBuyCourseDetails.vue';

import GuestBuyCourseList from '@/components/GuestBuyCourseList.vue';



import ContactImport from '@/components/ContactImport.vue';

import ContactExport from '@/components/ContactExport.vue';



const routes = [
  // Public routes
  { path: '/', name: 'GuestLogin', component: GuestLogin },
  { path: '/guide', name: 'GuideLogin', component: GuideLogin },
  { path: '/admin', name: 'AdminLogin', component: AdminLogin },
  
  // Guest routes
  {
  path: '/auth',
  component: GuestLayout,
  meta: { requiresAuth: true , requiresGuest: true},
  children: [
  { path: 'dashboard', name: 'GuestDashboard', component: GuestDashboard },
  { path: 'profile', name: 'StudentProfile', component: Profile },
  { path: 'my/courses', name: 'GuestCourseList', component: GuestCourseList },

  { path: 'courses', name: 'GuestBuyCourseList', component: GuestBuyCourseList },


  


  { path: 'chat', name: 'Chat', component: Chat },
  { path: 'my/courses/:id', name: 'GuestCourseDetails', component: GuestCourseDetails },
  
  
  { path: 'courses/:id', name: 'GuestBuyCourseDetails', component: GuestBuyCourseDetails },


  { path: 'courses/:id/playlist/:playlistId', name: 'GuestPlayList', component: GuestPlayList },
  { path: 'user-activities', name: 'UserActivity', component: UserActivity },
  { path: 'user-notifications', name: 'UserNotifications', component: UserNotifications },
  { path: 'video-gallery', name: 'VideoGallery', component: VideoGallery },
  { path: 'referrals-center', name: 'ReferralsCenter', component: ReferralsCenter },
  { path: 'login-history', name: 'authLoginHistory', component: LoginHistory },
  { path: 'my-score', name: 'MyScore', component: MyScore },
  { path: 'courses/:course_id/video-gallery', name: 'CourseVideoGallery', component: CourseVideoGallery },
  { path: 'tickets', name: 'ListTickets', component: ListTickets },
  { path: 'ticket/:id', name: 'authTicketDetails', component: TicketDetails },
  ],
  },
  
  // Guide routes
  {
  path: '/guide',
  component: Layout,
  meta: { requiresAuth: true, requiresGuide: true },
  children: [
  { path: 'leads-board', name: 'LeadBoard', component: LeadBoard },
  { path: 'dashboard', name: 'Dashboard', component: Dashboard },
  { path: 'contacts', name: 'ContactList', component: ContactList },
  { path: 'contacts/:id/edit', name: 'EditContact', component: ContactForm },
  { path: 'contacts/create', name: 'CreateContact', component: ContactForm },
  { path: 'leads', name: 'LeadList', component: LeadList },
  { path: 'leads/:id/edit', name: 'EditLead', component: LeadForm },
  { path: 'leads/create', name: 'CreateLead', component: LeadForm },
  { path: 'profile', name: 'Profile', component: Profile },
  { path: 'tickets/create', name: 'CreateTicket', component: CreateTicket },
  { path: 'tickets', name: 'AdminTicketList', component: AdminTicketList },
  { path: 'ticket/:id', name: 'adminTicketDetails', component: AdminTicketDetails },
  { path: 'chat', name: 'GuideChat', component: Chat },
  { path: 'campaigns/create', name: 'CreateCampaign', component: CreateCampaign },
  { path: 'campaigns', name: 'ListCampaigns', component: ListCampaigns },
  { path: 'campaign/:id', name: 'ViewCampaign', component: ViewCampaign, props: true },
  { path: 'tasks_list', name: 'ListTasks', component: ListTasks },
  { path: 'documents', name: 'ListDocuments', component: ListDocuments },
  { path: 'invoices', name: 'ListInvoices', component: ListInvoices },
  { path: 'invoices/create', name: 'CreateInvoice', component: CreateInvoice },
  { path: 'invoices/:id/edit', name: 'EditInvoice', component: EditInvoice },
  { path: 'invoices/:id', name: 'ViewInvoice', component: ViewInvoice },
  { path: 'products', name: 'ProductList', component: ProductList },
  { path: 'products/create', name: 'CreateProduct', component: ProductForm },
  { path: 'products/:id/edit', name: 'EditProduct', component: ProductForm },
  { path: 'courses', name: 'CourseList', component: CourseList },
  { path: 'courses/create', name: 'CreateCourse', component: CourseForm },
  { path: 'courses/:id/edit', name: 'EditCourse', component: CourseForm },
  { path: 'courses/:courseId/study-materials', name: 'StudyMaterials', component: StudyMaterials },
  { path: 'courses/:courseId/playlists', name: 'Playlists', component: Playlist },
  { path: 'courses/:id', name: 'CourseDetails', component: CourseDetails },
  { path: 'upload-video2', name: 'UploadVideoComponent', component: UploadVideoComponent },
  { path: 'upload-video', name: 'VideoUpload', component: VideoUpload },
  { path: 'videos', name: 'PlayVideos', component: PlayVideos },
  { path: 'video-list', name: 'VideoList', component: VideoList },
  { path: 'videos/edit/:id', name: 'EditVideo', component: EditVideo },
  { path: 'students', name: 'StudentsList', component: StudentsList },
  { path: 'import', name: 'StudentsImport', component: StudentsImport },
  { path: 'export', name: 'StudentsExport', component: StudentsExport },
  { path: 'students/:id', name: 'StudentDetails', component: StudentDetails },


  


  { path: 'badges', name: 'BadgesComponent', component: BadgesComponent },
  
  { path: 'search', name: 'SearchStudent', component: SearchStudent },
  
  
  { path: 'badges', name: 'EventsScore', component: EventsScore },
  { path: 'referrals-center1', name: 'ReferralsCenter1', component: ReferralsCenter },
  { path: 'login-history', name: 'guideLoginHistory', component: LoginHistory },
  { path: 'leaderboard', name: 'LeaderboardComponent', component: LeadBoard },
  { path: 'settings', name: 'SettingsComponent', component: SettingsComponent },

  { path: 'contact-import', name: 'ContactImport', component: ContactImport },
  { path: 'contact-export', name: 'ContactExport', component: ContactExport },


  


  ],
  },
  
  // Admin routes
  {
  path: '/admin',
  component: AdminLayout,
  meta: { requiresAuth: true, requiresAdmin: true },
  children: [
  { path: 'dashboard', name: 'AdminDashboard', component: Dashboard },
  { path: 'users', name: 'UserManagement', component: UserManagement },
  { path: 'users/:id', name: 'UserDetail', component: UserDetail },
  ],
  },
  ];
  
  export default routes;
  