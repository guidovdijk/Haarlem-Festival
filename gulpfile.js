const gulp = require("gulp");
const sass = require("gulp-sass");
const browserSync = require("browser-sync").create(); //https://browsersync.io/docs/gulp#page-top
const php = require('gulp-connect-php');
const runSequence = require('run-sequence').use(gulp);

const imagemin = require("gulp-imagemin");
const htmlmin = require("gulp-htmlmin");
const autoprefixer = require('gulp-autoprefixer');
const webpack = require('webpack-stream');
const cache = require('gulp-cache');
const del = require('del');

const filePath = {
    baseDir: "./dist",
    js: "src/assets/scripts/**/*.js",
    html: "src/**/*.html",
    php: "src/**/*.php",
    scss: "src/assets/styles/**/*.scss",
    images: "src/assets/images/**/*",
    dist: {
        js: "./dist/assets/scripts",
        html: "./dist",
        php: "./dist",
        scss: "./dist/assets/styles",
        images: "dist/assets/images",
    }
}

// Clean dist folder
gulp.task('clean', () => {
    return del(['dist/**', '!dist']);
});

// Images
gulp.task('images', function(){
    gulp.src(filePath.images)
        .pipe(cache(imagemin()))
        .pipe(gulp.dest(filePath.dist.images));
});


// Scripts
gulp.task('js', function(){
   return gulp.src(filePath.js)
        .pipe(webpack({
            mode: 'development',
            watch: true,
            output: {
                filename: 'index.js'
            },
            module: {
                rules: [{
                    test: /\.js$/,
                    exclude: /(node_modules|bower_components)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env']
                        }
                    }
                }]
            }
        }))
        .pipe(gulp.dest(filePath.dist.js));
});

// Compile Sass
gulp.task('css', function(){
    gulp.src(filePath.scss)
        .pipe(sass({ outputStyle: "compressed" }).on("error", sass.logError))
        .pipe(autoprefixer({
            browserlist: ['last 2 versions'],
            cascade: false
        }))
        .pipe(gulp.dest(filePath.dist.scss))
        // Stream changes to all browsers
        .pipe(browserSync.stream());
});

// Process Nunjucks
gulp.task('nunjucks', function(){
    gulp.src([filePath.html, filePath.php])
        .pipe(htmlmin({
            collapseWhitespace: true,
            ignoreCustomFragments: [ /<%[\s\S]*?%>/, /<\?[=|php]?[\s\S]*?\?>/ ]
        }))
        .pipe(gulp.dest(filePath.baseDir));
});


// Build dist folder
gulp.task('build', function(){
    const tasks = ['js', 'css', 'images', 'nunjucks'];

    runSequence(tasks);
});

// Create browser sync with proxy
gulp.task('browserSync', ['build'], function() {
    php.server({
        base: filePath.baseDir + "/", port:8080, keepalive:true
    }, function(){
        browserSync.init({
            proxy:"localhost:8080",
            baseDir: "./",
            open: true,
            notify: false,
            injectChanges: true,
        });
    })
});

// Run development enviorement
gulp.task('dev', function() {
    runSequence('clean', 'browserSync');

    gulp.watch(filePath.scss, ['css']);
    gulp.watch(filePath.js, ['js']).on("change", browserSync.reload);
    gulp.watch(filePath.images, ['images']).on("change", browserSync.reload);
    gulp.watch([filePath.html, filePath.php], ['nunjucks']).on("change", browserSync.reload);
});