import axios from "axios";

const apiClient = axios.create({
    baseURL: "/v1/admin",
    headers: {
        "Content-Type": "application/json",
    },
});

export default {
    getCourses() {
        return apiClient.get("/courses");
    },
   
    getTicketDetails(ticketId) {
        return apiClient.get(`/tickets/${ticketId}`);
    },
    getMessages(ticketId) {
        return apiClient.get(`/tickets/${ticketId}/messages`);
    },
    postMessage(ticketId, message) {
        return apiClient.post(`/tickets/${ticketId}/messages`, {
            message,
        });
    },
    getTickets() {
        return apiClient.get("/tickets_list");
    },
    getCategoriesAndPriorities() {
        return apiClient.get("/ticket-categories-priorities");
    },
    closeTicket(id) {
        return apiClient.put(`/tickets/${id}`, { status: "closed" });
    },

    getBadges() {
        return apiClient.get("/badges");
    },
    getEvents() {
        return apiClient.get("/events");
    },
    createBadge(badge) {
        return apiClient.post("/badges", badge);
    },
    updateBadge(id, badge) {
        return apiClient.put(`/badges/${id}`, badge);
    },
    deleteBadge(id) {
        return apiClient.delete(`/badges/${id}`);
    },

    getSettings() {
        return apiClient.get("/settings/brand-settings");
    },
    updateSettings(settings) {
        return apiClient.post("/settings/brand-settings", settings);
    },

    getChats() {
        return apiClient.get("/chats_list");
    },
    postChat(chat) {
        return apiClient.post("/chats", { chat });
    },

    getContactFields() {
        return apiClient.get("/getContactfields");
    },
    getFilteredContacts(columns) {
        return apiClient.post("/getFilteredContacts", { columns });
    },

    saveContact(contactId, contactData) {
        if (contactId) {
            return apiClient.put(`/contacts/${contactId}`, contactData);
        } else {
            return apiClient.post("/contacts", contactData);
        }
    },
    fetchContact(contactId) {
        return apiClient.get(`/contacts/${contactId}`);
    },

    importContacts(mappedData) {
        return apiClient.post("/importContacts", mappedData);
    },

    getContacts() {
        return apiClient.get("/contacts_list");
    },
    deleteContact(id) {
        return apiClient.delete(`/contacts/${id}`);
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    getVideos(courseId, playlistId) {
        return apiClient.get(
            `/courses/${courseId}/playlists/${playlistId}/videos`
        );
    },

    saveCourse(courseId, courseData) {
        if (courseId) {
            return apiClient.put(`/courses/${courseId}`, courseData);
        } else {
            return apiClient.post("/courses", courseData);
        }
    },

    getCourses() {
        return apiClient.get("/courses");
    },
    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    saveCourse(courseId, courseData) {
        if (courseId) {
            return apiClient.put(`/courses/${courseId}`, courseData);
        } else {
            return apiClient.post("/courses", courseData);
        }
    },
    deleteCourse(courseId) {
        return apiClient.delete(`/courses/${courseId}`);
    },

    getCourses() {
        return apiClient.get("/courses");
    },

    saveCourse(courseId, courseData) {
        if (courseId) {
            return apiClient.put(`/courses/${courseId}`, courseData);
        } else {
            return apiClient.post("/courses", courseData);
        }
    },
    deleteCourse(courseId) {
        return apiClient.delete(`/courses/${courseId}`);
    },

    getTags() {
        return apiClient.get("/tags");
    },
    createCampaign(campaignData) {
        return apiClient.post("/campaigns", campaignData);
    },
    duplicateCampaign(campaignId) {
        return apiClient.post(`/campaigns/${campaignId}/duplicate`);
    },

    getContacts() {
        return apiClient.get("/contacts_list");
    },
    getProducts() {
        return apiClient.get("/products");
    },
    createInvoice(formData) {
        return apiClient.post("/invoices", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
    },

    getCategoriesAndPriorities() {
        return apiClient.get("/ticket-categories-priorities");
    },

    getDashboardData() {
        return apiClient.get("/dashboard-data");
    },
    getWeeklyRegisteredUsers() {
        return apiClient.get("/weekly-registered-users");
    },
    getActivityLogs() {
        return apiClient.get("/activities");
    },
    getNewStudents() {
        return apiClient.get("/new-students");
    },

    getUserData() {
        return apiClient.get("/me");
    },
    getDashboardData() {
        return apiClient.get("/dashboard-data");
    },
    getWeeklyRegisteredUsers() {
        return apiClient.get("/weekly-registered-users");
    },
    getActivityLogs() {
        return apiClient.get("/activities");
    },
    getNewStudents() {
        return apiClient.get("/new-students");
    },

    getLeadStatuses() {
        return apiClient.get("/get_lead_status");
    },
    getLeads() {
        return apiClient.get("/leads_list");
    },
    deleteLead(id) {
        return apiClient.delete(`/leads/${id}`);
    },
    updateLeadStatus(id, status) {
        return apiClient.put(`/leads/updateStatus/${id}`, { status });
    },
    createDummyData() {
        return apiClient.post("/leads/bulk_create");
    },
    deleteAllLeads() {
        return apiClient.delete("/leads/delete_all");
    },

    getLead(id) {
        return apiClient.get(`/leads/${id}`);
    },
    saveLead(leadData) {
        if (leadData.id) {
            return apiClient.put(`/leads/${leadData.id}`, leadData);
        } else {
            return apiClient.post("/leads", leadData);
        }
    },

    leaddashboarddata() {
        return apiClient.get("/lead/dashboard_data");
    },
    reportByTags() {
        return apiClient.get("/lead/report-by-tags");
    },

    getInvoice(id) {
        return apiClient.get(`/invoices/${id}`);
    },

    getCampaign(id) {
        return apiClient.get(`/campaign/${id}`);
    },

    getUnattachedVideos() {
        return apiClient.get("/get_unattached_videos");
    },
    uploadMultipleVideos(formData, onUploadProgress) {
        return apiClient.post("/videos/upload-multiple", formData, {
            onUploadProgress,
        });
    },

    getAttachedVideos() {
        return apiClient.get("/get_attached_videos");
    },

    getLatestVideos() {
        return apiClient.get("/videos/latest");
    },

    getNotifications() {
        return apiClient.get("/notifications");
    },

    getActivities() {
        return apiClient.get("/activities");
    },

    getCourses() {
        return apiClient.get("/courses");
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    uploadVideo(formData) {
        return apiClient.post("/videos", formData);
    },
    getLastThreeVideos() {
        return apiClient.get("/videos/latest");
    },

    getTransactions() {
        return apiClient.get("/transactions");
    },

    getCourse(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getStudyMaterials(courseId) {
        return apiClient.get(`/courses/${courseId}/study-materials`);
    },
    addStudyMaterial(courseId, formData) {
        return apiClient.post(`/courses/${courseId}/study-materials`, formData);
    },

    getStudents(searchQuery = "") {
        return apiClient.get(`/students?search=${searchQuery}`);
    },
    suspendStudent(id) {
        return apiClient.post(`/students/${id}/suspend`);
    },
    unsuspendStudent(id) {
        return apiClient.post(`/students/${id}/unsuspend`);
    },

    getImportFields() {
        return apiClient.get("/getStudentImportfields");
    },
    importStudents(data) {
        return apiClient.post("/importstudents", data);
    },

    getImportFields() {
        return apiClient.get("/getStudentImportfields");
    },
    getFilteredStudents(columns) {
        return apiClient.post("/getFilteredStudents", { columns });
    },

    getPurchaseHistory(studentId) {
        return apiClient.get(`/students/${studentId}/purchase-history`);
    },

    getLoginHistory(studentId) {
        return apiClient.get(`/students/${studentId}/login-history`);
    },

    getInvoices(studentId) {
        return apiClient.get(`/students/${studentId}/invoices`);
    },
    deleteInvoice(id) {
        return apiClient.delete(`/invoices/${id}`);
    },

    increaseScore(studentId, payload) {
        return apiClient.post(`/students/${studentId}/increase-score`, payload);
    },
    getScoreHistory(studentId) {
        return apiClient.get(`/students/${studentId}/score-history`);
    },

    saveStudent(studentForm) {
        return apiClient.post("/students", studentForm);
    },
    updateStudent(studentId, studentForm) {
        return apiClient.put(`/students/${studentId}`, studentForm);
    },
    fetchStudent(studentId) {
        return apiClient.get(`/students/${studentId}`);
    },

    fetchStudentDetails(studentId) {
        return apiClient.get(`/students/${studentId}`);
    },

    getBadges(studentId) {
        return apiClient.get(`/students/${studentId}/badges`);
    },

    getActivityReport(studentId) {
        return apiClient.get(`/students/${studentId}/activity-report`);
    },

    getSmtpSettings() {
        return apiClient.get("/settings/smtp-settings");
    },
    saveSmtpSettings(settings) {
        return apiClient.post("/settings/smtp-settings", settings);
    },

    testSmtpSettings(formvalue) {
        return apiClient.post("/settings/smtp-settings/test", formvalue);
    },

    getApiSettings() {
        return apiClient.get("/settings/api-key-settings");
    },
    saveApiSettings(settings) {
        return apiClient.post("/settings/api-key-settings", settings);
    },

    getCurrencySymbol() {
        return apiClient.get("/settings/currency-symbol");
    },

    getSectionsText() {
        return apiClient.get("/settings/SectionsText");
    },

    postSectionsText(data) {
        return apiClient.post("/settings/SectionsText", data);
    },

    saveloginBanner(formData, onUploadProgress) {
        return apiClient.post("/settings/saveloginBanner", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress,
        });
    },

    savecompanyLogo(formData, onUploadProgress) {
        return apiClient.post("/settings/savecompanyLogo", formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
            onUploadProgress,
        });
    },

    updateCurrencySymbol(symbol) {
        return apiClient.post("/settings/currency-symbol", {
            currency_symbol: symbol,
        });
    },
    getApiToken() {
        return apiClient.get("/getToken");
    },

    searchStudents(query) {
        return apiClient.get(`/students?search=${query}`);
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

    getProfile() {
        return apiClient.get("/me");
    },
    updateProfile(profileData) {
        return apiClient.put("/profile", profileData);
    },

    getProducts() {
        return apiClient.get("/products");
    },
    createProduct(productData) {
        return apiClient.post("/products", productData);
    },
    getProduct(id) {
        return apiClient.get(`/products/${id}`);
    },
    updateProduct(id, productData) {
        return apiClient.put(`/products/${id}`, productData);
    },
    deleteProduct(id) {
        return apiClient.delete(`/products/${id}`);
    },

    getProduct(id) {
        return apiClient.get(`/products/${id}`);
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    getVideos(courseId, playlistId) {
        return apiClient.get(
            `/courses/${courseId}/playlists/${playlistId}/videos`
        );
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    addPlaylist(courseId, playlistData) {
        return apiClient.post(`/courses/${courseId}/playlists`, playlistData);
    },
    addVideo(playlistId, videoData) {
        return apiClient.post(`/playlists/${playlistId}/videos`, videoData);
    },

    getCourseDetails(courseId) {
        return apiClient.get(`/courses/${courseId}`);
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    addPlaylist(courseId, playlistData) {
        return apiClient.post(`/courses/${courseId}/playlists`, playlistData);
    },
    addVideo(playlistId, videoData) {
        return apiClient.post(`/playlists/${playlistId}/videos`, videoData);
    },

    getMyScore() {
        return apiClient.get("/leaderboard/my-score");
    },
    getMyScoreHistory() {
        return apiClient.get("/leaderboard/my-score-history");
    },

    getLoginHistory() {
        return apiClient.get("/login-history");
    },

    getTickets() {
        return apiClient.get("/tickets_list");
    },
    getCategoriesAndPriorities() {
        return apiClient.get("/ticket-categories-priorities");
    },

    closeTicket(id) {
        return apiClient.put(`/tickets/${id}`, { status: "closed" });
    },

    getTasks() {
        return apiClient.get("/tasks");
    },
    createTask(taskData) {
        return apiClient.post("/tasks", taskData);
    },
    deleteTask(id) {
        return apiClient.delete(`/tasks/${id}`);
    },

    getTasks() {
        return apiClient.get("/tasks");
    },
    createTask(taskData) {
        return apiClient.post("/tasks", taskData);
    },
    deleteTask(id) {
        return apiClient.delete(`/tasks/${id}`);
    },

    getInvoices() {
        return apiClient.get("/invoices");
    },
    deleteInvoice(id) {
        return apiClient.delete(`/invoices/${id}`);
    },

    getCampaigns() {
        return apiClient.get("/campaigns_list");
    },

    getEventScores() {
        return apiClient.get("/event-scores");
    },
    getEvents() {
        return apiClient.get("/events");
    },
    createEventScore(eventScore) {
        return apiClient.post("/event-scores", eventScore);
    },
    updateEventScore(id, eventScore) {
        return apiClient.put(`/event-scores/${id}`, eventScore);
    },
    deleteEventScore(id) {
        return apiClient.delete(`/event-scores/${id}`);
    },

    getCourses() {
        return apiClient.get("/courses");
    },
    getStudentCourses(studentId) {
        return apiClient.get(`/students/${studentId}/courses`);
    },
    enrollInCourse(studentId, courseId) {
        return apiClient.post(`/students/${studentId}/course/enroll`, {
            course_id: courseId,
        });
    },
    removeCourse(studentId, courseId) {
        return apiClient.delete(`/students/${studentId}/course/remove/`, {
            data: { course_id: courseId },
        });
    },

    getVideo(videoId) {
        return apiClient.get(`/video/${videoId}`);
    },
    getCourses() {
        return apiClient.get("/courses");
    },
    getPlaylists(courseId) {
        return apiClient.get(`/courses/${courseId}/playlists`);
    },
    updateVideo(videoId, formData) {
        return apiClient.post(`/video/${videoId}`, formData);
    },

    getInvoice(id) {
        return apiClient.get(`/invoices/${id}`);
    },
    getProducts() {
        return apiClient.get("/products");
    },
    getContacts() {
        return apiClient.get("/contacts_list");
    },
    updateInvoiceDetails(id, detailsData) {
        return apiClient.put(`/invoices/${id}/details`, detailsData);
    },
    updateInvoiceDatesAndTerms(id, datesTermsData) {
        return apiClient.put(`/invoices/${id}/dates-terms`, datesTermsData);
    },
    updateCustomerNoteAndTerms(id, noteTermsData) {
        return apiClient.put(`/invoices/${id}/note-terms`, noteTermsData);
    },
    updateProducts(id, productsData) {
        return apiClient.put(`/invoices/${id}/products`, {
            products: productsData,
        });
    },
    updateFile(id, formData) {
        return apiClient.post(`/invoices/${id}/file`, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });
    },

    getUser(id) {
        return apiClient.get(`/users/${id}`);
    },
    getUserLeads(id) {
        return apiClient.get(`/user/${id}/leads`);
    },
    getUserContacts(id) {
        return apiClient.get(`/user/${id}/contacts`);
    },
    updateUser(id, userData) {
        return apiClient.put(`/users/${id}`, userData);
    },

    getUsers() {
        return apiClient.get("/users_list");
    },
    suspendUser(id) {
        return apiClient.post(`/users/${id}/suspend`);
    },
    unsuspendUser(id) {
        return apiClient.post(`/users/${id}/unsuspend`);
    },
    deleteUser(id) {
        return apiClient.delete(`/users/${id}`);
    },

    // Add other API methods here
};
