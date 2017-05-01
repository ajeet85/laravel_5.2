module.exports = function(grunt) {

    // All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        modernizr: {
          dist: {
            "crawl": false,
            "customTests": [],
            "dest": "public/js/modernizr/modernize.js",
            "tests": [
                "touchevents",
                "backgroundsize"
            ],
            "options": [
              "setClasses"
            ],
            "uglify": true
          }
        },

        // Move production assets into the right place
        bowercopy:
        {
            options: {},
            js: {
                options:{
                    destPrefix: 'public/js'
                },
                files:{
                    'jquery/jquery.js' : 'jquery/dist/jquery.min.js',
                    'velocity/velocity.js' : 'velocity/velocity.min.js',
                    'angular/angular.js' : 'angular/angular.min.js',
                    'angular/angular-animate.js' : 'angular-animate/angular-animate.min.js',
                    'angular/angular-aria.js' : 'angular-aria/angular-aria.min.js',
                    'angular/angular-message.js' : 'angular-messages/angular-messages.min.js',
                    'angular/angular-material.js' : 'angular-material/angular-material.min.js'
                }
            }
        },

        sass: {
            dist: {
                options: {
                    includePaths: [
                        'vendor_bower',
                        'vendor_private/sass'
                    ],
                    style: 'compressed',
                    sourcemap: 'none',
                    noCache: true,
                    quiet: true
                },
                files: {
                    'public/css/main.css': 'vendor_private/sass/main.scss',
                }
            }
        },

        watch: {
            php: {
                files: ['app/**/*.php', 'database/**/*.php', 'tests/**/*.php', 'config/**/*.php'],
                tasks: ['exec:phpunit'],
                options: {
                    interval: 800,
                    spawn: true,
                },
            },
            sass: {
                files: ['vendor_private/**/*.scss'],
                tasks: ['sass:dist'],
                options: {
                    interval: 800,
                    spawn: true,
                },
            }
        },

        exec: {
            phpunit: {
                cmd: function(firstName, lastName) {
                    return 'docker exec -t trackerapp /var/www/html/vendor/bin/phpunit';
                },
                exitCodes:[0,129]
            }
        }

    });


    // Tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-bowercopy');
    grunt.loadNpmTasks('grunt-exec');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks("grunt-modernizr");

    grunt.registerTask('css',['sass:dist']);
    grunt.registerTask('production', ['sass:dist', 'bowercopy:js']);
    grunt.registerTask('modernize', ['modernizr:dist']);

};
