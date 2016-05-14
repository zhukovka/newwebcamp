/*global module:false*/
module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        pkg: grunt.file.readJSON('package.json'),
        banner: '/*! <%= pkg.title || pkg.name %> - v<%= pkg.version %> - ' +
        '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
        '<%= pkg.homepage ? "* " + pkg.homepage + "\\n" : "" %>' +
        '* Copyright (c) <%= grunt.template.today("yyyy") %> <%= pkg.author.name %>;' +
        ' Licensed <%= _.pluck(pkg.licenses, "type").join(", ") %> */\n',
        // Task configuration.
        concat: {
            options: {
                stripBanners: true
            },
            dist: {

                src: [
                    "/bower_components/lodash/lodash.js",
                    "/bower_components/moment/moment.js",
                    "/bower_components/moment/locale/ru.js",
                    "/js/libs/xml2json.js",
                    "/bower_components/angular/angular.js",
                    "/bower_components/angular-locale-ru/angular-locale_ru.js",
                    "/bower_components/angular-route/angular-route.js",
                    "/bower_components/angular-resource/angular-resource.js",
                    "/bower_components/angular-sanitize/angular-sanitize.js",
                    "/js/courses-ng/utils.js",
                    "/js/courses-ng/calendar.js",
                    "/js/courses-ng/clock.js",
                    "/js/courses-ng/timeline.js",
                    "/js/courses-ng/enroll.js",
                    "/js/courses-ng/app.js"
                    ],
                dest: 'js/build.js'
            }
        },
        cssmin: {
            options: {
                sourceMap: true
            },
            target: {
                files: {
                    'dist/style.css': ["/fonts/foundation-icons/foundation-icons.css",'/css/main.min.css', '/css/supermain.css']
                }
            }
        },
        uglify: {
            dist: {
                src: '<%= concat.dist.dest %>',
                dest: 'dist/script.min.js'
            }
        },
        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                unused: true,
                boss: true,
                eqnull: true,
                browser: true,
                globals: {
                    jQuery: true
                }
            },
            gruntfile: {
                src: 'Gruntfile.js'
            },
            lib_test: {
                src: ['lib/**/*.js', 'test/**/*.js']
            }
        },
        qunit: {
            files: ['test/**/*.html']
        },
        sass: {                              // Task
            dist: {                            // Target
                options: {                       // Target options
                    style: 'expanded'
                },
                files: {                         // Dictionary of files
                    'css/main.css': 'sass/main.scss'       // 'destination': 'source'
                }
            }
        },
        autoprefixer: {
            options: {
                // Task-specific options go here.
                browsers: ['last 2 versions', 'ie 9']
            },
            no_dest_single: {
                src: 'css/main.css'
            }
        },
        watch: {
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            },
            lib_test: {
                files: '<%= jshint.lib_test.src %>',
                tasks: ['jshint:lib_test', 'qunit']
            },
            w_sass: {
                files: 'sass/*/*.scss',
                tasks: ['sass:dist']
            }
        },
        clean: {
            build: {
                src: ['dist/*']
            }
        }
    });

    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-qunit');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    // Default task.
    grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify']);
    grunt.registerTask('build', ['clean', 'concat', 'uglify', 'cssmin']);
    grunt.registerTask('w_style', ['watch:w_sass']);

};
