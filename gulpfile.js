var gulp = require('gulp');
var less = require('gulp-less');
var wrap = require('gulp-wrap');
var concat = require('gulp-concat');
var declare = require('gulp-declare');
var handlebars = require('gulp-handlebars');

gulp.task('templates', function() {
    // Load templates from the client/templates/ folder relative to where gulp was executed
    gulp.src('resources/handlebars/**/*.hbs')
        // Compile each Handlebars template source file to a template function
        .pipe(handlebars())
        // Wrap each template function in a call to Handlebars.template
        .pipe(wrap('Handlebars.template(<%= contents %>)'))
        // Declare template functions as properties and sub-properties of MyApp.templates
        .pipe(declare({
            namespace: 'App.templates',
            noRedeclare: true, // Avoid duplicate declarations
            processName: function(filePath) {
                // Allow nesting based on path using gulp-declare's processNameByPath()
                // You can remove this option completely if you aren't using nested folders
                // Drop the client/templates/ folder from the namespace path by removing it from the filePath
                console.log(filePath);
                return declare.processNameByPath(filePath.replace('resources\\handlebars\\', ''));
            }
        }))
        // Concatenate down to a single file
        .pipe(concat('templates.js'))
        // Write the output into the build folder
        .pipe(gulp.dest('public/js/'));
});

gulp.task('less', function() {
    gulp.src('resources/assets/less/**/*.less')
        .pipe(less({
            //paths: [ path.join(__dirname, 'less', 'includes') ]
        }))
        .pipe(gulp.dest('public/css/'));
});
gulp.task('default', ['templates']);