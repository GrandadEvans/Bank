const gulp  = require('gulp'),
 notify   = require('gulp-notify'),
 codeception = require('gulp-codeception'),
 _        = require('lodash'),
 phpunit  = require('gulp-phpunit');
 
 function unit(cb) {
    gulp.src('phpunit.xml')
        .pipe(phpunit('./vendor/bin/phpunit', {notify: false}))
        .on('error', notify.onError(testNotification('fail', 'phpunit')))
        .pipe(notify(testNotification('pass', 'phpunit')));
    cb();
}
 
function testNotification(status, pluginName, override) {
    var options = {
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
        icon:    __dirname + '/node_modules/gulp-' + pluginName +'/assets/test-' + status + '.png'
    };
    options = _.merge(options, override);
  return options;
}

exports.default = function() {
    gulp.watch([
        'app/**/*.php',
        'tests/unit/**/*Test.php'
    ], unit);
  };