https://neetcode.io/courses/dsa-for-beginners/31


curl --location 'http://laravel-vue-auth1.test/api/student' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer 2|GN94KeRJmiGCQtRfSbtkHk8JQbpblusLXqZqjSEda10cce4f' \
--header 'Cookie: XSRF-TOKEN=eyJpdiI6InpZelBlSnB3Nmc0R0hZQWN2SG5qRlE9PSIsInZhbHVlIjoiRmFLUmpZUExWbFVVUytqM1NBUFhQU01PMjdPejBLbkxSYTBTbWhlRHpnVWw0aGRzL1cwNjZRdzlZaXpYWDlTUFFCNDNqaTVJMVhuTUt5TkJxNy9XVUxUbmxmclRuSklGNG1EaUJjMGhpTGRnalllSHdMNUhZMFlLVWlMM0xWc0oiLCJtYWMiOiJmMjk4MTg3Y2M2OGQ2ZjBmMjFjZGIyYzMwNDNhM2FkY2I0MTc0OWMyNTQyYmQwYzY5ZmM5ZDBiZDliMjMwZGI1IiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IlJaSUNkeS9uQkRBUGt0NkhzbnArVGc9PSIsInZhbHVlIjoiSlZpRjNlejc2OWN5cVBpakdtTjh2UXg0ZjJmelA4MnVGdTlqZzBDYk1haFNHeG92UmQ0TFFaZS9hc01lVWl2REdvZDliNGxyc1Jja3hHdkNWSFN2SEMyN2JrVU9GYTBFUlV2cE9vVnNrT3VzL3MycHYyQnNRZnkzb2FaY054VjMiLCJtYWMiOiIyNjQ2OTBiNzlhNzg0NDU2NDdiYjdmZjEyMmIwNzI3ZTQ5ZGFkN2QwN2Y2N2Q4NzMyZTE5MTYyMGE3MzUyMmJjIiwidGFnIjoiIn0%3D' \
--data-raw '{
"name": "John Doe",
"email": "john.doe@example.com",
"phoneNumber": "1234567890",
"tags": ["tag1", "tag2", "tag3"]
}'


------------

what is event score 

when a certain event happen after a user actity this credit scroe to the user 

like if user watch a video we will claim 5 units 

this way we can determine who is more active 


---

add api to  add student and enrol to course 
add toast notification 

in web.php/api.php  add middleware for safety and permissions 


in ticket management
 open ticket -> who last message -> total message 
 closed ticket  hide
 category / priority also 

 setting section 

a- smtp details 
b- logo
c- company name 
d- footer text 

 --

  in badege / event scroe page provide details what they are 

  --

  learning video page design

  -----
  chat box does not look good

-------

keep footer down always if not text 

--------

student profile  and guide profile are two different thing

------

some video are classified and some or not classified fix this

-- student edit tag not workign
--tag in edit video 
---------

notification right popup you have 5 notification


---------
php artisan queue:work


-----------

api 

1. 
/v1/admin/courses
2. 
/v1/admin/guest/send-otp
3. 
/v1/admin/guest/verify-otp
4. 
/v1/admin/tickets/{ticketId}
5. 
/v1/admin/tickets/{ticketId}/messages
6. 
/v1/admin/tickets_list
7. 
/v1/admin/ticket-categories-priorities
8. 
/v1/admin/badges
9. 
/v1/admin/events
10. 
/v1/admin/settings/brand-settings
11. 
/v1/admin/brand-settings
12. 
/v1/admin/chats_list
13. 
/v1/admin/chats
14. 
/v1/admin/getContactfields
15. 
/v1/admin/getFilteredContacts
16. 
/v1/admin/contacts/{contactId}
17. 
/v1/admin/contacts
18. 
/v1/admin/importContacts
19. 
/v1/admin/courses/{courseId}
20. 
/v1/admin/courses/{courseId}/playlists
21. 
/v1/admin/courses/{courseId}/playlists/{playlistId}/videos
22. 
/v1/admin/tickets/{id}
23. 
/v1/admin/tags
24. 
/v1/admin/campaigns
25. 
/v1/admin/campaigns/{campaignId}/duplicate
26. 
/v1/admin/products
27. 
/v1/admin/invoices
28. 
/v1/admin/dashboard-data
29. 
/v1/admin/weekly-registered-users
30. 
/v1/admin/activities
31. 
/v1/admin/new-students
32. 
/v1/admin/me
33. 
/v1/admin/get_lead_status
34. 
/v1/admin/leads_list
35. 
/v1/admin/leads/{id}
36. 
/v1/admin/leads/updateStatus/{id}
37. 
/v1/admin/leads/bulk_create
38. 
/v1/admin/leads/delete_all
39. 
/v1/admin/lead/dashboard_data
40. 
/v1/admin/lead/report-by-tags
41. 
/v1/admin/invoices/{id}
42. 
/v1/admin/campaign/{id}
43. 
/v1/admin/get_unattached_videos
44. 
/v1/admin/videos/upload-multiple
45. 
/v1/admin/get_attached_videos
46. 
/v1/admin/videos/latest
47. 
/v1/admin/notifications
48. 
/v1/admin/leaderboard/my-score
49. 
/v1/admin/leaderboard/my-score-history
50. 
/v1/admin/login-history
51. 
/v1/admin/tasks
52. 
/v1/admin/event-scores
53. 
/v1/admin/events
54. 
/v1/admin/event-scores/{id}
55. 
/v1/admin/students
56. 
/v1/admin/students/{id}/suspend
57. 
/v1/admin/students/{id}/unsuspend
58. 
/v1/admin/importstudents
59. 
/v1/admin/students/{studentId}/purchase-history
60. 
/v1/admin/students/{studentId}/login-history
61. 
/v1/admin/students/{studentId}/invoices
62. 
/v1/admin/students/{studentId}/increase-score
63. 
/v1/admin/students/{studentId}/score-history
64. 
/v1/admin/students/{studentId}
65. 
/v1/admin/students/{studentId}/badges
66. 
/v1/admin/students/{studentId}/activity-report
67. 
/v1/admin/smtp-settings
68. 
/v1/admin/smtp-settings/test
69. 
/v1/admin/settings/api-key-settings
70. 
/v1/admin/settings/currency-symbol
71. 
/v1/admin/settings/SectionsText
72. 
/v1/admin/settings/saveloginBanner
73. 
/v1/admin/settings/savecompanyLogo
74. 
/v1/admin/getToken
75. 
/v1/admin/request-withdrawal
76. 
/v1/admin/referral-report
77. 
/v1/admin/withdrawals
78. 
/v1/admin/profile
79. 
/v1/admin/products/{id}
80. 
/v1/admin/invoices/{id}/details
81. 
/v1/admin/invoices/{id}/dates-terms
82. 
/v1/admin/invoices/{id}/note-terms
83. 
/v1/admin/invoices/{id}/products
84. 
/v1/admin/invoices/{id}/file
85. 
/v1/admin/users/{id}
86. 
/v1/admin/user/{id}/leads
87. 
/v1/admin/user/{id}/contacts
88. 
/v1/admin/users_list
89. 
/v1/admin/users/{id}/suspend
90. 
/v1/admin/users/{id}/unsuspend
91. 
/v1/admin/users/{id}
