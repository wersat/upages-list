'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var browserslist = require('browserslist');

gulp.task('compile-main', function() {
  gulp.src('./assets/scss/upages.scss')
      .pipe(sourcemaps.init())
      .pipe(autoprefixer(browserslist(
        '> 5%',
        'Firefox >= 20',
        'ie >= 8',
        'iOS 7'
      )))
      .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
      .pipe(sourcemaps.write('.'))
      .pipe(gulp.dest('./assets/css/'));
});

gulp.task('watch', function() {
  gulp.watch('./assets/scss/**/*.scss', ['compile-main']);
  gulp.watch('./assets/libraries/bootstrap-sass/stylesheets/**/**/*.scss', ['compile-main']);
});
