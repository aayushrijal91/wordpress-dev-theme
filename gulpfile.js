const path = require('path');
const gulp = require('gulp');
const browserSync = require('browser-sync').create();
const imagemin = require('gulp-imagemin');
const del = require('del');
const sourcemaps = require('gulp-sourcemaps');
// const autoprefixer = require('gulp-autoprefixer');
const sass = require('gulp-sass')(require('sass'));
const cssnano = require('gulp-cssnano');
const concat = require('gulp-concat');
const cache = require('gulp-cached');
const uglify = require('gulp-uglify-es').default;

// Definitions
var src = './src/';
var build = '../wp-content/themes/aiims/';

var sources = {
    theme: `${src}theme-files/**/*`,
    images: [`${src}assets/images/**/*`],
    styles: `${src}assets/styles/**/*`,
    scripts: `${src}assets/scripts/**/*`,
    fonts: `${src}assets/fonts/**/*`,
    data_files: `${src}assets/files/**/*`,
    vendor_scripts: [].concat.apply([], [
        './node_modules/bootstrap/dist/js/bootstrap.min.js',
        './node_modules/lazyload/lazyload.min.js',
        './node_modules/magnific-popup/dist/jquery.magnific-popup.js',
        './node_modules/slick-carousel/slick/slick.min.js',
    ]),
}
var destinations = {
    images: `${build}images/`,
    styles: `${build}styles/`,
    scripts: `${build}scripts/`,
    fonts: `${build}/styles/fonts/`,
    data_files: `${build}files/`,
}

function theme() {
    return gulp.src(sources.theme)
        .pipe(gulp.dest(build))
}

function images() {
    return gulp.src(sources.images)
        .pipe(cache('images'))
        .pipe(imagemin())
        .pipe(gulp.dest(destinations.images))
};

/**
 * Compile sass files to css and write sourcemaps for development
 */
function styles() {
    return gulp.src(sources.styles)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', function (err) {
            console.error(err.message);
            browserSync.notify('<pre style="text-align: left">' + err.message + '</pre>', 10000);
            this.emit('end');
        }))
        // .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(gulp.dest(destinations.styles))
        .pipe(browserSync.stream({
            match: '**/*.css'
        }))
}
// custom font needs its web fonts in the root directory
function fonts() {
    return gulp.src(sources.fonts)
        .pipe(gulp.dest(destinations.fonts))
}

// data file for the calculator
function data_files() {
    return gulp.src(sources.data_files)
        .pipe(gulp.dest(destinations.data_files))
}

function vendor_scripts() {
    return gulp.src(sources.vendor_scripts)
        .pipe(sourcemaps.init())
        .pipe(concat('vendor.min.js'))
        .pipe(sourcemaps.write())
        .pipe(uglify())
        .pipe(gulp.dest(destinations.scripts))
}

function custom_scripts() {
    return gulp.src(sources.scripts)
        .pipe(concat('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(destinations.scripts))
}

function clean() {
    return del(build + '**/*', {
        force: true
    })
}

function watch() {
    browserSync.init({
        proxy: encodeURI(`localhost/projects/${path.resolve(__dirname, '../').split(path.sep).pop()}/`),
        injectChanges: true,
    });

    gulp.watch(sources.images, images).on('change', browserSync.reload);
    gulp.watch(sources.theme, theme).on('change', browserSync.reload);
    gulp.watch(sources.scripts, custom_scripts).on('change', browserSync.reload);
    gulp.watch(sources.scripts, vendor_scripts).on('change', browserSync.reload);
    gulp.watch(sources.data_files, data_files).on('change', browserSync.reload);
    gulp.watch(sources.styles, styles);
}

exports.watch = gulp.series(
    clean,
    gulp.parallel(
        theme,
        images,
        fonts,
        data_files,
        custom_scripts,
        vendor_scripts,
        styles
    ),
    watch
)