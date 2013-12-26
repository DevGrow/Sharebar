window.App =
  VERSION_MAJOR:      '2'
  VERSION_MINOR:      '0'
  VERSION_TINY:       '1'
  VERSION_PRE:        ''
  Models:           {}
  Collections: {}
  Routers: {}
  Views: {}
  version: ->
    _.compact([ @VERSION_MAJOR, @VERSION_MINOR, @VERSION_TINY, @VERSION_PRE ]).join('.')