const App = {

    highlightSearch: function() {
        $(function() {
            $(".search").focus().select();
        });
    },

    appDisplay: function() {
        console.log('TVPP Init')
    },

    init: function() {

        const self = this;

        // Display status
        this.appDisplay();

        // highlight search term

        $(function() {
            self.highlightSearch()
        });



        return
    }
}

export { App }