source 'https://rubygems.org'

group :development do

  # Sass, Compass and extensions.
  gem "sass", "~> 3.3"                    # Sass.
  gem "sass-globbing", "= 1.1.0"           # Import Sass files based on globbing pattern.
  gem 'compass', '~> 1.0.0.rc.1'             # Framework built on Sass.
  gem "compass-validator", "~> 3.0.1"       # So you can `compass validate`.
  gem "compass-normalize", ">= 1.5"       # Compass version of normalize.css.
  gem "compass-rgbapng", "~> 0.2.1"         # Turns rgba() into .png's for backwards compatibility.
  gem "singularitygs", ">= 1.2"          # Alternative to the Susy grid framework.
  gem "toolkit", "~> 2.4"                # Compass utility from the fabulous Snugug.
  gem "breakpoint", "~> 2.4"             # Manages CSS media queries.
  gem "css_parser", ">= 1.3"             # Helps `compass stats` output statistics.
  gem 'breakpoint-slicer', '~> 1.3'
  # Guard
  gem 'guard'                   # Guard event handler.
  gem 'guard-compass'           # Compile on sass/scss change.
  gem 'guard-shell'             # Run shell commands.
  gem 'guard-livereload'        # Browser reload.
  gem 'yajl-ruby'               # Faster JSON with LiveReload in the browser.

  # Dependency to prevent polling. Setup for multiple OS environments.
  # Optionally remove the lines not specific to your OS.
  # https://github.com/guard/guard#efficient-filesystem-handling

  gem 'rb-fsevent', :require => false                # Mac OSX


end
