var gulp = require('gulp'),
	  sass = require('gulp-sass'),
	  browserSync = require('browser-sync').create(),
	  plumber = require('gulp-plumber'),
	  bulkSass = require('gulp-sass-bulk-import');


gulp.task( 'sass', function(){
		return gulp.src('views/sass/**/*.scss')
				  .pipe(bulkSass())
				  .pipe(sass({outputStyle:'compressed'})).on('error', sass.logError)
				  .pipe(gulp.dest('app/css/'));
});

gulp.task( 'browser-sync', function(){
		browserSync.init({
			proxy: 'http://localhost:8080/'
		});
});

gulp.task( 'watch', function(){
		gulp.watch('views/sass/**/*.scss', ['sass'] ).on('change', browserSync.reload);
		gulp.watch('app/**/*.php').on('change', browserSync.reload);
		gulp.watch('app/js/**/*.js').on('change', browserSync.reload);
		gulp.watch('views/**/*.php').on('change', browserSync.reload);
		gulp.watch('controllers/**/*.php').on('change', browserSync.reload);
});

gulp.task( 'default', ['sass','browser-sync', 'watch']);
