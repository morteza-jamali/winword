var Plugin_First = {
    selectors : {
        app : '.app-bar-menu a.app'
    }
};

$(function () {
    var getApplications = function() {
        return Metro.storage.getItem('applications');
    };

    var setApplicationRunning = function(app) {
        $(Plugin_First.selectors.app).parent().addClass('bd-cyan');
        var _applications = getApplications();
        _applications[app] = 'running';
        Metro.storage.setItem('applications' , _applications);
    };

    var getApplicationStatus = function(app) {
        var _applications = getApplications();
        return  _applications[app];
    };

    var removeApplication = function(app) {
        $(Plugin_First.selectors.app).parent().removeClass('bd-cyan');
        var _applications = getApplications();
        delete _applications[app];
        Metro.storage.setItem('applications' , _applications);
    };

    $('html').addClass('windows-mode');

    $(Plugin_First.selectors.app).on('click' , function () {
        var _app_status = getApplicationStatus($(this).attr('data-slug'));
        if(_app_status !== 'running') {
            setApplicationRunning($(this).attr('data-slug'));
            $('.desktop_layer').append('<div class="p-2" data-role="window" ' +
                'data-icon="<img src=\'' + $(this).find('img').attr('src') + '\' >" ' +
                'data-title="' + $(this).attr('data-title') + '" ' +
                'data-shadow="true" data-cls-caption="bg-dark" data-place="center" ' +
                'data-width="500" data-height="300" ><div ng-controller="' +
                $(this).attr('data-slug') + 'Ctrl" data-slug="' + $(this).attr('data-slug') + '" ' +
                'class="app-content"></div></div>');
        } else {

        }
    });

    $('body').on('click' , '.window .window-caption .btn-close' , function () {
        removeApplication(
            $(this).parents('.window').find('.window-content .app-content').attr('data-slug')
        );
    });
});
