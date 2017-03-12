<?php

Route::get('/', 'Auth\AuthController@index')->middleware(['web']);

Route::get('demo-credentials', 'Auth\AuthController@demo');

Route::group(['middleware' => ['web']], function () {
    Route::post('register', 'Auth\AuthController@register');
    Route::post('login', 'Auth\AuthController@login');
    Route::post('create', 'Auth\SocialAuthController@createAccount');
    Route::get('redirect', 'Auth\SocialAuthController@redirectToProvider');
    Route::get('callback', 'Auth\SocialAuthController@handleProviderCallback');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
        
        Route::get('/dashboard', 'DashboardController@index');

        // Users
        Route::get('/users', 'UserController@index');
        Route::get('/professors', 'UserController@professors');
        Route::get('/students', 'UserController@students');

        // Users API
        Route::get('/api/users', 'Api\UserController@index');
        Route::get('/api/professors', 'Api\UserController@professors');
        Route::get('/api/students', 'Api\UserController@students');

        // Users
        Route::get('/posts', 'PostController@index');

        // Settings
        Route::get('/settings', 'SettingController@index');

    });

    Route::group(['prefix' => 'webapi', 'namespace' => 'Api'], function () {
        // Route::get('/conversations', 'ConversationController@index');
        // Route::post('/conversations', 'ConversationController@store');
        // Route::get('/conversations/{conversation}', 'ConversationController@show');
        // Route::post('/conversations/{conversation}/reply', 'ConversationReplyController@store');
        // Route::post('/conversations/{conversation}/users', 'ConversationUserController@store');
    });

    Route::post('logout', 'Auth\AuthController@logout');

    // Conversation
    Route::get('conversation', 'ConversationController@getConversations');
    Route::get('show-conversation/{id}', 'ConversationController@showConversation');
    Route::post('create-conversation', 'ConversationController@createConversation');
    Route::post('message', 'ConversationController@sendMessage');
    

    // Posts Controller
    Route::get('posts/my-feed', 'Feed\PostController@myFeed');
    Route::get('posts/user/{usn}', 'Feed\PostController@getUserFeed');
    Route::resource('posts', 'Feed\PostController');

    // Posts Likes Controller
    Route::post('like/{post}', 'Feed\PostLikeController@store');
    Route::delete('like/{post}', 'Feed\PostLikeController@destroy');

    // Posts Comments Controller
    Route::get('comment/{post}/{increment}', 'Feed\PostCommentController@index');
    Route::get('comment-time/{comment}', 'Feed\PostCommentController@updateTime');
    Route::patch('comment/{comment}', 'Feed\PostCommentController@update');
    Route::delete('comment/{comment}', 'Feed\PostCommentController@destroy');
    Route::post('comment/{post}', 'Feed\PostCommentController@store');

    // Posts Likes Controller
    Route::post('comment-like/{comment}/{post}', 'Feed\PostCommentLikeController@store');
    Route::delete('comment-like/{comment}', 'Feed\PostCommentLikeController@destroy');

    // Navbar
    Route::get('get-unread', 'NotificationController@getUnread');
    Route::get('notifications', 'NotificationController@index');
    Route::get('get-notifications', 'NotificationController@getAll');

    // Follow Controller
    Route::post('follow/{user}', 'FollowController@followUser');
    Route::get('follow-suggestions', 'FollowController@suggestedUsers');

    // Profile Controller
    Route::post('profile/update-name', 'ProfileController@updateName');

    // Group Page
    Route::get('groups', 'Group\GroupController@index');
    Route::get('groups/list', 'Group\GroupController@getLists');
    Route::get('groups/my-groups', 'Group\GroupController@myGroups');
    Route::get('groups/datatables', 'Group\GroupController@dataTable');

    Route::get('groups/create', 'Group\GroupController@create');
    Route::post('groups/create', 'Group\GroupController@store');
    Route::post('group/leave-class/{group}/{user}', 'Group\GroupController@leaveClass');

    Route::get('groups/{group}', 'Group\GroupController@group');
    Route::post('groups/join-request', 'Group\GroupController@joinRequest');
    Route::get('group/pending/{group}', 'Group\GroupController@pendingRequests');
    Route::post('group/accept/{group}/{user}', 'Group\GroupController@acceptRequest');
    Route::post('group/decline/{group}/{user}', 'Group\GroupController@declineRequest');

    Route::post('group/kick/{group}/{user}', 'Group\GroupController@kickMember');
    Route::post('group/settings/{group}', 'Group\GroupController@updateSettings');
    Route::get('group/fetch-members/{group}', 'Group\GroupController@fetchMembers');

    // Group Post
    Route::get('group/posts/{group}', 'Group\GroupPostController@index');
    Route::post('group/post/{group}', 'Group\GroupPostController@store');
    Route::delete('group/post/{id}', 'Group\GroupPostController@destroy');

    // Group Post Like
    Route::post('group/like-post/{id}', 'Group\GroupPostLikeController@store');

    // Group Comment
    Route::post('group/comment/{group}', 'Group\GroupPostCommentController@store');
    Route::delete('group/comment/{id}/{groupId}', 'Group\GroupPostCommentController@destroy');

    // Group Comment Like
    Route::post('group/like-post-comment/{id}', 'Group\GroupPostCommentLikeController@store');

    // Group Grade
    Route::get('grades', 'Group\GroupGradeController@allGrades');
    Route::post('group/{group}/{user}/update-grade', 'Group\GroupGradeController@updateGrade');

    // Calendar Controller
    Route::get('/calendar', 'CalendarController@index');
    Route::get('/calendar/events', 'CalendarController@events');
    Route::get('/calendar/event/{calendar}', 'CalendarController@viewEvent');
    Route::delete('/calendar/{id}', 'CalendarController@destroy');
    Route::post('/calendar', 'CalendarController@store');

    // Schedule Controller
    Route::get('/schedule/{usn}', 'ScheduleController@getSchedule');

    // Grade Controller
    Route::post('/grade', 'GradeController@store');

    // Search Controller
    Route::get('{user}', 'SearchController@index');
});
