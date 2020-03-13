import Routes from "./routes";

var Plugin = angular.module('pluginApp' , ['ngRoute']);

Plugin.config(Routes);

Plugin.controller('pluginCtrl' , function ($scope) {
    Metro.storage.setKey('WinWord_Storage');
    Metro.storage.setItem('applications' , {});

    $scope.fullscreen = function () {
        $('html').removeClass('windows-mode');
    };
});

export default Plugin