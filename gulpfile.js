var gulp = require('gulp');
var minifyCss = require("gulp-minify-css");
var uglify = require("gulp-uglify");
var jshint = require('gulp-jshint');
 
gulp.task('minify-css', function () {
    return gulp.src('./www/symfony/web/bundles/ecl/css/**/*.css')
        .pipe(minifyCss())
        .pipe(gulp.dest('./www/symfony/web/bundles/ecl/css.min/'));
});
gulp.task('minify-js', function () {
    gulp.src('./www/symfony/web/bundles/ecl/js/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./www/symfony/web/bundles/ecl/js.min/'));
}); 
gulp.task('lint', function() {
    return gulp.src('./www/symfony/web/bundles/ecl/js/**/*.js')
        .pipe(jshint({ "multistr": true, "laxbreak": true }))
        .pipe(jshint.reporter());
});

gulp.task('default', ['minify-css', 'minify-js', 'lint']);