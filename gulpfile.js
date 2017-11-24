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

var gulpif = require('gulp-if'); 
var prompt = require('gulp-prompt');
var rsync  = require('gulp-rsync');
var argv   = require('minimist')(process.argv);

gulp.task('check', function() {
  repoWatch({
          repository: 'https://zeronicola3@bitbucket.org/zeronicola3/tema_woodflow.git'
      })
    .on('check', function() {
      git.fetch('', '', {args: '--all'}, function (err) {
        if (err) throw err;
      });
      gulp.watch(['./*.php'], ['changed']);
      gulp.watch(['./css/sass/*.scss','./css/sass/vc_styles/*.scss'], ['changed']);
      gulp.watch('./js/src/*.js', ['uglify','changed']);

    })
    .on('change', function(newHash, oldHash) {
      console.log('Changed from ', oldHash, ' to ', newHash);
    });
});

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
// Dirs and Files to sync
  rsyncPaths = ['sass', 'css', 'font', 'img', 'js', './*.php', './style.css'];
// Default options for rsync
  rsyncConf = {
    progress: true,
    incremental: true,
    relative: true,
    emptyDirectories: true,
    recursive: true,
    clean: true,
    exclude: ['css/stile.css','css/atf.css','js/theme.js','gulpfile.js'],
  };

  rsyncConf.hostname = '165.227.145.153'; // hostname
  rsyncConf.username = 'root'; // ssh username
  rsyncConf.destination = '~/DOCKER/multi/woodflow2/home/wp/wp-content/themes/zeronicola3-tema_woodflow-b0fbb3ab3fa6/'; // path where uploaded files go

    // Use gulp-rsync to sync the files 
  return gulp.src(rsyncPaths)
  .pipe(gulpif(
      argv.production, 
      prompt.confirm({
        message: 'Heads Up! Are you SURE you want to push to PRODUCTION?',
        default: false
      })
  ))
  .pipe(rsync(rsyncConf));
 
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

/* compile all your Sass
  gulp.task('sass', function (){
    gulp.src(['./css/sass/*.scss', '!./css/sass/_*.scss', '!./css/stile.css'])
      .pipe(plumber(plumberErrorHandler))
      .pipe(sass({errLogToConsole: true}))
      /*.pipe(plumber(plumberErrorHandler))
      .pipe(sass({
        includePaths: ['./css/sass'],
        outputStyle: 'nasted'
      }))
      .pipe(prefix(
        "last 1 version", "> 1%", "ie 8", "ie 7"
        ))
      .pipe(gulp.dest('./css'))
      .pipe(minifycss())
      .pipe(gulp.dest('./css'));
  /}); */ 

  // Uglify JS
    gulp.task('uglify', function(){
      gulp.src('./js/src/*.js')
        .pipe(plumber(plumberErrorHandler))
        .pipe(uglify())
        /*
        .pipe(concat('theme.js'))
        .pipe(gulp.dest('./js/'));
        */
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
  gulp.watch(['./*.php'], ['changed']);
  gulp.watch(['./css/sass/*.scss','./css/sass/**/*.scss'], ['changed']);
  gulp.watch('./js/src/*.js', ['uglify','changed']);

});

gulp.task('changed', function(callback) {
  runSequence(
    'deploy',
    'commit-changes',
    'pull',
    'push-changes',

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


/*
var runSequence = require('run-sequence');
var gutil = require('gulp-util');
var git = require('gulp-git');
var fs = require('fs');

gulp.task('commit-changes', function () {
  return gulp.src('.')
    .pipe(git.add())
    .pipe(git.commit('[Prerelease] Bumped version number'));
});

gulp.task('push-changes', function (cb) {
  git.push('origin', 'master', cb);
});
 
gulp.task('pull', function(){
  git.pull('origin', 'master'], function (err) {
    if (err) throw err;
  });
});

gulp.task('seq', function (callback) {
  runSequence(
    'commit-changes',
    'push-changes',
    'create-new-tag',
    'github-release',
    function (error) {
      if (error) {
        console.log(error.message);
      } else {
        console.log('RELEASE FINISHED SUCCESSFULLY');
      }
      callback(error);
    });
});

*/
