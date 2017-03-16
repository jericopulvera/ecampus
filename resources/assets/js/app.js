require('./bootstrap');
import store from './store';


 // Auth Page
Vue.component('auth', require('./components/auth/Auth.vue'));


// Home Page
Vue.component('newsfeed', require('./components/home/Newsfeed.vue'));
Vue.component('left-panel', require('./components/home/LeftPanel.vue'));
Vue.component('right-panel', require('./components/home/RightPanel.vue'));
Vue.component('posts', require('./components/home/Posts.vue'));

// Notifications Page
Vue.component('notification-page', require('./components/notification/NotificationPage.vue'));

// Navbar
Vue.component('navbar', require('./components/navbar/Navbar.vue'));
Vue.component('notification-tab', require('./components/navbar/NotificationTab.vue'));
Vue.component('search-tab', require('./components/navbar/SearchTab.vue'));
Vue.component('message-tab', require('./components/navbar/MessageTab.vue'));

// Conversation 
Vue.component('conversation-form', require('./components/conversation/forms/ConversationForm.vue'));
Vue.component('conversation-reply-form', require('./components/conversation/forms/ConversationReplyForm.vue'));
Vue.component('conversation-add-user-form', require('./components/conversation/forms/ConversationAddUserForm.vue'));
Vue.component('conversation', require('./components/conversation/Conversation.vue'));
Vue.component('conversations', require('./components/conversation/Conversations.vue'));
Vue.component('conversations-dashboard', require('./components/conversation/ConversationsDashboard.vue'));

// Group 
Vue.component('group', require('./components/group/Group.vue'));
Vue.component('group-sidebar', require('./components/group/GroupSidebar.vue'));
Vue.component('group-pending-requests', require('./components/group/GroupPendingRequests.vue'));

// Group Feed
Vue.component('group-feed', require('./components/group/feed/GroupFeed.vue'));
Vue.component('group-post', require('./components/group/feed/GroupPost.vue'));
Vue.component('group-comment', require('./components/group/feed/GroupComment.vue'));
Vue.component('group-comment-form', require('./components/group/feed/GroupCommentForm.vue'));

// Group Grade
Vue.component('group-grade', require('./components/group/grade/GroupGrade.vue'));
Vue.component('group-grade-modal', require('./components/group/grade/GroupGradeModal.vue'));
Vue.component('group-grade-submit', require('./components/group/grade/GroupGradeSubmit.vue'));

// Group Members
Vue.component('group-members', require('./components/group/members/GroupMembers.vue'));

// Group Settings
Vue.component('group-settings', require('./components/group/settings/GroupSettings.vue'));

// Search
Vue.component('search-profile', require('./components/search/SearchProfile.vue'));
Vue.component('search-user-feed', require('./components/search/SearchUserFeed.vue'));
Vue.component('search-right-panel', require('./components/search/SearchRightPanel.vue'));


// My Profile
Vue.component('my-profile', require('./components/user/MyProfile.vue'));
Vue.component('my-feed', require('./components/user/MyFeed.vue'));


const app = new Vue({
    el: '#app',
    data: window.Laravel,
    store: store
});
