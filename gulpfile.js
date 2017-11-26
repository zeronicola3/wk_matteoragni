var gulp = require('gulp');
var repoWatch = require('gulp-repository-watch');
var gutil = require('gulp-util');
var git = require('gulp-git');
var runSequence = require('run-sequence');

// debugger

var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

//var minifycss = require('gulp-minify-css');
var prefix = require('gulp-autoprefixer');
var gulpif = require('gulp-if');
var prompt = require('gulp-prompt');
var rsync  = require('gulp-rsync');
var argv   = require('minimist')(process.argv);


// Run git fetch
// Fetch refs from all remotes
gulp.task('fetch', function(){
  git.fetch('', '', {args: '--all'}, function (err) {
    if (err) throw err;
  });
});

// Run git fetch
// Fetch refs from origin
gulp.task('fetch', function(){
  git.fetch('origin', '', function (err) {
    if (err) throw err;
  });
});


gulp.task('deploy', function() {
//* Dirs and Files to sync
  rsyncPaths = ['sass', 'css', 'font', 'img', 'js', './*.php', './style.css'];
// Default options for rsync in staging side
  rsyncConf = {
    progress: true,
    incremental: true,
    relative: true,
    emptyDirectories: true,
    recursive: true,
    clean: true,
    exclude: ['gulpfile.js'],
  };

  rsyncConf.hostname = '159.89.24.83'; // hostname
  rsyncConf.username = 'serverpilot'; // ssh username
  rsyncConf.destination = '/srv/users/serverpilot/apps/matteoragni/public/wp-content/themes/wk_matteoragni_dev/'; // path where uploaded files go
  //rsyncConf.password = 'jg26sx7Thj82hgRf3';

// Default options for rsync in production side
  rsyncConfProd = {
    progress: true,
    incremental: true,
    relative: true,
    emptyDirectories: true,
    recursive: true,
    clean: true,
    exclude: ['gulpfile.js'],
  };

  rsyncConfProd.hostname = '159.89.24.83'; // hostname
  rsyncConfProd.username = 'serverpilot'; // ssh username
  rsyncConfProd.destination = '/srv/users/serverpilot/apps/matteoragni/public/wp-content/themes/wk_matteoragni/';

    // Use gulp-rsync to sync the files
  return gulp.src(rsyncPaths)
  .pipe(gulpif(
      argv.production,
      prompt.confirm({
        message: 'Heads Up! Are you SURE you want to push to PRODUCTION?',
        default: false
      })
  ))
  .pipe(rsync(rsyncConfProd));

});

function throwError(taskName, msg) {
  throw new gutil.PluginError({
      plugin: taskName,
      message: msg
    });
}

  var plumberErrorHandler = { errorHandler: notify.onError({
      title: 'Gulp',
      message: 'Error: <%= error.message %>'
    })
  };

// compile all your Sass
  gulp.task('sass', function (){
    gulp.src(['./css/sass/*.scss', '!./css/sass/_*.scss', '!./css/stile.css'])
      //.pipe(plumber(plumberErrorHandler))
      .pipe(sass({errLogToConsole: true}))
      .pipe(plumber(plumberErrorHandler))
      .pipe(sass({
        includePaths: ['./css/sass'],
        outputStyle: 'nasted'
      }))
      .pipe(prefix(
        "last 1 version", "> 1%", "ie 8", "ie 7"
        ))
      .pipe(gulp.dest('./css'))
      //.pipe(minifycss())
      .pipe(gulp.dest('./css'));
    });

  // Uglify JS
    gulp.task('uglify', function(){
      gulp.src('./js/src/*.js')
        .pipe(plumber(plumberErrorHandler))
        .pipe(uglify())
        .pipe(concat('theme.js'))
        .pipe(gulp.dest('./js/'));

    });



gulp.task('commit-changes', function () {
  return gulp.src('.')
    .pipe(git.add())
    .pipe(git.commit('[mac2]'));
});

gulp.task('push-changes', function (cb) {
  git.push('origin', 'master', cb);
});

gulp.task('default', function () {
  gulp.watch(['./*.php','./img/*'], ['changed']);
  gulp.watch(['./css/sass/*.scss','./css/sass/**/*.scss'], ['sass','changed']);
  gulp.watch('./js/src/*.js', ['uglify','changed']);

});

gulp.task('changed', function(callback) {
  runSequence(
      'deploy',
      'commit-changes',                              // <---
      'pull',                                        // <---    INIBITORE COMMIT
      'push-changes',                                // <---

    function (error) {
      if (error) {
        console.log(error.message);
      } else {
        console.log('RELEASE FINISHED SUCCESSFULLY');
      }
      callback(error);
    });
});


gulp.task('pull', function(){
  git.pull('origin', 'master', function (err) {
    if (err) throw err;
  });
});
