(function() {
    tinymce.create('tinymce.plugins.sn_help', {
        init : function(ed, url) {
            ed.addButton('sn_help', {
                title : 'How to use shortcodes',
                image : url+'/help.png',
                onclick : function() {
                    window.open('http://theseniores.com/support/documentation/#content-shortcodes', '_blank');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('sn_help', tinymce.plugins.sn_help);
})();