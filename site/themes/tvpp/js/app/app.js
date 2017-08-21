const App = {

    init: function() {
        console.log('TVPP Init')
        return this
    },

    highlightSearch: function() {
        $(".search").focus().select();
        return this
    }

}

export { App }