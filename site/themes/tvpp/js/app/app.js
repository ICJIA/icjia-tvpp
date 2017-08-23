const App = {

    init: function() {
        console.log('TVPP Init')
        return this
    },

    highlightSearch: function() {
        $(".search").focus().select();
        return this
    },

    addThis: function() {
        var addThis = document.createElement('script');
        addThis.setAttribute('src', '//s7.addthis.com/js/300/addthis_widget.js#pubid=cschweda');
        document.body.appendChild(addThis);
    }

}

export { App }