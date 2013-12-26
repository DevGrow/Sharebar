#global Backbone
(($) ->
  AppRouter = Backbone.Router.extend(
    routes:
      "":               "index"
      ":action":        "loadView"

    index: () =>
      App.Views.Index = new App.Views.Index()

    loadView: (action) =>
      action = action[0].toUpperCase() + action.substring(1)
      new App.Views[action]()

  )
  new AppRouter()
  Backbone.history.start()
) jQuery