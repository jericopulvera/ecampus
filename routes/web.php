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
        Route::get('/users/create', 'UserController@create');
        Route::post('/users/create', 'UserController@store');
        Route::get('/users/{user}', 'UserController@show');
        Route::post('/users/{user}/block', 'UserController@block')->name('admin-block-user');
        Route::patch('/users/{user}/unblock', 'UserController@unblock')->name('admin-unblock-user');

        // Users API
        Route::get('/api/users', 'Api\UserController@index');
        Route::get('/api/professors', 'Api\UserController@professors');
        Route::get('/api/students', 'Api\UserController@students');
        Route::get('/api/users/{user}/grades', 'Api\UserController@grades')->name('admin-user-grades');

        // Users
        Route::get('/posts', 'PostController@index');

        // Settings
        Route::get('/settings', 'SettingController@index');
        Route::post('/settings', 'SettingController@update');

        Route::resource('academic-term', 'AcademicTermController');
        // Route::get('/academic-term', 'AcademicTermController@index');
        // Route::post('/academic-term', 'AcademicTermController@store');
        // Route::get('/academic-term/{schoolTerm}', 'AcademicTermController@edit');
        // Route::patch('/academic-term/{schoolTerm}', 'AcademicTermController@update');

        // Grades
        Route::get('/grades', 'GradeController@index');
        Route::get('/grades/current', 'GradeController@failedGrades');

        // Grades Api
        Route::get('/api/grades', 'Api\GradeController@index');
        Route::get('/api/failed-grades', 'Api\GradeController@failedGrades');
    });

    Route::group(['prefix' => 'webapi', 'namespace' => 'Api'], function () {
        Route::group(['namespace' => 'Group'], function () {
            Route::get('group/datatables', 'GroupController@dataTable');
            Route::get('group/pending/{group}', 'GroupController@pendingRequests');
            Route::get('group/fetch-members/{group}', 'GroupController@fetchMembers');

            Route::post('group/join-request', 'GroupController@joinRequest');
            Route::post('group/accept/{group}/{user}', 'GroupController@acceptRequest');
            Route::post('group/decline/{group}/{user}', 'GroupController@declineRequest');

            Route::post('group/leave-class/{group}/{user}', 'GroupController@leaveClass');
            Route::post('group/kick/{group}/{user}', 'GroupController@kickMember');

            Route::post('group/settings/{group}', 'GroupSettingController@updateSettings');

            // Group Post
            Route::get('group/posts/{group}', 'GroupPostController@index');
            Route::post('group/post/{group}', 'GroupPostController@store');
            Route::delete('group/post/{id}', 'GroupPostController@destroy');

            // Group Post Like
            Route::post('group/like-post/{id}', 'GroupPostLikeController@store');

            // Group Comment
            Route::post('group/comment/{group}', 'GroupPostCommentController@store');
            Route::delete('group/comment/{id}/{groupId}', 'GroupPostCommentController@destroy');

            // Group Comment Like
            Route::post('group/like-post-comment/{id}', 'GroupPostCommentLikeController@store');

            // Group Grade
            Route::post('group/{group}/{user}/update-grade', 'GroupGradeController@updateGrade');
        });
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
    Route::get('groups/create', 'Group\GroupController@create');
    Route::post('groups/create', 'Group\GroupController@store');
    Route::get('groups/{group}', 'Group\GroupController@group');

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
    Route::get('{user}', 'SearchController@index')->name('user.profile');
});
