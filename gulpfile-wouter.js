var gulp = require('gulp');
var $ = require('gulp-load-plugins')({
          pattern: ['gulp-*', 'del']
        });
var browserSync = require('browser-sync');
var reload = browserSync.reload;
var pngquant = require('imagemin-pngquant');
var shell = require('gulp-shell');
var runSequence = require('gulp-run-sequence');
var wiredep = require('wiredep').stream;
var glob = require('glob');
var es = require('event-stream');
var browserify = require('browserify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var vueify = require('vueify');


// Proxy
var proxy = "https://volta.loc/";


/* DEFAULT
   ============================= */

gulp.task('default', ['develop_tasks'], function() {

  browserSync({
    notify: true,
    port: 9000,
    proxy: proxy,
    ui: {
      port: 9001
    }
  });

  // watch for changes
  gulp.watch([
    'dev/js/**/*.js',
    'dev/js/**/*.vue',
    'dev/img/**/*',
    'dev/fonts/**/*',
    'templates/**/*.twig',
    ])
    .on('change', reload);

  gulp.watch('dev/sass/**/*.scss', ['css']);
  gulp.watch(['dev/js/app/**/*.js', 'dev/js/**/*.vue'], ['js']);
  gulp.watch('dev/js/vendor.js', ['vendor_js']);
  gulp.watch('dev/fonts/**/*', ['fonts']);
  gulp.watch('dev/img/**/*', ['images']);
  gulp.watch('dev/*.{png,ico}', ['favicons']);
});


/* BUILD
   ============================= */

// 'Clean' moet volledig gedaan zijn voordat aan andere taken begonnen mag worden.
gulp.task('develop_tasks', ['iconfont', 'css', 'vendor_js', 'js', 'images', 'favicons']);

gulp.task('build', ['clean'], function () {
  gulp.start([
    'iconfont', 
    'css', 
    'js_build', 
    'images', 
    'favicons'
  ]);
});

/* Styles
   ============================= */

gulp.task('css', function() {

  var SassOptions = {
    indentedSyntax: false, // false = SCSS | true = SASS
    outputStyle: 'compressed', // (nested | compact | compressed)
    precision: 10, // # decimalen
    includePaths: ['.'],
    onError: function(err) {
      $.util.beep();
      $.notify().write({ message: '\nMessage: ' + err.message + '\nin file: ' + err.file });
    }
  };

  // set minifier to false to keep Sass sourcemaps support
  var PleeeaseOptions = {
    sourcemaps: {
      "map": {
        "inline": false
      }
    },
    sass: true,
    minifier: true,
    autoprefixer: {"browsers": ["last 10 versions", "ios 6"]},
    filters: { "oldIE": true },
    rem: ["10px"],
    opacity: true,
    mqpacker: true,
    calc: true,
  };


  gulp.src('dev/sass/**/**/*.scss')
    .pipe($.plumber())
    .pipe($.sourcemaps.init())
    .pipe($.cssGlobbing({
      extensions: ['.scss']
    }))
    .pipe($.sass(SassOptions))
    .pipe($.pleeease(PleeeaseOptions))
    .pipe($.deleteLines({ 
      'filters': [
      "sourceMappingURL=data"
      ]
    }))
    .pipe($.sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/css'))
    .pipe(reload({stream: true}));
});


/* Js task
   ============================= */
const vendors = ['vue', 'vue-resource', 'vue-scroll', 'universal-ga', 'jquery'];

// Vendor files
gulp.task('vendor_js', function(done) {
  const b = browserify({
    debug: false
  });

  // require all libs specified in vendors array
  vendors.forEach(lib => {
    b.require(lib);
  });

  b.bundle()
    .pipe(source('dev/js/vendor.js'))
    .pipe(buffer())
     .pipe($.rename({
          dirname: './',
      }))
    .pipe($.uglify({ mangle: false }))
    .pipe(gulp.dest('./dist/js'))
    .on('end', done)
  ;

});

// App
gulp.task('js', function(done) {
    glob('dev/js/app/**.js', function(err, files) {
        if(err) done(err);

        var tasks = files.map(function(entry) {
            return browserify({ entries: [entry], transform: [vueify] })
              .external(vendors) // Specify all vendors as external source
              .bundle()
              .pipe(source(entry))
              .pipe($.rename({
                  dirname: './',
                  extname: '.js'
              }))
              .on('error', $.util.log)
              .pipe(buffer())
              .pipe($.uglify())
              .pipe($.sourcemaps.write('./'))
              .pipe(gulp.dest('dist/js'));
            });
        es.merge(tasks).on('end', done);
    })
});

// PRODUCTION (BUILD)
gulp.task('js_build', function(done) {
    // $.del(['dist/js/', '*.js']);
    glob('dev/js/app/**.js', function(err, files) {
        if(err) done(err);

        var tasks = files.map(function(entry) {
            return browserify({ entries: [entry], transform: [vueify] })
              // .external(vendors) // Specify all vendors as external source
              .bundle()
              .pipe(source(entry))
              .pipe($.rename({
                  dirname: './',
                  extname: '.js'
              }))
              .on('error', $.util.log)
              .pipe(buffer())
              .pipe($.uglify())
              .pipe($.sourcemaps.write('./'))
              .pipe(gulp.dest('dist/js'));
            });
        es.merge(tasks).on('end', done);
    })
});


/* IconFont
   ============================= */

gulp.task('iconfont', function(){
  return gulp.src(['dev/icons/**/*.svg'])
    .pipe($.iconfont({ fontName: 'VoltaFont' }))
    .on('codepoints', function(codepoints, options) {
      gulp.src('dev/css/fontTemplate.css')
        .pipe($.consolidate('lodash', {
          glyphs: codepoints,
          fontName: 'VoltaFont',
          fontPath: '../fonts/',
          className: 's'
        }))
        .pipe($.rename('_font.scss'))
        .pipe(gulp.dest('dev/sass/'));
    })
    .pipe(gulp.dest('dist/fonts'));
});


/* Images
   ============================= */

gulp.task('images', function () {
  return gulp.src('dev/img/**/*')
    .pipe($.changed('dist/img'))
    .pipe($.imagemin({
       progressive: true,
       svgoPlugins: [{removeViewBox: false, cleanupIDs: false}],
       use: [pngquant()]
     }))
    .pipe(gulp.dest('dist/img'));
});


/* favicons
   ============================= */

gulp.task('favicons', function () {
  return gulp.src('dev/*.{png,ico}')
    .pipe($.changed('dist/'))
    .pipe($.imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false, cleanupIDs: false}],
      use: [pngquant()]
    }))
    .pipe(gulp.dest('dist/'))
    // .pipe(reload({stream: true}));
});

/* Clean
   ============================= */
gulp.task('clean', function(done) {
    $.del(['dist', '*.php'], done);
});

/* Notify function
   ============================= */

function notify(msg) {
  $.notify().write({ message: '\nMessage: ' + msg });
}


