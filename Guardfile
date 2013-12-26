# Guard file used to compile assets on the fly
guard 'sprockets', :destination => 'assets/javascripts', :asset_paths => 'app/javascripts', :minify => false do
  watch (%r{^app\/javascripts\/sharebar.js.*}){ |m| "assets/javascripts/sharebar.js" }
  watch (%r{^app\/javascripts\/((?!sharebar).)*\.js.*}){ |m| "assets/javascripts/application.js" }
end
guard 'sprockets', :destination => 'assets/stylesheets', :asset_paths => 'app/stylesheets', :minify => false do
  watch (%r{^app\/stylesheets\/sharebar.css.*}){ |m| "assets/stylesheets/sharebar.css" }
  watch (%r{^app\/stylesheets\/((?!sharebar).)*\.css.*}){ |m| "assets/stylesheets/application.css" }
end