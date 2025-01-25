const { src, dest, watch, series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const autoprefixer = require('autoprefixer');
const postcss = require('gulp-postcss');
const sourcemaps = require('gulp-sourcemaps');
const cssnano = require('cssnano');
const terser = require('gulp-terser-js');
const imagemin = require('gulp-imagemin'); // Minificar imágenes
const notify = require('gulp-notify');
const cache = require('gulp-cache');
const clean = require('gulp-clean');
const webp = require('gulp-webp');

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js',
    imagenes: 'src/img/**/*'
};

// Función para procesar CSS en desarrollo
function cssDev() {
    return src(paths.scss)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/css'));
}

// Función para procesar CSS en producción
function cssBuild() {
    return src(paths.scss)
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(dest('dist/css'));
}

// Función para procesar JavaScript en desarrollo
function javascriptDev() {
    return src(paths.js)
        .pipe(sourcemaps.init())
        .pipe(terser())
        .pipe(sourcemaps.write('.'))
        .pipe(dest('public/build/js'));
}

// Función para procesar JavaScript en producción
function javascriptBuild() {
    return src(paths.js)
        .pipe(terser())
        .pipe(dest('dist/js'));
}

// Minificar imágenes en desarrollo
function imagenesDev() {
    return src(paths.imagenes)
        .pipe(cache(imagemin({ optimizationLevel: 3 })))
        .pipe(dest('public/build/img'))
        .pipe(notify({ message: 'Imagen Completada' }));
}

// Minificar imágenes para producción
function imagenesBuild() {
    return src(paths.imagenes)
        .pipe(imagemin({ optimizationLevel: 3 }))
        .pipe(dest('dist/img'));
}

// Crear versión WebP en desarrollo
function versionWebpDev() {
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest('public/build/img'))
        .pipe(notify({ message: 'Imagen Completada' }));
}

// Crear versión WebP para producción
function versionWebpBuild() {
    return src(paths.imagenes)
        .pipe(webp())
        .pipe(dest('dist/img'));
}

// Limpiar la carpeta `dist` antes de un build
function cleanDist() {
    return src('dist', { read: false, allowEmpty: true }).pipe(clean());
}

// Watcher para desarrollo
function watchArchivos() {
    watch(paths.scss, cssDev);
    watch(paths.js, javascriptDev);
    watch(paths.imagenes, imagenesDev);
    watch(paths.imagenes, versionWebpDev);
}

// Tarea para desarrollo
exports.dev = parallel(cssDev, javascriptDev, imagenesDev, versionWebpDev, watchArchivos);

// Tarea para producción
exports.build = series(cleanDist, parallel(cssBuild, javascriptBuild, imagenesBuild, versionWebpBuild));
