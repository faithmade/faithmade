var gulp         = require('gulp');
var sass         = require('gulp-sass');
var notify       = require("gulp-notify");
var minifyCSS    = require('gulp-minify-css');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('sass', function () {
  gulp.src('./assets/scss/**/*.scss')
    .pipe(sass({
      errLogToConsole: false
    }))
    .on('error', notify.onError())
    .pipe(autoprefixer())
    .pipe(minifyCSS())
    .pipe(gulp.dest('./'))
    .pipe(notify({ message: 'Build Complete' }));
});

gulp.task('watch', function() {
  gulp.watch('./assets/scss/**/*.scss', ['sass']);
});

gulp.task('default', ['build', 'watch'], function() {});
gulp.task('build', ['sass'], function() {});
