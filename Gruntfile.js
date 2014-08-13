'use strict';
module.exports = function(grunt) {
  // Load all tasks
  require('load-grunt-tasks')(grunt);
  // Show elapsed time
  require('time-grunt')(grunt);

  var jsFileList = [
    'assets/js/plugins/*.js',
    'assets/js/_*.js'
  ];

  grunt.initConfig({
    concurrent: {
        dev: ['compass:dev', 'watch'],
        options: {
            logConcurrentOutput: true
        },
    },
    jshint: {
      options: {
        jshintrc: '.jshintrc'
      },
      all: [
        '!.sass-cache/**/*',
        'Gruntfile.js',
        'assets/js/*.js',
        '!assets/js/scripts.js',
        '!assets/**/*.min.*'
      ]
    },
    compass: {
      options: {
        config: 'config.rb',
        bundleExec: true,
        force: true,
      },
      dev: {
        options: {
          watch: true,
          environment: 'development',
        }
      },
      build: {
        options: {
          environment: 'production'
        }
      },
      ie:{
        options:{
          config: 'config.rb',
          bundleExec: true,
          force: true,
          environment: 'production',
          sassDir:'assets/ie-scss'
        }
      }
    },
    cssmin: {
      minify: {
        expand: true,
        cwd: 'assets/css/',
        src: ['*.css', '!*.min.css'],
        dest: 'assets/css/',
        ext: '.min.css'
      }
    },
    concat: {
      options: {
        separator: ';',
      },
      dist: {
        src: [jsFileList],
        dest: 'assets/js/scripts.js',
      },
    },
    uglify: {
      dist: {
        files: {
          'assets/js/scripts.min.js': [jsFileList]
        }
      }
    },
    modernizr: {
      build: {
        devFile: 'assets/vendor/modernizr/modernizr.js',
        outputFile: 'assets/js/vendor/modernizr.min.js',
        files: {
          'src': [
            ['assets/js/scripts.min.js'],
            ['assets/css/main.min.css']
          ]
        },
        uglify: true,
        parseFiles: true
      }
    },
    version: {
      default: {
        options: {
          format: true,
          length: 32,
          manifest: 'assets/manifest.json',
          querystring: {
            style: 'roots_css',
            script: 'roots_js'
          }
        },
        files: {
          'lib/scripts.php': 'assets/{css,js}/{main,scripts}.min.{css,js}'
        }
      }
    },
    watch: {
      js: {
        files: [
          jsFileList,
          '<%= jshint.all %>'
        ],
        tasks: ['jshint', 'concat']
      },
      livereload: {
        // Browser live reloading
        // https://github.com/gruntjs/grunt-contrib-watch#live-reloading
        options: {
          livereload: true
        },
        files: [
          'assets/css/main.css',
          'assets/js/scripts.js',
          'templates/*.php',
          '*.php'
        ]
      }
    }
  });

  // Register tasks
  grunt.registerTask('default', [
    'c'
  ]);
  grunt.registerTask('build', [
    'jshint',
    'compass:build',
    'compass:ie',
    'cssmin',
    'uglify',
    'modernizr',
    'version'
  ]);
  grunt.registerTask('c', [
    'concurrent:dev'
  ]);
};
