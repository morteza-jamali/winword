$(function () {
    $('html').addClass('windows-mode');
});

var Plugin = angular.module('pluginApp' , []);

Plugin.controller('pluginCtrl' , function ($scope) {
    $scope.fullscreen = function () {
        $('html').removeClass('windows-mode');
    };
});