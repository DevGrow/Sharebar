App.Views ||= {}

(($) ->
  class App.Views.Index extends Backbone.View
    el: '#sharebar-admin .content'
    template: JST['templates/index']

    initialize: () ->
      console.log('hi')
      @render()

    render: ->
      $(@el).html @template()

    addOne: (todo) ->

    addAll: ->

    filterOne: (todo) ->

    filterAll: ->

    newAttributes: ->

    createOnEnter: (e) ->

    clearCompleted: ->

    toggleAllComplete: ->
) jQuery