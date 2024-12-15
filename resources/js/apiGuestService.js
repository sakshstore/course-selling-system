import axios from "axios";

const apiClient = axios.create({
    baseURL: "/v1",
    headers: {
        "Content-Type": "application/json",
    },
});

export default {
    sendOtp(email) {
        return apiClient.post("/guest/send-otp", { email });
    },
    verifyOtp(email, otp) {
        return apiClient.post("/guest/verify-otp", { email, otp });
    },

    
    getCourseAndPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists/videos`);
    },

    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists/videos`);
    },
    getChats() {
        return apiClient.get("/chats_list");
    },
    postChat(chat) {
        return apiClient.post("/chats", { chat });
    },

    getVideos(courseId) {
        return apiClient.get(`/courses/${courseId}/videos`);
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    purchaseCourse(courseId) {
        return apiClient.post(`/courses/${courseId}/purchase`);
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },

    getCourses() {
        return apiClient.get("/courses");
    },

    getUserData() {
        return apiClient.get("/me");
    },
    getMyCourses() {
        return apiClient.get("/my-courses");
    },
    getRecommendedCourses() {
        return apiClient.get("/recommended-courses");
    },
    getRecentlyViewedCourses() {
        return apiClient.get("/recently-viewed-courses");
    },
    getSettings() {

     
        return apiClient.get("/settings/brand-settings");
    },

    getCourse(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getVideos(courseId, playlistId) {
        return apiClient.get(
            `/courses/${courseId}/playlists/${playlistId}/videos`
        );
    },

    getTickets() {
        return apiClient.get("/tickets_list");
    },
    getCategoriesAndPriorities() {
        return apiClient.get("/ticket-categories-priorities");
    },
    createTicket(formData) {
        return apiClient.post("/tickets", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
    },
    closeTicket(id) {
        return apiClient.put(`/tickets/${id}`, { status: "closed" });
    },

    getLoginHistory() {
        return apiClient.get("/login-history");
    },

    getScore() {
        return apiClient.get("/leaderboard/my-score");
    },
    getScoreHistory() {
        return apiClient.get("/leaderboard/my-score-history");
    },

    getProfile() {
        return apiClient.get("/me");
    },
    updateProfile(user) {
        return apiClient.put("/profile", user);
    },

    getCurrencySymbol() {
        return apiClient.get("/api/settings/currency-symbol");
    },
    generateReferralCode() {
        return apiClient.post("/generate-referral-code");
    },
    requestWithdrawal(amount) {
        return apiClient.post("/request-withdrawal", { amount });
    },
    getTransactions() {
        return apiClient.get("/transactions");
    },
    getReferralReport() {
        return apiClient.get("/referral-report");
    },
    getWithdrawals() {
        return apiClient.get("/withdrawals");
    },

    getTicketDetails(ticketId) {
        return apiClient.get(`/tickets/${ticketId}`);
    },
    getMessages(ticketId) {
        return apiClient.get(`/tickets/${ticketId}/messages`);
    },
    postMessage(ticketId, message) {
        return apiClient.post(`/tickets/${ticketId}/messages`, { message });
    },

    getActivities() {
        return apiClient.get("/activities");
    },

    getNotifications() {
        return apiClient.get("/notifications");
    },

    getLatestVideos() {
        return apiClient.get("/videos/latest");
    },

    // Add other API methods here
};
