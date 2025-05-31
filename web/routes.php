<?php
require_once(BASE_PATH.'config/Router.php');

$router = new Router();


$router->get('/users', 'UserController', 'getAll');
$router->get('/users/{id}', 'UserController', 'getById');

$router->get('/', 'AuthController', 'viewLogin'); 

$router->get('/log-in', 'AuthController', 'viewLogin'); 
$router->post('/log-in', 'AuthController', 'handleLogin'); 

$router->get('/logout','AuthController','handleLogout');

$router->get('/register', 'UserController', 'viewRegister'); 
$router->post('/register', 'UserController', 'handleRegister'); 

$router->get('/teacher/dashboard', 'TeacherController', 'dashboard'); 
$router->get('/student/dashboard', 'StudentController', 'dashboard'); 

$router->get('student/playground','StudentController','viewPlayground');
$router->get('student/problems','ProblemController','viewProblemList');
$router->get('student/problems/{slug}','ProblemController','viewProblem');


//student to contest functions
$router->get('/student/contest/finished','StudentController','viewFinishedContests');
$router->get('/student/profile', 'StudentController', 'viewProfile'); 
$router->post('contest/{contestId}/finished','ContestController','handleContestsScore');
$router->post('/student/profile', 'StudentController', 'handleProfile'); 
$router->post('/compile', 'CompilerController','runCode');
$router->post('/student/solo-join/{id}','ContestController','handleAddParticipant');
$router->post('/student/quit/{id}','ContestController','handleQuitParticipant');



//teacher
$router->get('teacher/manage-problems','TeacherController','viewManangeProblems');
$router->post('teacher/manage-problems','ProblemController','handleCreateProblem');
$router->post('teacher/manage-problems/{slug}','ProblemController','handleDeleteProblem');
$router->get('/teacher/profile', 'TeacherController', 'viewProfile'); 
$router->post('/teacher/profile', 'TeacherController', 'handleProfile'); 

//manage-problem
$router->post('teacher/manage-problems/update/{slug}','ProblemController','handleUpdateProblem');
$router->get('teacher/manage-problems/update/{slug}','ProblemController','viewProblemUpdate');

//manage-contests
$router->post('teacher/manage-contests/participants/accept/{id}','ContestController','handleAcceptParticipant');
$router->post('teacher/manage-contests/participants/reject/{id}','ContestController','handleRejectParticipant');
$router->get('teacher/manage-contests','TeacherController','viewContests');
$router->get('teacher/manage-contests/create','TeacherController','viewCreateContest');
$router->post('teacher/manage-contests/create','ContestController','handleCreateContest');
$router->post('contest/{contestId}/submit-problem/{problemId}','SubmissionController','handleContestSubmission');
//http://localhost:3000/contest/10/submit-problem/contest/38


$router->get('teacher/manage-contests/participants/{id}','ContestController','viewParticipants');
$router->get('teacher/manage-contests/update/{id}','ContestController','viewUpdateContest');
$router->post('teacher/manage-contests/update/{id}','ContestController','handleUpdateContest');
$router->post('teacher/manage-contests/delete/{id}','ContestController','handleDeleteContest');


//solve problem
//student/problems/submit-problem/8
$router->post('student/problems/submit-problem/{id}','SubmissionController','handleCreateSubmission');
$router->get('contest/{contestId}/{problemId}','StudentController','viewContest');
$router->dispatch();
