$(function () {
    $('html').addClass('windows-mode');
    $('.app-bar-menu a.app').on('click' , function () {
        $('.desktop_layer').append('<div class="p-2" data-role="window" ' +
            'data-icon="<img src=\'' + $(this).find('img').attr('src') + '\' >" ' +
            'data-title="' + $(this).attr('data-title') + '" ' +
            'data-shadow="true" data-cls-caption="bg-dark" data-place="center" ' +
            'data-width="500" data-height="300" >This is windows</div>');
    });
});

var Plugin = angular.module('pluginApp' , []);

Plugin.controller('pluginCtrl' , function ($scope) {
    $scope.fullscreen = function () {
        $('html').removeClass('windows-mode');
    };
});