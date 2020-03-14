import WinWord from './plugin';
WinWord.app.controller('winwordemailCtrl' , function ($scope , View) {
    View.display('email.html' , $scope , 'winwordemail');
});